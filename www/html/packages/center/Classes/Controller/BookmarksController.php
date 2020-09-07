<?php

namespace DigitalZombies\Center\Controller;

use DigitalZombies\Center\Configuration\ScopeConfiguration;
use DigitalZombies\Center\Domain\Repository\Bookmarks\BookmarksRepository;
use DigitalZombies\Center\Domain\Repository\RecordBaseRepository;
use DigitalZombies\Center\Helper\TemplateHelper;

use DigitalZombies\Ecesugarcrm\Constants\ProviderTypes;
use DigitalZombies\Ecesugarcrm\Domain\Repository\SugarCrmRepository;
use DigitalZombies\Ecesugarcrm\Utility\RandomUtility;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Extensionmanager\Utility\ConfigurationUtility;

/**
 * Class BookmarksController
 * @package DigitalZombies\Center\Controller
 */
class BookmarksController extends ActionController
{
	/** @var SugarCrmRepository $sugarCrmRepository */
	protected $sugarCrmRepository = null;

	/** @var BookmarksRepository $bookmarksRepository */
	protected $bookmarksRepository = null;

	/** @var RecordBaseRepository $recordBaseRepository */
	protected $recordBaseRepository;

	protected $extConfig = [];

	protected $tablenames = [
		'coupon' => 'tx_center_domain_model_records_coupon',
		'events' => 'tx_center_domain_model_records_event',
		'news' => 'tx_center_domain_model_records_news',
		'offer' => 'tx_center_domain_model_records_offer',
	];

	protected $languageKeys = [
		'empty' => 'fe.bookMarksTeaserWall.no_results',
		'userLogin' => 'fe.bookMarksTeaserWall.login',
		'check' => 'fe.bookMarksTeaserWall.check',
		'uncheck' => 'fe.bookMarksTeaserWall.uncheck',
		'coupon' => 'fe.teaserWall.category.tx_center_domain_model_records_coupon',
		'event' => 'fe.teaserWall.category.tx_center_domain_model_records_event',
		'news' => 'fe.teaserWall.category.tx_center_domain_model_records_news.news',
		'offer' => 'fe.teaserWall.category.tx_center_domain_model_records_offer'
	];

	protected $center = '';

	protected $communicationLine = '';

	protected $userUid = '';

	protected $settings = [];

	public function __construct()
	{
		parent::__construct();
		$this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
		$this->extConfig = $this->objectManager->get(ConfigurationUtility::class)
			->getCurrentConfiguration('ecesugarcrm');

		$this->sugarCrmRepository = $this->objectManager->get(SugarCrmRepository::class);
		$this->bookmarksRepository = $this->objectManager->get(BookmarksRepository::class);
		$this->recordBaseRepository = $this->objectManager->get(RecordBaseRepository::class);

		$this->sugarCrmRepository->initializeConnection(
			$this->extConfig['sugarcrm.server']['value'],
			$this->extConfig['sugarcrm.username']['value'],
			$this->extConfig['sugarcrm.password']['value']);

		$this->center = ScopeConfiguration::getScope();
		$this->userUid = $GLOBALS['TSFE']->fe_user->user['uid'];
		$this->communicationLine = ScopeConfiguration::getScope()->getCommunicationLine() ?
			ScopeConfiguration::getScope()->getCommunicationLine()->getTitle() : '';

		/** @var ConfigurationManagerInterface $configurationManager */
		$configurationManager = $this->objectManager->get(ConfigurationManagerInterface::class);

		$this->settings = $configurationManager->getConfiguration(
			ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
			'center'
		);

	}

	public function checkAction()
	{
		if (!$this->isLoggedInUser()) {
			$this->response->setStatus(401);
			return false;
		};

		$item = explode('-', $this->request->getArgument('item'));
		$endtime = explode('-', $this->request->getArgument('enddate'));
		$this->storeBookmark($this->userUid, $item, $endtime[0], $this->center->getUid());

		return $this->getHint($this->languageKeys['check'], $this->communicationLine, 'center');
	}

	public function uncheckAction()
	{
		$item = explode('-', $this->request->getArgument('item'));

		$this->deleteBookmark($this->userUid, $item, $this->center->getUid());

		if ($this->request->hasArgument('fh') && $this->request->getArgument('fh') == 1) {
			$results = $this->getRecentBookmarks(6);

			if (count($results) > 1) {
				$bookmarks = $this->makeArray($results);
				$newBookmark['bookmark'][] = end($bookmarks['bookmark']);

				return $this->renderBookmarkHeaderTemplate($newBookmark);
			}
		}

		return $this->getHint($this->languageKeys['uncheck'], $this->communicationLine, 'center');
	}

	public function loadBookmarksAction()
	{
		$results = $this->getRecentBookmarks(6);

		if (count($results) > 0) {
			$bookmarks = $this->makeArray($results);
			return $this->renderBookmarkHeaderTemplate($bookmarks);

		} else {
			return $this->getHint($this->languageKeys['empty'], $this->communicationLine, 'center');
		}

	}

	private function renderBookmarkHeaderTemplate($bookmarks)
	{
		$bookmarksList = TemplateHelper::generateTemplate(
			$bookmarks,
			'BookmarksNavigation',
			'EXT:providerece/Resources/Private/Templates/Page/Header',
			'EXT:providerece/Resources/Private/Partials/Page/Header;EXT:providerece/Resources/Private/Partials/Elements',
			'EXT:providerece/Resources/Private/Layouts/Page/Header'
		);

		return $bookmarksList;
	}

	private function getRecentBookmarks($qty)
	{
		$elements = 0;
		$this->settings['teaserwall']['types'] = implode(',', $this->tablenames);
		$this->settings['teaserwall']['bookmarksOnly'] = 1;
		$this->settings['teaserwall']['sorting'] = RecordBaseRepository::SORTING_BOOKMARKS;

		return $this->recordBaseRepository->findRecords($this->center, $this->settings['teaserwall'], $elements, $qty);
	}

	public function loadBookmarksIdsAction()
	{
		if (!$this->isLoggedInUser()) {
			$this->response->setStatus(401);
			return false;
		};

		$bookmarks = $this->bookmarksRepository->getBookmarkByUserIdAndCenterId(
			$GLOBALS['TSFE']->fe_user->user['uid'],
			$this->center->getUid()
		);

		$prefix = '';
		$bookmarks = array_map(function ($el) {
			if ($el['tablename'] == 'tx_center_domain_model_records_coupon') {
				$prefix = 'c-';
			}

			if ($el['tablename'] == 'tx_center_domain_model_records_event') {
				$prefix = 'e-';
			}

			if ($el['tablename'] == 'tx_center_domain_model_records_news') {
				$prefix = 'n-';
			}

			if ($el['tablename'] == 'tx_center_domain_model_records_offer') {
				$prefix = 'o-';
			}

			return $prefix . $el['item_id'];
		}, $bookmarks);

		return json_encode($bookmarks);
	}

	private function buildUri($pid, $controller, $action, $extension, $arguments)
	{
		$this->uriBuilder
			->reset()
			->setTargetPageUid($pid)
			->setArguments($arguments)
			->uriFor($action, $arguments, $controller);

		$uri = $this->uriBuilder->build();

		return $uri;
	}

	private function makeArray($bookmarks)
	{
		$items = [];
		$data = [];
		$prefix = '';
		$category = '';
		$detailPage = '';
		$controller = '';
		$teaserDate = '';

		foreach ($bookmarks as $bookmark) {
			if ($bookmark->getEndtime() >= time() || $bookmark->getEndtime() == 0) {
				if ($bookmark->getPartialName() == 'Coupon') {
					$prefix = 'c-';
					$href = $this->buildUri(
						$this->settings['detailPages']['coupon'],
						'Coupon',
						'show',
						'center',
						['coupon' => $bookmark->getUid()]
					);

					$category = $this->getHint($this->languageKeys['coupon'], $this->communicationLine, 'center');
					$teaserDate = $bookmark->getTeaserDate();
				}

				if ($bookmark->getPartialName() == 'Event') {
					$prefix = 'e-';
					$href = $this->buildUri(
						$this->settings['detailPages']['event'],
						'Event',
						'show',
						'center',
						['event' => $bookmark->getUid()]
					);
					$category = $this->getHint($this->languageKeys['event'], $this->communicationLine, 'center');
					$teaserDate = $bookmark->getTeaserDate();
				}

				if ($bookmark->getPartialName() == 'News') {
					$prefix = 'n-';
					$href = $this->buildUri(
						$this->settings['detailPages']['news'],
						'News',
						'show',
						'center',
						['news' => $bookmark->getUid()]
					);
					$category = $this->getHint($this->languageKeys['news'], $this->communicationLine, 'center');
					$teaserDate = date('d.m.Y', $bookmark->getTeaserDate());
				}

				if ($bookmark->getPartialName() == 'Offer') {
					$prefix = 'o-';
					$href = $this->buildUri(
						$this->settings['detailPages']['offer'],
						'Offer',
						'show',
						'center',
						['offer' => $bookmark->getUid()]
					);
					$category = $this->getHint($this->languageKeys['offer'], $this->communicationLine, 'center');
					$teaserDate = $bookmark->getTeaserDate();
				}

				$items['bookmark'][] = [
					'id' => $prefix . $bookmark->getUid(),
					'uid' => $bookmark->getUid(),
					'partialName' => $bookmark->getPartialName(),
					'title' => $bookmark->getTitle(),
					'teaserAbstract' => $bookmark->getTeaserAbstract(),
					'teaserDate' => $teaserDate,
					'teaserImageUid' => $bookmark->getTeaserImage()->getUid(),
					'columnClassName' => $bookmark->getColumnClassName(),
					'category' => $category,
					'endtime' => $bookmark->getEndtime(),
					'href' => $href,
				];
			}
		}

		return $items;
	}

	private function isLoggedInUser()
	{
		return ($GLOBALS['TSFE']->loginUser && is_array($GLOBALS['TSFE']->fe_user->user)) ? true : false;
	}

	private function isRegisteredUser($email = null)
	{
		$userName = !is_null($email) ? $email : $GLOBALS['TSFE']->fe_user->user['username'];
		$user = $this->sugarCrmRepository->findUserByUsername($userName, ProviderTypes::SUGARCRM);

		return $user ? true : false;
	}

	private function storeBookmark($userId, $item, $endtime, $centerId)
	{
		$existsItem = $this->bookmarksRepository->getBookmarkByUserItemIds($userId, $item[1], $this->center->getUid());

		switch ($item[0]) {
			case 'c':
				if ($existsItem == 0) {
					$this->bookmarksRepository->storeBookmark($userId, $item[1], $endtime, $this->center->getUid(), $this->tablenames['coupon']);
					return true;
				}
				return false;
				break;
			case 'e':
				if ($existsItem == 0) {
					$this->bookmarksRepository->storeBookmark($userId, $item[1], $endtime, $this->center->getUid(), $this->tablenames['events']);
					return true;
				}
				return false;
				break;
			case 'n':
				if ($existsItem == 0) {
					$this->bookmarksRepository->storeBookmark($userId, $item[1], $endtime, $this->center->getUid(), $this->tablenames['news']);
					return true;
				}
				return false;
				break;
			case 'o':
				if ($existsItem == 0) {
					$this->bookmarksRepository->storeBookmark($userId, $item[1], $endtime, $this->center->getUid(), $this->tablenames['offer']);
					return true;
				}
				return false;
				break;
		}
	}

	private function deleteBookmark($userId, $item, $centerId)
	{
		switch ($item[0]) {
			case 'c':
				$this->bookmarksRepository->deleteBookmark($userId, $item[1], $this->center->getUid());
				return true;
				break;
			case 'e':
				$this->bookmarksRepository->deleteBookmark($userId, $item[1], $this->center->getUid());
				return true;
				break;
			case 'g':
				$this->bookmarksRepository->deleteBookmark($userId, $item[1], $this->center->getUid());
				return true;
				break;
			case 'n':
				$this->bookmarksRepository->deleteBookmark($userId, $item[1], $this->center->getUid());
				return true;
				break;
			case 'o':
				$this->bookmarksRepository->deleteBookmark($userId, $item[1], $this->center->getUid());
				return true;
				break;
			case 'p':
				break;
			case 's':
				$this->bookmarksRepository->deleteBookmark($userId, $item[1], $this->center->getUid());
				return true;
				break;
		}
	}

	private function getHint($key, $communicationLineTitle, $extensionName, $arguments = [])
	{
		$hint = '';
		if (mb_strtolower($communicationLineTitle) == mb_strtolower("NAME IT")) {
			$hint = LocalizationUtility::translate($key . '.informal', $extensionName, $arguments);
		}

		if (!$hint) {
			$hint = LocalizationUtility::translate($key, $extensionName, $arguments);
		}

		return $hint;
	}
}
