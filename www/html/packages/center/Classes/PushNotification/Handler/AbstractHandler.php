<?php

namespace DigitalZombies\Center\PushNotification\Handler;

use DigitalZombies\Center\Domain\Model\PushNotification\PushNotification;
use DigitalZombies\Center\Domain\Repository\Center\CenterRepository;
use DigitalZombies\Center\Domain\Repository\PushNotification\PushNotificationRepository;
use DigitalZombies\Center\PushNotification\Api\PushServiceInterface;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2018- Fabian Gehrlicher <f.gehrlicher@plan-net.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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

/**
 * Class AbstractHandler
 * @package DigitalZombies\Center\PushNotification\Handler
 */
abstract class AbstractHandler implements HandlerInterface
{
    const LOGTYPE_MESSAGE = 0;
    const LOGTYPE_SYSTEM_ERROR = 2;

    /**
     * @var PushServiceInterface
     */
    protected $pushService;

    /**
     * @var PushNotificationRepository
     * @inject
     */
    protected $pushNotificationRepository;

    /**
     * @var CenterRepository
     */
    protected $centerRepository;

    /**
     * @var PersistenceManager
     */
    protected $persistenceManager;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * AbstractHandler constructor.
     */
    public function __construct()
    {
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->centerRepository = $this->objectManager->get(CenterRepository::class);
        $this->pushNotificationRepository = $this->objectManager->get(PushNotificationRepository::class);
        $this->persistenceManager = $this->objectManager->get(PersistenceManager::class);
    }

    /**
     * @param PushServiceInterface $pushService
     * @return null|void
     */
    public function setPushService(PushServiceInterface $pushService)
    {
        $this->pushService = $pushService;
    }

    /**
     * @param string $message
     */
    protected function logMessage(string $message)
    {
        $this->log($message, self::LOGTYPE_MESSAGE);
    }

    /**
     * @param string $message
     */
    protected function logError(string $message)
    {
        $this->log($message, self::LOGTYPE_SYSTEM_ERROR);
    }

    /**
     * @param string $message
     * @param int $type
     */
    private function log(string $message, int $type)
    {
        /** @var BackendUserAuthentication $user */
        $user = $GLOBALS['BE_USER'];
        $user->simplelog('[push notfication sender] ' . $message, $extKey = 'center', $type);
    }

    /**
     * @param PushNotification $item
     * @return bool
     */
    protected function isNotificationAllowedToSend($item) {
        if($item->isTest() && !$this->isProduction()) {
            return true;
        }
        if(!$item->isTest() && $this->isProduction()){
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    private function isProduction() {
        $context = \TYPO3\CMS\Core\Utility\GeneralUtility::getApplicationContext();
        return $context == 'Production/Live';
    }
}
