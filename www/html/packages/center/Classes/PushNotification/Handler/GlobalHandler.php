<?php

namespace DigitalZombies\Center\PushNotification\Handler;

use DigitalZombies\Center\Domain\Model\Center\Center;
use DigitalZombies\Center\Domain\Model\PushNotification\PushNotification;
use DigitalZombies\Center\PushNotification\Api\Config\FirebaseAppConfig;
use DigitalZombies\Center\PushNotification\Api\TargetDeviceConfig;
use DigitalZombies\Center\PushNotification\Api\Request\FirebaseRequest;
use DigitalZombies\Center\PushNotification\Api\RequestList;

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
 * Class GlobalHandler
 * @package DigitalZombies\Center\PushNotification\Handler
 */
class GlobalHandler extends AbstractHandler
{
    /**
     * @var array
     */
    private $centers;

    /**
     * GlobalHandler constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->centers = $this->centerRepository->getAllWithApp();
    }

    /**
     * @param PushNotification $item
     * @return null|void
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function handle(PushNotification $item)
    {
        if($this->isNotificationAllowedToSend($item)) {
            /** @var RequestList $requestList */
            $requestList = $this->objectManager->get(RequestList::class);

            /** @var Center $center */
            foreach ($this->centers as $center) {

                $iosTopic = $center->getPushServerIosTopic();
                $iosKey = $center->getPushServerIosAuthorizationKey();

                if ($iosTopic && $iosKey) {
                    /** @var FirebaseRequest $request */
                    $request = $this->objectManager->get(
                        FirebaseRequest::class,
                        $this->objectManager->get(
                            FirebaseAppConfig::class,
                            $iosTopic,
                            $iosKey
                        ),
                        $this->objectManager->get(
                            TargetDeviceConfig::class,
                            TargetDeviceConfig::BROADCAST_TYPE
                        ),
                        $item
                    );
                    $requestList->attach($request);
                }
            }

            $this->pushService->sendPostRequests($requestList);

            $item->setActualDeliveryDate(new \DateTime());
            $this->pushNotificationRepository->update($item);
            $this->persistenceManager->persistAll();

            $this->logMessage(
                sprintf("Push Notification with uid: %d and title: %s was sent.", $item->getUid(), $item->getTitle())
            );
        }
    }
}
