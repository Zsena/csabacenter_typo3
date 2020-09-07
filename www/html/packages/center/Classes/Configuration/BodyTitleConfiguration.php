<?php
namespace DigitalZombies\Center\Service\Page;

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


class BodyTitleConfiguration {

	/**
	 * @var BodyTitleConfiguration
	 */
	private static $bodyTitleConfiguration= null;

	/**
	 * @var string
	 */
	protected static $title = '';

	/**
	 * @var string
	 */
	protected static $centerName = '';


	/**
	 * BodyTitleConfiguration constructor.
	 */
	private function __construct()
	{
	}

	/**
	 * Hide clone function
	 */
	private function __clone()
	{
	}

	/**
	 * Returns an intance of the BodyTitleConfiguration
	 *
	 * @return BodyTitleConfiguration
	 */
	public static function getInstance() {

		if(self::$bodyTitleConfiguration === null) {

			self::$bodyTitleConfiguration= new BodyTitleConfiguration();

			if(ScopeConfiguration::hasCenter()) {
				self::$bodyTitleConfiguration->setCenterName(ScopeConfiguration::getScope()->getCenterName());
				unset($center);
			}
		}
		return self::$bodyTitleConfiguration;
	}

	/**
	 * @return string
	 */
	public function getTitle(): string
	{
		return self::$title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle(string $title)
	{
		self::$title = $title;
	}

	/**
	 * @return string
	 */
	public function getCenterName(): string
	{
		return self::$centerName;
	}

	/**
	 * @param string $centerName
	 */
	public function setCenterName(string $centerName)
	{
		self::$centerName = $centerName;
	}
}

?>