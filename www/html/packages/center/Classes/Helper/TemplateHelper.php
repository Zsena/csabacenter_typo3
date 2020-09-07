<?php
namespace DigitalZombies\Center\Helper;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009-2015 Ingo Renner <ingo@typo3.org>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\View\StandaloneView;

/**
 *
 * @author David Miltz <D.Miltz@plan-net.com>
 */
class TemplateHelper
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
	public static function generateTemplate($variables,
																					$templateName,
																					$templatePath,
																					$partialPath = '',
																					$layoutPath = '')
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
            $partialsArray = [];
		    if(strpos($partialPath, ';') !== false) {
		        $partials = explode(';', $partialPath);
                foreach ($partials as $partial) {
                    $partialsArray[] = $partial;
		        }
            } else {
                $partialsArray[] = $partialPath;
            }
			$emailView->setPartialRootPaths($partialsArray);
		}
		if ($layoutPath) {
			$emailView->setLayoutRootPaths([1 => $layoutPath]);
		}
		$emailView->assignMultiple($variables);
		return $emailView->render();
	}
}
