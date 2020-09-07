<?php
/**
 * Created by PhpStorm.
 * User: miltzd
 * Date: 09.03.2018
 * Time: 09:08
 */

namespace DigitalZombies\Center\Handler;

use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use DigitalZombies\Center\Domain\Repository\Shop\CenterShopRepository;

class DeleteChainstoreHandler implements SingletonInterface
{

    /**
     * Delete connections between shops and chainstore if attached chainstore is deleted.
     * @param int $uid
     * @return  void
     */
    public static function updateShopAfterChainstoreDeletion($uid){

        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        /** @var \DigitalZombies\Center\Domain\Repository\Shop\CenterShopRepository $centerShopRepository */
        $centerShopRepository = $objectManager->get(CenterShopRepository::class);

        $centerShopRepository->updateShopAfterChainstoreDeletion($uid);

    }

}