<?php

namespace DigitalZombies\Center\Hooks;

/***************************************************************
 *  Copyright notice
 *
 *    Based on:
 *
 *  (c) 2017 David Miltz <D.Miltz@plan-net.com>
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

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\SingletonInterface;
use DigitalZombies\Center\Configuration\ScopeConfiguration;
use DigitalZombies\Center\Helper\TemplateHelper;

class AnalyticsRenderer implements SingletonInterface
{

	/**
	 * Adds the Analytics code to the page
	 *
	 * @param array $params Parameter
	 * @param PageRenderer $parent Parent object
	 *
	 * @return void
	 */
	public function contentPostProc(array $params, PageRenderer &$parent)
	{
		// FE Settings check
		$showGa = (bool)(isset($GLOBALS['TSFE']->config['config']['showGA']) ? $GLOBALS['TSFE']->config['config']['showGA']
			: true);

		//System Settings + FE check
		if (isset($GLOBALS['TYPO3_CONF_VARS']['SYS']['showGA']) && $GLOBALS['TYPO3_CONF_VARS']['SYS']['showGA'] && $showGa) {
			$templateName = "Analytics";
			$templatePath = 'EXT:center/Resources/Private/Templates/Center/';
			$centerCode = "";
			$eceCode = "";
			// Scope is not available in Backend
			if (TYPO3_MODE != 'BE') {
				$centerCode = $this->getSnippetCenter();
				$eceCode = $this->getSnippetECE();
				$useGtm = $this->getUseGtmEceAccount();
				$gtmCode = $this->getGtmEceAccount();
			}
			// variables for Fluid Template
			$variables = array(
				'centerSnippet' => $centerCode,
				'eceSnippet' => $eceCode,
				'useGtmCode' => $useGtm,
				'gtmCode' => $gtmCode,
				'url' => $_SERVER['HTTP_HOST']
			);
			// Fluid Template
			$snippet = TemplateHelper::generateTemplate($variables, $templateName, $templatePath);
			// Render snippet/ Template right before closing head Tag
			$parent->addHeaderData($snippet);
		}
	}

	/**
	 * Returns field gaEceAccount from center record for tracking
	 *
	 * @return string
	 */
	public function getSnippetECE()
	{
		return ScopeConfiguration::getScope() ? ScopeConfiguration::getScope()->getGaEceAccount() : "";
	}

	/**
	 * Returns field gaCenter from center record for tracking
	 *
	 * @return string
	 */
	public function getSnippetCenter()
	{
		return ScopeConfiguration::getScope() ? ScopeConfiguration::getScope()->getGaCenter() : "";
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
