<?php

namespace DigitalZombies\Center\Handler;

use DigitalZombies\Center\Domain\Repository\RecordBaseRepository;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Frontend\Page\PageRepository;
use DigitalZombies\Center\Domain\Repository\Center\CenterRepository;
use DigitalZombies\Center\Domain\Model\Center\Center;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use DigitalZombies\Center\Domain\Repository\Shop\CenterShopRepository;
/***************************************************************
 *  Copyright notice
 *
 * 	Based on:
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

class CopyCrossDomainHandler implements SingletonInterface {

    /**
     * Extracts the Center uid from fixed Page structure --> Root - Datastorage - Storagefolder
     * @param int $id
     * @return int - 0 if there is no center found (edge case), and the center uid if any.
     */

    public static function getCenterUid($id){

        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var \TYPO3\CMS\Frontend\Page\PageRepository $pageRepository */
        $pageRepository = $objectManager->get(PageRepository::class);

        /** @var $centerRootpage PageRepository */
        $rootline = $pageRepository->getRootLine(abs($id));

        $centerRootPage = self::getRootPage($rootline);

        /** @var \DigitalZombies\Center\Domain\Repository\Center\CenterRepository $centerRepository */
        $centerRepository = $objectManager->get(CenterRepository::class);
        /** @var Center $center */
        $center = $centerRepository->findByPageId($centerRootPage);
        if($center) {
        	return $center->getUid();
		}
		//If there is no center
		return 0;
    }

    /**
     * Update Inline Centershop Record of diverse Records
     * @param int $id
     * @param string $table
     * @param string $tableOrigin
     * @param string $fieldName
     * @return  void
     */
    public static function updateRecordWithNewCenter($id,$table,$fieldName,$tableOrigin){

        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        /** @var \DigitalZombies\Center\Domain\Repository\Shop\CenterShopRepository $centerShopRepository */
        $centerShopRepository = $objectManager->get(CenterShopRepository::class);

        // Get id of Storage Page
        $pid = $centerShopRepository->getStoragePid($id, $tableOrigin);
        // Get Center uid
        $centerUid = self::getCenterUid($pid);

        if($centerUid) {
            $centerShopRepository->updateRecordWithNewCenter($table, $id, $fieldName, $centerUid, $tableOrigin);
        }
    }

    /**
     * Update relation to center of diverse Records
     * @param int $id
     * @param string $table
     * @return  void
     */
    public static function clearShop($id,$table){

        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        /** @var RecordBaseRepository $recordBaseRepository */
        $recordBaseRepository = $objectManager->get(RecordBaseRepository::class);

        $recordBaseRepository->clearRecordSettings($id, $table);
    }
    /**
     * @param array $rootline
     * @return int
     */
    public static function getRootPage($rootline)
    {
        $centerUid = "";
        foreach ($rootline as $page) {
            if ($page['is_siteroot']) {
                $centerUid = $page['uid'];
                break;
            }
        }
        return $centerUid;
    }
}

?>