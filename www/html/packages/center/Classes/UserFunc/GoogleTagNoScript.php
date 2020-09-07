<?php

namespace DigitalZombies\Center\UserFunc;

/***************************************************************
 *  Copyright notice
 *
 *  Based on:
 *
 *  (c) 2018 Victor Young <V.Young@plan-net.com>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\CMS\Extbase\Object\ObjectManager;

use DigitalZombies\Center\Configuration\ScopeConfiguration;
use DigitalZombies\Center\Helper\TemplateHelper;


class GoogleTagNoScript
{
	public function renderGoogleTagsNoScript($content, $conf)
	{
		// FE Settings check
		$showGa = (bool)(isset($GLOBALS['TSFE']->config['config']['showGA']) ? $GLOBALS['TSFE']->config['config']['showGA']
			: true);

		//System Settings + FE check
		if (isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['showGA']) && $GLOBALS['TYPO3_CONF_VARS']['SYS']['showGA'] && $showGa) {
			if (TYPO3_MODE != 'BE') {
				$useGtm = $this->getUseGtmEceAccount();
				$gtmCode = $this->getGtmEceAccount();
			}

			//Render GTM code noscript
			$gtmTemplateName = "GtmNoScript";
			$gtmTemplatePath = 'EXT:center/Resources/Private/Templates/Center/';

			$variables = array(
				'useGtmCode' => $useGtm,
				'gtmCode' => $gtmCode
			);

			($variables['useGtmCode'] == 1) ?
				$noScriptGtmCode = TemplateHelper::generateTemplate($variables, $gtmTemplateName, $gtmTemplatePath) :
				$noScriptGtmCode = '';

			return $noScriptGtmCode;
		}
	}

	/**
	 * Returns field gtmEceAccount from center record for tracking
	 *
	 * @return string
	 */
	public function getGtmEceAccount()
	{
		return ScopeConfiguration::getScope() ? ScopeConfiguration::getScope()->getGtmEceAccount() : '';
	}

	/**
	 * Returns field UseGtmEceAccount from center record for tracking
	 *
	 * @return string
	 */
	public function getUseGtmEceAccount()
	{
		return ScopeConfiguration::getScope() ? ScopeConfiguration::getScope()->getUseGtmEceAccount() : '';
	}
}
