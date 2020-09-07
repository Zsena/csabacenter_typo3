<?php
namespace DigitalZombies\Center\Handler;

use DigitalZombies\Center\Domain\Model\Shop\ChainStore;
use DigitalZombies\Center\Domain\Repository\Shop\ChainStoreRepository;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
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


class ChainStoreDataHandler implements SingletonInterface {


	/**
	 * Updates the inserted record with a center ID from the parent record
	 *
	 * @param array $fieldArray
	 */
	public static function copyDataForShop(&$fieldArray) {

		/** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
		$objectManager = GeneralUtility::makeInstance(ObjectManager::class);

		/** @var ChainStoreRepository $chainStoreRepository */
		$chainStoreRepository = $objectManager->get(ChainStoreRepository::class);

		/** @var ChainStore $chainStore */
		$chainStore = $chainStoreRepository->findByUid($fieldArray['chain_store']);

		if($chainStore) {

			$fieldArray['content_text'] = $chainStore->getDescription();
			$fieldArray['phone'] = $chainStore->getPhone();
			$fieldArray['email'] = $chainStore->getEmail();
			$fieldArray['website'] = $chainStore->getWebsite();

		}
	}

	/**
	 * Updates the inserted record with a center ID from the parent record
	 *
	 * @param array $fieldArray
	 */
	public static function copyDataForShopTranslation(&$fieldArray) {

		/** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
		$objectManager = GeneralUtility::makeInstance(ObjectManager::class);

		/** @var ChainStoreRepository $chainStoreRepository */
		$chainStoreRepository = $objectManager->get(ChainStoreRepository::class);

		$description = $chainStoreRepository->getChainStoreTranslation($fieldArray['chain_store'],
			$fieldArray['sys_language_uid']);

		if($description) {

			$fieldArray['content_text'] = $description;
		}
	}
}