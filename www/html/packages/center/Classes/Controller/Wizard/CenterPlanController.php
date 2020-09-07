<?php
namespace DigitalZombies\Center\Controller\Wizard;

/**
 *
 */

use DigitalZombies\Center\Domain\Model\Center\CenterLevel;
use DigitalZombies\Center\Domain\Repository\Center\CenterLevelPositionRepository;
use DigitalZombies\Center\Domain\Repository\Center\CenterLevelRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use TYPO3\CMS\Backend\Controller\Wizard\AbstractWizardController;
use TYPO3\CMS\Backend\Template\DocumentTemplate;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Core\Database\DatabaseConnection;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/**
 * Script Class for center plan wizard
 *
 */
class CenterPlanController extends AbstractWizardController
{

	/**
	 * Wizard parameters, coming from FormEngine linking to the wizard.
	 *
	 * @var array
	 */
	public $wizardParameters;

	/**
	 * Serialized functions for changing the field...
	 * Necessary to call when the value is transferred to the FormEngine since the form might
	 * need to do internal processing. Otherwise the value is simply not be saved.
	 *
	 * @var array
	 */
	public $fieldChangeFunc;

	/**
	 * @var string
	 */
	protected $fieldChangeFuncHash;

	/**
	 * Form name (from opener script)
	 *
	 * @var string
	 */
	public $fieldName;

	/**
	 * Field name (from opener script)
	 *
	 * @var string
	 */
	public $formName;

	/**
	 * ID of element in opener script for which to set color.
	 *
	 * @var string
	 */
	public $md5ID;

	/**
	 * Document template object
	 *
	 * @var \TYPO3\CMS\Backend\Template\DocumentTemplate
	 */
	public $doc;

	/**
	 * @var string
	 */
	public $content;

	/**
	 * @var int
	 */
	protected $centerLevelUid;

	/**
	 * @var array
	 */
	protected $usedPositions;

	/**
	 * @var string
	 */
	protected $svg = '';

	/**
	 * Constructor
	 *
	 * @deprecated since TYPO3 v8, will be removed in TYPO3 v9
	 */
	public function __construct()
	{
		GeneralUtility::logDeprecatedFunction();
		parent::__construct();
		$this->getLanguageService()->includeLLFile('EXT:lang/Resources/Private/Language/locallang_wizards.xlf');
		$GLOBALS['SOBE'] = $this;

		$this->init();
	}

	protected function mapRequestParams() {
		// Setting GET vars (used in frameset script):
		$this->wizardParameters = GeneralUtility::_GP('P');
		// Setting GET vars (used in colorpicker script):
		$this->fieldChangeFunc = $this->wizardParameters['fieldChangeFunc'];
		$this->fieldChangeFuncHash = $this->wizardParameters['fieldChangeFuncHash'];
		$this->md5ID = GeneralUtility::_GP('md5ID');
		// Resolving image (checking existence etc.)
		$this->getCenterLevelUid();
	}

	/**
	 * Initialises the Class
	 *
	 * @return void
	 */
	protected function init()
	{
		// initialize parameters from the request
		$this->mapRequestParams();

		// Initialize document object:
		$this->doc = GeneralUtility::makeInstance(DocumentTemplate::class);
	}

	/**
	 * Injects the request object for the current request or subrequest
	 * As this controller goes only through the main() method, it is rather simple for now
	 *
	 * @param \Psr\Http\Message\ServerRequestInterface $request
	 * @param \Psr\Http\Message\ResponseInterface $response
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function mainAction(ServerRequestInterface $request, ResponseInterface $response)
	{
		$this->prepareRendering();

		$this->prepareJS();

		$this->renderResponse($response);

		return $response;
	}

	protected function prepareRendering() {
		$this->svg = $this->getCenterLevelImages();
	}

	/**
	 * Renders the content of the wizard
	 *
	 * @param \Psr\Http\Message\ResponseInterface $response
	 */
	protected function renderResponse(&$response) {
		// Start page:
		$this->content .= $this->doc->startPage($this->getLanguageService()->getLL('colorpicker_title'));

		$this->content .= $this->svg;

		$this->content .= $this->doc->endPage();
		$this->content = $this->doc->insertStylesAndJS($this->content);

		$response->getBody()->write($this->content);
	}

	/**
	 * It sets the JS Plugin.
	 * Important: At this point we assign each variable to the plugin, so they need to be filled.
	 */
	protected function prepareJS(){

		$update = [];
		if ($this->areFieldChangeFunctionsValid()) {
			// Setting field-change functions:
			foreach ($this->fieldChangeFunc as $command) {
				$update[] = 'parent.opener.' . $command;
			}
		}

		GeneralUtility::makeInstance(PageRenderer::class)->loadRequireJsModule(
			'TYPO3/CMS/Center/Wizard/Centerplan',
			"function(Centerplan) {
				Centerplan.setFieldChangeFunctions({
					itemName: '" . $this->wizardParameters['itemName'] . "',
					centerLevelId: '" . $this->centerLevelUid . "',
					currentValue: '" . $this->wizardParameters['currentValue'] . "',
					usedPositions: " . json_encode($this->usedPositions) . ",
					fieldChangeFunctions: function() {"
			. implode('', $update) .
			"}
				});
			}"
		);
	}

	/**
	 * @return string
	 */
	protected function getCenterLevelImages() {
		$content = '';
		if($this->centerLevelUid > 0) {
			$objectManager = GeneralUtility::makeInstance(ObjectManager::class);

			/** @var \DigitalZombies\Center\Domain\Repository\Center\CenterLevelRepository $centerLevelRepository */
			$centerLevelRepository = $objectManager->get(CenterLevelRepository::class);

			/** @var \DigitalZombies\Center\Domain\Repository\Center\CenterLevelPositionRepository $centerLevelPositionRepository */
			$centerLevelPositionRepository = $objectManager->get(CenterLevelPositionRepository::class);

			/** @var CenterLevel $centerLevel */
			$centerLevel = $centerLevelRepository->findByUid($this->centerLevelUid);

			if (isset($centerLevel)
				&& $centerLevel->getImage()) {

				$this->usedPositions = [];

				/** @var \TYPO3\CMS\Core\Resource\File $originalFile */
				$originalFile = $centerLevel->getImage()->getOriginalResource()->getOriginalFile();

				$absPath = GeneralUtility::getFileAbsFileName($originalFile->getPublicUrl());

				//load the file without xml parsing if it was already processed.
				//PERFORMANCE
				$loadOnly = $originalFile->hasProperty('tx_center_svg_processed')
					&& $originalFile->getProperty('tx_center_svg_processed');

				$svgData = $this->generateSVG($absPath, $loadOnly, $centerLevel->getUid());

				$positions = $centerLevelPositionRepository->findByCenterLevel($this->centerLevelUid);

				if(isset($positions)) {
					foreach ($positions as $position) {
						$positionId = $position->getPathID();
						if($positionId
							&& !in_array($positionId, $this->usedPositions)) {
							$this->usedPositions[] = $positionId;
						}
					}

				}

				//Save the modified content into the svg data
				if(!$loadOnly) {
					$this->saveProcessedSVG($originalFile->getProperty('uid'),
						$absPath,
						$svgData,
						$centerLevelPositionRepository);
				}

				$content .= $svgData;
			}
		}
		return $content;
	}

	/**
	 * Sets the centerUid from the settings
	 */
	protected function getCenterLevelUid() {
		// Get this record
		$record = BackendUtility::getRecord($this->wizardParameters['table'], $this->wizardParameters['uid']);
		if($record) {
			$this->centerLevelUid = $record['center_level'];
		}
	}

	/**
	 * Determines whether submitted field change functions are valid
	 * and are coming from the system and not from an external abuse.
	 *
	 * @return bool Whether the submitted field change functions are valid
	 */
	protected function areFieldChangeFunctionsValid()
	{
		return serialize($this->fieldChangeFunc) && $this->fieldChangeFuncHash && $this->fieldChangeFuncHash === GeneralUtility::hmac(serialize($this->fieldChangeFunc));
	}

	/**
	 * @param int $sysFileUid
	 * @param string $pathToFile
	 * @param string $svgData
	 * @param \DigitalZombies\Center\Domain\Repository\Center\CenterLevelPositionRepository $centerLevelPositionRepository
	 */
	protected function saveProcessedSVG($sysFileUid, $pathToFile, $svgData, $centerLevelPositionRepository) {
		$fileHandle = fopen($pathToFile,"w");
		fwrite($fileHandle,$svgData);
		fclose($fileHandle);

		$centerLevelPositionRepository->svgProcessed($sysFileUid);
	}

	/**
	 * It loads an svg as an xml and adds id attributes to the "svg" and "path" nodes.
	 *
	 * @param string $pathToFile  absolute path to the image to load (an svg)
	 * @param boolean $loadOnly  set if the svg was rendered once through this function
	 * @param int $levelId  id for the <svg> tag and for the element prefixes
	 * @return mixed
	 */
	protected function generateSVG($pathToFile, $loadOnly = false, $levelId = 0) {

		$fileHandle = fopen($pathToFile,"r");
		$svgData = fread($fileHandle,filesize($pathToFile));
		fclose($fileHandle);

		if(!$loadOnly) {
			$svg = new \SimpleXMLElement($svgData);

			$svg->registerXPathNamespace('svg', 'http://www.w3.org/2000/svg');

			$currentId = 1;
			if (!isset($svg['id'])) {
				$svg->addAttribute('id', $levelId);
			}

			$groupShops = $svg->xpath('svg:g[@id="shops"]');

			$this->setIdForGroupElements($groupShops, $levelId, $currentId);

			$currentId = 10000;

			$groupServices = $svg->xpath('svg:g[@id="service-targets"]');

			$this->setIdForGroupElements($groupServices, $levelId, $currentId);

			$svgData = $svg->asXML();

			$this->updatePathData($levelId);
		}

		return $svgData;
	}

	/**
	 * Handle a group of elements and add an ID to all
	 *
	 * @param \SimpleXMLElement[] $groups
	 * @param integer $levelId the levelId of the current plan
	 * @param integer $currentId the current objectId
	 */
	protected function setIdForGroupElements($groups, $levelId, &$currentId) {
		$maxId = 0;
		if (isset($groups[0])) {
			$levelIdentifier = 'p'. $levelId;

			foreach ($groups[0]->children() as $path) {
				if(substr($path['id'], 0, strlen($levelIdentifier)) == $levelIdentifier) {
					$elementId = (int)str_replace($levelIdentifier . '-', '', $path['id']);
					if($maxId < $elementId) {
						$maxId = $elementId;
					}
				}
			}

			if($maxId) {
				$currentId = $maxId + 1;
			}

			foreach ($groups[0]->children() as $path) {
				if($this->handlePath($path, $levelIdentifier, $currentId)) {
					$currentId++;
				}
			}

		}
	}

	/**
	 * TODO Remove in v01.05.00
	 *
	 * @deprecated
	 * @param $centerLevelUid
	 */
	protected function updatePathData($centerLevelUid) {
		/** @var DatabaseConnection $dbConnection */
		$dbConnection = $GLOBALS['TYPO3_DB'];
		$dbConnection->exec_UPDATEquery("tx_center_domain_model_center_centerlevelposition",
			"center_level = $centerLevelUid AND object_position != '' AND object_position NOT LIKE 'p%'" ,
			[
				'object_position' => "CONCAT('p', REPLACE(REPLACE(object_position, SUBSTRING_INDEX(object_position, '_', 1), center_level), '_', '-'))"
			],
			true
			);
	}

	/**
	 * @param \SimpleXMLElement $path
	 * @param string $levelIdentifier
	 * @param int $currentId
	 *
	 * @return boolean
	 */
	protected function handlePath($path, $levelIdentifier, $currentId){
		$unsetId = (isset($path['id'])
			&& substr($path['id'], 0, strlen($levelIdentifier)) !== $levelIdentifier);

		if($unsetId) {
			unset($path['id']);
		}
		if(!isset($path['data-enabled'])) {
			$path->addAttribute('data-enabled', 1);
		}
		if(!isset($path['id']) || $unsetId) {
			$path->addAttribute('id', $levelIdentifier . '-' . $currentId);

			return true;
		}
		return false;
	}
}