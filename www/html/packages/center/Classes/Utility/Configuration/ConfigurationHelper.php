<?php
namespace DigitalZombies\Center\Utility\Configuration;

use TYPO3\CMS\Core\TypoScript\TypoScriptService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/***************************************************************
 *  Copyright notice
 *
 *    Based on:
 *
 *  (c) 2017 András Ottó <andras.otto@plan-net.com>
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


class ConfigurationHelper
{

	/**
	 * @var array
	 */
	private static $configurationCache = [];


	/**
	 * Returns the TypoScript configuration for an extension
	 *
	 * @param string $extKey
	 * @return array
	 */
	public static function getConfiguration($extKey  = 'center') {
		if(!array_key_exists($extKey, self::$configurationCache)) {
			self::$configurationCache[$extKey] = self::getExtConfiguration($extKey);
		}

		return self::$configurationCache[$extKey];
	}

	/**
	 * Returns the directions to the current center in scope
	 *
	 * @param string $extKey
	 * @return array
	 */
	private static function getExtConfiguration($extKey) {
		$extSettings = [];
		$objectManager = GeneralUtility::makeInstance(ObjectManager::class);
		/** @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManager $configurationManager */
		$configurationManager = $objectManager->get(ConfigurationManagerInterface::class);
		$settings = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT);

		$mainConfigurationKey = 'tx_' . $extKey . '.';

		if(isset($settings['plugin.'][$mainConfigurationKey]['settings.'])) {

			$settings = $settings['plugin.'][$mainConfigurationKey]['settings.'];

			/** @var TypoScriptService $typoscriptService */
			$typoscriptService = $objectManager->get(TypoScriptService::class);

			$extSettings = $typoscriptService->convertTypoScriptArrayToPlainArray($settings);
		}

		return $extSettings;
	}
}


?>