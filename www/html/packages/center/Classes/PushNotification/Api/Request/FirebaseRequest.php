<?php

namespace DigitalZombies\Center\PushNotification\Api\Request;

use DigitalZombies\Center\Domain\Model\PushNotification\PushNotification;
use DigitalZombies\Center\PushNotification\Api\AbstractRequest;
use DigitalZombies\Center\PushNotification\Api\Config\FirebaseAppConfig;
use DigitalZombies\Center\PushNotification\Api\TargetDeviceConfig;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2019- Fabian Gehrlicher <f.gehrlicher@plan-net.com>
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
class FirebaseRequest extends AbstractRequest
{
    /**
     * @var FirebaseAppConfig
     */
    private $firebaseAppConfig;

    /**
     * FirebaseRequest constructor.
     * @param FirebaseAppConfig $firebaseAppConfig
     * @param TargetDeviceConfig $targetDeviceConfig
     * @param PushNotification $pushNotification
     * @throws \DigitalZombies\Center\PushNotification\Api\IllegalObjectLinkException
     * @throws \DigitalZombies\Center\PushNotification\Api\InvalidPushRequestException
     * @throws \TYPO3\CMS\Core\Exception
     */
    public function __construct(FirebaseAppConfig $firebaseAppConfig, TargetDeviceConfig $targetDeviceConfig, PushNotification $pushNotification)
    {
        parent::__construct($targetDeviceConfig, $pushNotification);
        $this->setTopic($firebaseAppConfig->getTopic());
        $this->firebaseAppConfig = $firebaseAppConfig;
    }

    /**
     * @param $topic
     */
    private function setTopic($topic)
    {
        $this->requestData["to"] = "/topics/" . $topic;
    }

    /**
     * @return string
     */
    public function renderBody(): string
    {
        return json_encode($this->requestData);
    }

    /**
     * @return array
     */
    public function renderHeaders(): array
    {
        return array_merge(
            parent::renderHeaders(),
            [
                'Authorization: key=' . $this->firebaseAppConfig->getAppKey()
            ]
        );
    }

    /**
     * @return string
     */
    public function getEndpointUrl(): string
    {
        return "";
    }
}