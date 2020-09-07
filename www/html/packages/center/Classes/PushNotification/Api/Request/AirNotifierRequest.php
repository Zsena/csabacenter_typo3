<?php

namespace DigitalZombies\Center\PushNotification\Api\Request;

use DigitalZombies\Center\Domain\Model\PushNotification\PushNotification;
use DigitalZombies\Center\PushNotification\Api\AbstractRequest;
use DigitalZombies\Center\PushNotification\Api\Config\AirNotifierAppConfig;
use DigitalZombies\Center\PushNotification\Api\TargetDeviceConfig;
use DigitalZombies\Center\PushNotification\Api\InvalidPushRequestException;

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
 * Class AirnotifierRequest
 * @package DigitalZombies\Center\PushNotification\Api\Request
 */
class AirNotifierRequest extends AbstractRequest
{
    const BROADCAST_ENDPOINT = 'api/v2/broadcast/';
    const PUSH_ENDPOINT = 'api/v2/push/';

    const TYPE_ENDPOINT_MAPPING = [
        TargetDeviceConfig::SINGLE_TOKEN_TYPE => self::PUSH_ENDPOINT,
        TargetDeviceConfig::MULTI_TOKEN_TYPE => self::PUSH_ENDPOINT,
        TargetDeviceConfig::BROADCAST_TYPE => self::BROADCAST_ENDPOINT,
    ];

    /**
     * @var AirNotifierAppConfig
     */
    private $airNotifierAppConfig;

    /**
     * AirNotifierRequest constructor.
     * @param TargetDeviceConfig $targetDeviceConfig
     * @param PushNotification $pushNotification
     * @param AirNotifierAppConfig $airNotifierAppConfig
     * @throws InvalidPushRequestException
     * @throws \DigitalZombies\Center\PushNotification\Api\IllegalObjectLinkException
     */
    public function __construct(
        TargetDeviceConfig $targetDeviceConfig,
        PushNotification $pushNotification,
        AirNotifierAppConfig $airNotifierAppConfig
    )
    {
        parent::__construct($targetDeviceConfig, $pushNotification);
        $this->airNotifierAppConfig = $airNotifierAppConfig;
        $this->endpointUrl = self::TYPE_ENDPOINT_MAPPING[$targetDeviceConfig->getPushType()];
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
                'X-An-App-Name: ' . $this->airNotifierAppConfig->getTopic(),
                'X-An-App-Key: ' . $this->airNotifierAppConfig->getAppKey(),
            ]
        );
    }

    /**
     * @return string
     */
    public function getEndpointUrl(): string
    {
        return $this->endpointUrl;
    }
}

