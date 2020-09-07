<?php
namespace DigitalZombies\Center\Handler;

use DigitalZombies\Center\Domain\Model\PositionableInterface;
use DigitalZombies\Center\Domain\Repository\Center\CenterLevelPositionRepository;
use DigitalZombies\Center\Utility\PositionableRepositoryFactory;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;


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


class CenterDataHandler implements SingletonInterface {


	/**
	 * Updates the inserted record with a center ID from the parent record
	 *
	 * @param $table
	 * @param $positionIds
	 * @param $objectId
	 */
	public static function fillCenterId($table, $positionIds, $objectId) {

		$centerId = 0;

		/** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
		$objectManager = GeneralUtility::makeInstance(ObjectManager::class);

		/** @var \TYPO3\CMS\Extbase\Persistence\Repository $positionableRepository */
		$positionableRepository = PositionableRepositoryFactory::createRepository($table, $objectManager);

		/** @var \DigitalZombies\Center\Domain\Repository\Center\CenterLevelPositionRepository $centerLevelPositionReposiorty */
		$centerLevelPositionReposiorty = $objectManager->get(CenterLevelPositionRepository::class);

		if(isset($objectId)) {

			$positonableObject = $positionableRepository->findByUid($objectId);

			if($positonableObject instanceof PositionableInterface) {
				$centerId = $positonableObject->getCenter()->getUid();
			}
		}

		$positions = $centerLevelPositionReposiorty->findByUids($positionIds);

		/** @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager $persistenceManager */
		$persistenceManager = $objectManager->get(PersistenceManager::class);

		foreach ($positions as $position) {
			$position->setCenter($centerId);
			$persistenceManager->update($position);
		}

		$persistenceManager->persistAll();
	}
}

?>