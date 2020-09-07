<?php

namespace DigitalZombies\Center\Command;

use DigitalZombies\Center\Domain\Model\PushNotification\PushNotification;
use DigitalZombies\Center\PushNotification\Api\AirNotifierApi;
use DigitalZombies\Center\PushNotification\Api\AirNotifierApiConfig;
use DigitalZombies\Center\PushNotification\Api\Config\FirebaseApiConfig;
use DigitalZombies\Center\PushNotification\Api\FirebaseApi;
use DigitalZombies\Center\PushNotification\Handler\HandlerFactory;
use TYPO3\CMS\Core\Log\LogLevel;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Extbase\Mvc\Controller\CommandController;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogManager;
use SplObjectStorage;
use ReflectionClass;
use Exception;

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
class PushNotificationCommandController extends CommandController
{
    /**
     * @var \DigitalZombies\Center\Domain\Repository\PushNotification\PushNotificationRepository
     * @inject
     */
    protected $pushNotificationRepository;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var \TYPO3\CMS\Core\Messaging\FlashMessageService
     * @inject
     */
    protected $flashMessageService;

    public function initializeObject()
    {
        $this->logger = $this->objectManager->get(LogManager::class)->getLogger(__CLASS__);
    }

    /**
     * @param string $airNotifierBaseUrl AirNotifier base url
     * @return bool
     * @throws \DigitalZombies\Center\Exception\InvalidPushNotificationSchema
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function workOnQueueCommand($airNotifierBaseUrl)
    {
        if ($this->pushNotificationRepository->getIterationPayloadCountForAllTypes() === 0) {
            return true;
        };

        /** @var AirNotifierApi $pushService */
        $pushService = $this->objectManager->get(
            FirebaseApi::class,
            $this->objectManager->get(
                FirebaseApiConfig::class,
                $airNotifierBaseUrl
            )
        );

        $iterationPayload = $this->pushNotificationRepository->getIterationPayloadForAllTypes(new SplObjectStorage());

        /** @var PushNotification $item */
        foreach ($iterationPayload as $item) {
            try {
                $type = (new ReflectionClass($item))->getName();
                HandlerFactory::getHandler($type, $pushService)->handle($item);
            } catch (Exception $exception) {
                $this->handleException($exception, $item);
            }
        }

        return true;
    }

    /**
     * @param Exception $exception
     * @param PushNotification $item
     */
    public function handleException(Exception $exception, PushNotification $item)
    {
        $message = "Push Notification Delivery failed for: " . PHP_EOL .
            "Uid: " . $item->getUid() . " Title: " . $item->getTitle() . PHP_EOL .
            "Error: " . $exception->getMessage();
        /** @var FlashMessage $flashMessage */
        $flashMessage = $this->objectManager->get(
            FlashMessage::class,
            $message,
            'Info',
            FlashMessage::ERROR,
            true
        );

        $this->logger->log(LogLevel::CRITICAL, $message);

        $this->flashMessageService
            ->getMessageQueueByIdentifier()
            ->addMessage($flashMessage);
    }
}