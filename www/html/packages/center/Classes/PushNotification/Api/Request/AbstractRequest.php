<?php

namespace DigitalZombies\Center\PushNotification\Api;

use DigitalZombies\Center\Domain\Model\PushNotification\PushNotification;
use DigitalZombies\Center\PushNotification\Api\Request\PushServiceRequestInterface;
use TYPO3\CMS\Core\Exception;

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
abstract class AbstractRequest implements PushServiceRequestInterface
{
    /**
     * @var string
     */
    protected $endpointUrl;

    /**
     * @var PushNotification
     */
    protected $pushNotification;

    /**
     * @var TargetDeviceConfig
     */
    protected $targetDeviceConfig;

    /**
     * @var array
     */
    protected $defaultHeader = [
        'Content-Type: application/json',
    ];

    /**
     * @var array
     */
    protected $requestData = [
        "to" => "",
        "registration_ids" => [
        ],
        "data" => [
            "uid" => "",
            "type" => ""
        ],
        "notification" => [
            "title" => "",
            "body" => "",
            // fetch data in background
            "content_available" => true,
        ]
    ];

    /**
     * AbstractRequest constructor.
     * @param TargetDeviceConfig $targetDeviceConfig
     * @param PushNotification $pushNotification
     * @throws Exception
     * @throws IllegalObjectLinkException
     * @throws InvalidPushRequestException
     */
    public function __construct(
        TargetDeviceConfig $targetDeviceConfig,
        PushNotification $pushNotification
    )
    {
        $pushType = $targetDeviceConfig->getPushType();
        $this->targetDeviceConfig = $targetDeviceConfig;
        $this->pushNotification = $pushNotification;

        if ($pushNotification->getLinkedElement()) {
            $this->requestData["data"]["uid"] = $pushNotification->getObjectUid();
            $this->requestData["data"]["type"] = $pushNotification->getObjectType();
        } else {
            unset($this->requestData["data"]);
        }

        $this->requestData["notification"]["title"] = $pushNotification->getTitle();
        $this->requestData["notification"]["body"] = $pushNotification->getText();

        switch ($pushType) {
            case TargetDeviceConfig::SINGLE_TOKEN_TYPE:
                //@TODO implement
                throw new Exception("Not Yet Implemented");
                break;
            case TargetDeviceConfig::MULTI_TOKEN_TYPE:
                foreach ($targetDeviceConfig->getTokens() as $token) {
                    $this->requestData["registration_ids"][] = ["token" => $token];
                }
                break;
            case TargetDeviceConfig::BROADCAST_TYPE:
                unset($this->requestData["registration_ids"]);
                break;
            default:
                throw new InvalidPushRequestException("Invalid Type");
        }
    }

    /**
     * @return array
     */
    public function renderHeaders(): array
    {
        return $this->defaultHeader;
    }
}