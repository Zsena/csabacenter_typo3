<?php
namespace DigitalZombies\Center\Hooks;

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

use DigitalZombies\Center\Handler\CenterDataHandler;
use DigitalZombies\Center\Service\GoogleMapsService;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use DigitalZombies\Center\Handler\CopyCrossDomainHandler;
use DigitalZombies\Center\Handler\DeleteChainstoreHandler;
use DigitalZombies\Center\Domain\Repository\Shop\ShopRepository;
use TYPO3\CMS\Extbase\Object\ObjectManager;

class DataHandler implements SingletonInterface {

    /**
     * @var array
     */
    const ALLOWEDTABLESINLINE = array("tx_center_domain_model_records_job", "tx_center_domain_model_records_event", "tx_center_domain_model_records_news", "tx_center_domain_model_records_offer", "tx_center_domain_model_records_coupon");
    /**
     * @var array
     */
    const ALLOWEDTABLES = array("tx_center_domain_model_records_service", "tx_center_domain_model_misc_gallery", "tx_center_domain_model_records_contentteaser");

    /**
	 * Clear cache hook
	 *
	 * @param array $params Parameter
	 * @param \TYPO3\CMS\Core\DataHandling\DataHandler $parent Parent object
	 *
	 * @return void
	 */
	public function clearCachePostProc(array $params, \TYPO3\CMS\Core\DataHandling\DataHandler &$parent) {
		$backendUser = $GLOBALS['BE_USER'];
		if($backendUser
			&& $backendUser->getTSConfigVal('tx_center.center.scope')
			&& isset($params['cacheCmd'])) {

			/** @var CacheManager $cacheManager */
			$cacheManager = GeneralUtility::makeInstance(CacheManager::class);

			$tags = [];

			if($params['cacheCmd'] === 'center') {
				$tags = [
					'css_' . intval($backendUser->getTSConfigVal('tx_center.center.scope')),
					'pageId_' . intval($backendUser->getTSConfigVal('tx_center.center.scope'))
				];
			} else if ($params['cacheCmd'] === 'teaserwalls') {
				$tags = [
					'teaserwall_' . intval($backendUser->getTSConfigVal('tx_center.center.scope'))
				];
			}
			if(count($tags) > 0) {
				$cacheManager->flushCachesByTags($tags);
			}
		}
	}

	/**
	 * This hook happens after the current values were mapped with new values. The incoming field array contains only
	 * fields that were changed by the user or by TYPO3.
	 *
	 * @param string $status
	 * @param string $table
	 * @param int $id
	 * @param array $fieldArray incoming field array (the not changed values are not in the array)
	 */
	public function processDatamap_postProcessFieldArray($status, $table, $id, array &$fieldArray) {
		if ($table === 'tx_center_domain_model_center_center'
			&& !$fieldArray['override_coordinates']
			&& (isset($fieldArray['address']) || isset($fieldArray['override_coordinates']))) {
			$location = GoogleMapsService::findCoordinatesToAddress($fieldArray['address']);
			$fieldArray['lat'] = $location['lat'];
			$fieldArray['lng'] = $location['lng'];
		}

		if ($table === 'tx_center_domain_model_center_center' &&
			isset($fieldArray['login_activated'])) {
			$fieldArray['login_activated_changed'] = time();
		}

		// Update Center when ALLOWEDTABLESINLINE and ALLOWEDTABLES are copied. Field Center is part of dataset.
        if($status=="new" && isset($fieldArray['center']) && isset($fieldArray['t3_origuid'])){
            $center = CopyCrossDomainHandler::getCenterUid($fieldArray['pid']);
            $isFromGlobalToCenter = $center != 0 && (isset($fieldArray['reference_type']) && $fieldArray['reference_type'] == 1);
            if (($fieldArray['center'] && $center != $fieldArray['center']) || $isFromGlobalToCenter ) {
                $fieldArray['center'] = CopyCrossDomainHandler::getCenterUid($fieldArray['pid']);
                if(isset($fieldArray['shop'])) {
                    $fieldArray['shop'] = 0;
                }
                if(isset($fieldArray['centers'])) {
                    $fieldArray['centers'] = 0;
                }
                if(isset($fieldArray['chain_store'])) {
                    $fieldArray['chain_store'] = 0;
                }
                if(isset($fieldArray['reference_type'])) {
                    $fieldArray['reference_type'] = 0;
                }
            }
        }
        // SET group rights for everybody for shops and Gastro
        if(($fieldArray['doktype'] == 133 || $fieldArray['doktype'] == 134) && $status=="new"){
            if($table!="pages_language_overlay"){
                $fieldArray['perms_everybody'] = 19;
            }
        }

        // Set Chain_store_tags to 0 if chainstore is resetted in shop record
        if($status=="update" && $fieldArray['chain_store']=="" && $table === 'pages' && isset($id) && isset($fieldArray['chain_store'])){
            $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
            /** @var ShopRepository $shopRepository */
            $shopRepository = $objectManager->get(ShopRepository::class);
            $shopRepository->UpdateShopAfterResetChainStore($id);
        }


    }

    /**
     * This hook happens after the record already saved in the db. Unfortunately we need to make a new update
     * to be able to fill some fields based on IRRE relations.
     *
     * @param string $status
     * @param string $table
     * @param int $id
     * @param array $fieldArray
     * @param \TYPO3\CMS\Core\DataHandling\DataHandler $pObj
     */
    public function processDatamap_afterDatabaseOperations($status, $table, $id, array &$fieldArray, \TYPO3\CMS\Core\DataHandling\DataHandler &$pObj ) {
        if(isset($pObj->newRelatedIDs['tx_center_domain_model_center_centerlevelposition'])
            && count($pObj->newRelatedIDs['tx_center_domain_model_center_centerlevelposition']) > 0) {
            CenterDataHandler::fillCenterId($table, $pObj->newRelatedIDs['tx_center_domain_model_center_centerlevelposition'], $id);
        } else {
            /** @var CacheManager $cacheManager */
            $cacheManager = GeneralUtility::makeInstance(CacheManager::class);

            //Set a change queue item to enable a later cleanup in the cache for this record
			$changeQueue = $cacheManager->getCache('center_changequeueitem');
			if(!$changeQueue->has($table . '_post_' . $id)) {
				$changeQueue->set($table . '_post_' . $id, $table . '_post_' . $id, ['changed']);
			}
			$cacheManager->flushCachesByTags([$table . '_' . $id]);
        }
        // Update Center when Job, Event, News and Offer Records are copied. Field Center is inline
        if(in_array ($table,self::ALLOWEDTABLESINLINE) && isset($fieldArray['t3_origuid'])){
            $centerUid = CopyCrossDomainHandler::getCenterUid($fieldArray['pid']);
            $fieldArray['center'] = $centerUid;
            CopyCrossDomainHandler::clearShop($id, $table);
        }
    }
    // Hook for multi select mode When Moving Records
    /**
     * In case a sys_workspace_stage record is deleted we do a hard reset
     * for all existing records in that stage to avoid that any of these end up
     * as orphan records.
     *
     * @param string $command
     * @param string $table
     * @param string $id
     * @param string $value
     * @param \TYPO3\CMS\Core\DataHandling\DataHandler $pObj
     */
    public function processCmdmap_postProcess($command, $table, $id, $value, \TYPO3\CMS\Core\DataHandling\DataHandler &$pObj) {
        // Update Center when Job, Event, News and Offer Records OR when Service, Gallery and Contentteaser are copied.
        if(($inlineTable = (in_array ($table,self::ALLOWEDTABLESINLINE) || in_array ($table,self::ALLOWEDTABLES)) && $command=="move")) {
            CopyCrossDomainHandler::updateRecordWithNewCenter($id, $table, "uid", $table);

            if($inlineTable) {
                CopyCrossDomainHandler::clearShop($id, $table);
            }
        }

        // Delete connections between shops and chainstore if attached chainstore is deleted.
        if($table=="tx_center_domain_model_shop_chainstore" && $command=="delete"){
            DeleteChainstoreHandler::updateShopAfterChainstoreDeletion($id);
        }
    }
}