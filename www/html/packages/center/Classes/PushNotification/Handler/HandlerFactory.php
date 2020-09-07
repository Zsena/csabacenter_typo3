<?php

namespace DigitalZombies\Center\PushNotification\Handler;

use DigitalZombies\Center\Domain\Model\PushNotification\CenterPushNotification;
use DigitalZombies\Center\Domain\Model\PushNotification\GlobalPushNotification;
use DigitalZombies\Center\Domain\Model\PushNotification\MultiCenterPushNotification;
use DigitalZombies\Center\Exception\HandlerException;
use DigitalZombies\Center\PushNotification\Api\PushServiceInterface;

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
 * Class HandlerFactory
 * @package DigitalZombies\Center\PushNotification\Handler
 */
class HandlerFactory
{
    /**
     * Push Notification Handler Mapping
     */
    const TYPE_MAPPING = [
        CenterPushNotification::class => SingleCenterHandler::class,
        MultiCenterPushNotification::class => MultiCenterHandler::class,
        GlobalPushNotification::class => GlobalHandler::class,
    ];

    /**
     * @var array Stores already produced handlers
     */
    static $handlerCache = [];

    /**
     * @param $targetType
     * @param PushServiceInterface $pushService
     * @return HandlerInterface
     * @throws HandlerException
     */
    public static function getHandler($targetType, PushServiceInterface $pushService): HandlerInterface
    {
        if (!(isset(self::TYPE_MAPPING[$targetType])) && self::TYPE_MAPPING[$targetType] instanceof HandlerInterface) {
            throw new HandlerException("Unsupported Type: " . $targetType);
        }

        $hash = md5($targetType . serialize($pushService));
        if (isset(self::$handlerCache[$hash])) {
            return self::$handlerCache[$hash];
        }

        $type = self::TYPE_MAPPING[$targetType];
        /** @var HandlerInterface $handler */
        $handler = new $type();
        $handler->setPushService($pushService);
        self::$handlerCache[$hash] = $handler;
        return $handler;
    }
}