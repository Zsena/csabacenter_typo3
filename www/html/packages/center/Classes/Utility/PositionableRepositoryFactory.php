<?php
namespace DigitalZombies\Center\Utility;

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

use DigitalZombies\Center\Domain\Repository\Records\ServiceRepository;
use DigitalZombies\Center\Domain\Repository\Shop\ShopRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class PositionableRepositoryFactory {

	/**
	 * Creates a repository for objects they implement the PositionableInterface
	 *
	 * @param string $tableName
	 * @param \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager
	 * @return null|\TYPO3\CMS\Extbase\Persistence\Repository
	 */
	public static function createRepository($tableName, $objectManager = null) {
		if(!isset($objectManager)){
			$objectManager = GeneralUtility::makeInstance(ObjectManager::class);
		}

		$repository = null;
		switch ($tableName) {
			case 'pages':
				$repository = $objectManager->get(ShopRepository::class);
				break;
			case 'tx_center_domain_model_records_service':
				$repository = $objectManager->get(ServiceRepository::class);
				break;
		}
		return $repository;
	}

}


?>