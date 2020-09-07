<?php
namespace DigitalZombies\Center\Configuration;

use DigitalZombies\Center\Domain\Model\Center\Center;
use DigitalZombies\Center\Domain\Repository\Center\CenterRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;


/***************************************************************
 *  Copyright notice
 *
 * 	Based on:
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


class ScopeConfiguration {

	/**
	 * @var ScopeConfiguration
	 */
	private static $scopeConfiguration = null;

	/**
	 * @var Center
	 */
	private static $center;

	/**
	 * @var \DigitalZombies\Center\Domain\Repository\Center\CenterRepository
	 */
	private static $centerRepository = null;

	/**
	 * @var bool
	 */
	private static $initialized = false;

	/**
	 * @var bool
	 */
	private static $hasCenter = false;

	/**
	 * ScopeConfiguration constructor.
	 * @param $center
	 */
	private function __construct($center)
	{
		self::$center = $center;
		self::$initialized = true;
		if($center) {
			self::$hasCenter = true;
		}
	}

	/**
	 * Hide clone function
	 */
	private function __clone()
	{
	}

	/**
	 * Returns an intance of the ScopeConfiguration
	 * This is a singleton object because we are not changing the scope in one request so we need
	 * to initialize it only once
	 *
	 * @return ScopeConfiguration
	 */
	protected static function getInstance() {

		if(self::$scopeConfiguration === null) {

			/** @var ObjectManager $objectManager */
			$objectManager = GeneralUtility::makeInstance(ObjectManager::class);

			self::$centerRepository = $objectManager->get(CenterRepository::class);

			/** @var ConfigurationManagerInterface $configurationManager */
			$configurationManager = $objectManager->get(ConfigurationManagerInterface::class);

			$setting = $configurationManager->getConfiguration(
				ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
				'center'
			);

			if(isset($setting['rootPageId'])) {
				/** @var Center $center */
				$center = self::$centerRepository->findByPageId($setting['rootPageId']);

				self::$scopeConfiguration = new ScopeConfiguration($center);
			}

		}
		return self::$scopeConfiguration;
	}

	/**
	 * Returns a Center (the current scope)
	 * This generates an instance of ScopeConfiguration if there are none yet.
	 * Only this function should be called publicly.
	 *
	 * @return Center
	 */
	public static function getScope() {
		if(self::$scopeConfiguration === null) {
			self::getInstance();
		}
		return self::$center;
	}

	/**
	 * Returns true if there is a center
	 *
	 * @return boolean
	 */
	public static function hasCenter() {
		if(!self::$initialized) {
			self::getInstance();
		}
		return self::$hasCenter;
	}

	/**
	 * Returns the current Center UID, only used in some special cases when the scope can not be recognised
	 *
	 * @return boolean
	 */
	public static function getCenterUid() {
		if(self::hasCenter()) {
			return self::getScope()->getUid();
		} else {
			$center = self::$centerRepository->findByDomainName();
			if(isset($center['uid'])) {
				return $center['uid'];
			} else {
				return -1;
			}
		}
	}
}