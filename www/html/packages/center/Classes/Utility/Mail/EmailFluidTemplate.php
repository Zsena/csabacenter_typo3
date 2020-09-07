<?php

namespace DigitalZombies\Center\Utility\Mail;

use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\View\StandaloneView;

class EmailFluidTemplate
{

	/**
	 * Renders a specified fluid template with the variables. (Note: settings is not included by default)
	 *
	 * @param array $variables
	 * @param string $templateName
	 * @param string $templatePath
	 * @param string $partialPath (optional)
	 * @param string $layoutPath (optional)
	 * @return string
	 */
	public static function generateEmailFromTemplate($variables, $templateName, $templatePath, $partialPath = '', $layoutPath = '')
	{
		/** @var ObjectManager $objectManager */
		$objectManager = GeneralUtility::makeInstance(ObjectManager::class);

		/** @var StandaloneView $emailView */
		$emailView = $objectManager->get(StandaloneView::class);
		$emailView->setFormat('html');
		$templateRootPath = GeneralUtility::getFileAbsFileName($templatePath);
		$templatePathAndFilename = $templateRootPath . '/' . $templateName . '.html';
		$emailView->setTemplatePathAndFilename($templatePathAndFilename);
		if ($partialPath) {
			$emailView->setPartialRootPaths([1 => $partialPath]);
		}
		if ($layoutPath) {
			$emailView->setLayoutRootPaths([1 => $layoutPath]);
		}
		$emailView->assignMultiple($variables);
		return $emailView->render();
	}


}