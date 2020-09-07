<?php

namespace DigitalZombies\Center\Controller;

use DigitalZombies\Center\Domain\Model\Center\Center;
use DigitalZombies\Center\Domain\Model\PushNotification\CenterPushNotification;
use DigitalZombies\Center\Domain\Model\PushNotification\GlobalPushNotification;
use DigitalZombies\Center\Domain\Model\PushNotification\MultiCenterPushNotification;
use DigitalZombies\Center\Domain\Model\PushNotification\PushNotification;
use DigitalZombies\Center\Exception\InvalidClassMappingException;
use TYPO3\CMS\Backend\Configuration\TranslationConfigurationProvider;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use ReflectionClass;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

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
class PushNotificationController extends ActionController
{
    const LL_PATH = 'LLL:EXT:center/Resources/Private/Language/locallang_module_pushnotification.xlf:';
    const CONFIG_REPOSITORY_KEY = 'repository';
    const CONFIG_PREPROCESSOR_KEY = 'preprocessor';
    const TYPE_CONFIG = [
        CenterPushNotification::class => [
            self::CONFIG_REPOSITORY_KEY => 'centerPushNotificationRepository',
            self::CONFIG_PREPROCESSOR_KEY => [
                'publishAction' => 'attachParentSiteCenterToPushNotification',
            ],
        ],
        GlobalPushNotification::class => [
            self::CONFIG_REPOSITORY_KEY => 'globalPushNotificationRepository',
            self::CONFIG_PREPROCESSOR_KEY => [
                'publishAction' => 'attachAllCentersToPushNotification'
            ],
        ],
        MultiCenterPushNotification::class => [
            self::CONFIG_REPOSITORY_KEY => 'multiCenterPushNotificationRepository',
        ],
    ];

    /**
     * @var \DigitalZombies\Center\Domain\Repository\PushNotification\CenterPushNotificationRepository
     * @inject
     */
    protected $centerPushNotificationRepository;

    /**
     * @var \TYPO3\CMS\Frontend\Page\PageRepository
     * @inject
     */
    protected $pageRepository;

    /**
     * @var \DigitalZombies\Center\Domain\Repository\Center\CenterRepository
     * @inject
     */
    protected $centerRepository;

    /**
     * @var \DigitalZombies\Center\Domain\Repository\PushNotification\GlobalPushNotificationRepository
     * @inject
     */
    protected $globalPushNotificationRepository;

    /**
     * @var \DigitalZombies\Center\Domain\Repository\PushNotification\MultiCenterPushNotificationRepository
     * @inject
     */
    protected $multiCenterPushNotificationRepository;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @inject
     */
    protected $persistenceManager;

    /**
     * @var \TYPO3\CMS\Core\Messaging\FlashMessageService
     * @inject
     */
    protected $flashMessageService;

    /**
     * @param $id
     * @param $type
     * @param $methodName
     * @return mixed
     * @throws InvalidClassMappingException
     * @throws \ReflectionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function processActionArgument($id, $type, $methodName)
    {
        /** @var PushNotification $pushNotification */
        $pushNotification = $this->mapParameterToObject($id, $type);
        if (!$pushNotification) {
            $this->errorMessage(
                LocalizationUtility::translate(self::LL_PATH . 'errors.cantprocess', null, [$methodName, $id])
            );
            $this->forward('list');
        }
        $pushNotification = $this->preProcess($pushNotification, $methodName);
        return $pushNotification;
    }

    /**
     * @param int $id
     * @param string $type
     * @throws InvalidClassMappingException
     * @throws \ReflectionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function publishAction($id, $type)
    {
        /** @var PushNotification $pushNotification */
        $pushNotification = $this->processActionArgument($id, $type, __FUNCTION__);
        $pushNotification->setMarkedForDelivery(true);

        $this->updateObject($pushNotification);
        $this->infoMessage(
            LocalizationUtility::translate(self::LL_PATH . 'info.published', null, [$id])
        );
        $this->forward('list');
    }

    /**
     * @param int $id
     * @param string $type
     * @throws InvalidClassMappingException
     * @throws \ReflectionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function dequeueAction($id, $type)
    {
        /** @var PushNotification $pushNotification */
        $pushNotification = $this->processActionArgument($id, $type, __FUNCTION__);
        $pushNotification->setMarkedForDelivery(false);

        $this->updateObject($pushNotification);
        $this->infoMessage(
            LocalizationUtility::translate(self::LL_PATH . 'info.dequeued', null, [$id])
        );
        $this->forward('list');
    }

    /**
     * @param int $id
     * @param string $type
     * @throws InvalidClassMappingException
     * @throws \ReflectionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    public function deleteAction($id, $type)
    {
        /** @var PushNotification $pushNotification */
        $pushNotification = $this->processActionArgument($id, $type, __FUNCTION__);
        $this->deleteObject($pushNotification);
        $this->infoMessage(
            LocalizationUtility::translate(self::LL_PATH . 'info.deleted', null, [$id])
        );
        $this->forward('list');
    }

    /**
     * Basic list view
     */
    public function listAction()
    {
        $viewArray = [
            'unprocessed' => [
                'centerPushNotifications' => $this->centerPushNotificationRepository->getAllUnprocessed(),
                'multiCenterPushNotifications' => $this->multiCenterPushNotificationRepository->getAllUnprocessed(),
                'globalCenterPushNotifications' => $this->globalPushNotificationRepository->getAllUnprocessed(),
            ],
            'pending' => [
                'centerPushNotifications' => $this->centerPushNotificationRepository->getAllPending(),
                'multiCenterPushNotifications' => $this->multiCenterPushNotificationRepository->getAllPending(),
                'globalCenterPushNotifications' => $this->globalPushNotificationRepository->getAllPending(),
            ],
            'delivered' => [
                'centerPushNotifications' => $this->centerPushNotificationRepository->getAllDelivered(),
                'multiCenterPushNotifications' => $this->multiCenterPushNotificationRepository->getAllDelivered(),
                'globalCenterPushNotifications' => $this->globalPushNotificationRepository->getAllDelivered(),
            ]
        ];

        array_walk($viewArray, function (&$typeArray) {
            $typeArray = array_filter($typeArray);
        });

        $viewArray = array_filter($viewArray);

        $languages = $this->objectManager->get(TranslationConfigurationProvider::class)->getSystemLanguages();
        $languages[0]['flag'] = 'de';

        $this->view->assignMultiple([
            'pushNotifications' => $viewArray,
            'messages' => $this->flashMessageService->getMessageQueueByIdentifier()->renderFlashMessages(),
            'languages' => $languages
        ]);
    }

    /**
     * @param CenterPushNotification $pushNotification
     * @return CenterPushNotification
     * @throws \ReflectionException
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     */
    private function attachParentSiteCenterToPushNotification(CenterPushNotification $pushNotification)
    {
        $centerRootPage = 0;
        $rootline = $this->pageRepository->getRootLine(
            $pushNotification->getPid()
        );

        foreach ($rootline as $page) {
            if ($page['is_siteroot']) {
                $centerRootPage = $page['uid'];
                break;
            }
        }

        /** @var Center $center */
        $center = $this->centerRepository->findByPageId($centerRootPage);
        if (!$center instanceof Center) {
            $this->errorMessage(
                LocalizationUtility::translate(self::LL_PATH . 'errors.noparentcenter')
            );
            $this->forward('list');
        }
        if (
            ($center->getPushServerAndroidTopic() == "" || $center->getPushServerAndroidAuthorizationKey() == "") &&
            ($center->getPushServerIosTopic() == "" || $center->getPushServerIosAuthorizationKey() == "")
        ) {
            $this->errorMessage(
                LocalizationUtility::translate(self::LL_PATH . 'errors.parentcenternotconfigured')
            );
            $this->forward('list');
        }

        /** @var ObjectStorage $objectStorage */
        $objectStorage = $this->objectManager->get(ObjectStorage::class);
        $objectStorage->attach($center);
        $pushNotification->setCenter($objectStorage);
        $this->updateObject($pushNotification);

        return $pushNotification;
    }

    /**
     * @param GlobalPushNotification $pushNotification
     * @return GlobalPushNotification
     * @throws \ReflectionException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    private function attachAllCentersToPushNotification(GlobalPushNotification $pushNotification)
    {
        $centers = $this->centerRepository->getAllWithApp();
        /** @var ObjectStorage $objectStorage */
        $objectStorage = $this->objectManager->get(ObjectStorage::class);
        foreach ($centers as $center) {
            $objectStorage->attach($center);
        }
        $pushNotification->setCenter($objectStorage);
        $this->updateObject($pushNotification);
        return $pushNotification;
    }

    /**
     * @param int $id
     * @param string $type
     * @return mixed
     * @throws InvalidClassMappingException
     */
    private function mapParameterToObject(int $id, string $type)
    {
        if (!isset(self::TYPE_CONFIG[$type][self::CONFIG_REPOSITORY_KEY])) {
            throw new InvalidClassMappingException($type . ' is not mapped.');
        }
        return $this->{self::TYPE_CONFIG[$type][self::CONFIG_REPOSITORY_KEY]}->getOne($id);
    }

    /**
     * @param $object
     * @param string $callingMethodName
     * @return mixed
     * @throws \ReflectionException
     */
    private function preProcess($object, string $callingMethodName)
    {
        $reflectionClass = new ReflectionClass($object);
        $type = $reflectionClass->getName();
        if (isset(self::TYPE_CONFIG[$type][self::CONFIG_PREPROCESSOR_KEY][$callingMethodName])) {
            $object = $this->{self::TYPE_CONFIG[$type][self::CONFIG_PREPROCESSOR_KEY][$callingMethodName]}($object);
        }
        return $object;
    }

    /**
     * @param $object
     * @throws \ReflectionException
     */
    private function updateObject($object)
    {
        $reflectionClass = new ReflectionClass($object);
        $type = $reflectionClass->getName();
        if (isset(self::TYPE_CONFIG[$type][self::CONFIG_REPOSITORY_KEY])) {
            $this->{self::TYPE_CONFIG[$type][self::CONFIG_REPOSITORY_KEY]}->update($object);
            $this->persistenceManager->persistAll();
        }
    }

    /**
     * @param $object
     * @throws \ReflectionException
     */
    private function deleteObject($object)
    {
        $reflectionClass = new ReflectionClass($object);
        $type = $reflectionClass->getName();
        if (isset(self::TYPE_CONFIG[$type][self::CONFIG_REPOSITORY_KEY])) {
            $this->{self::TYPE_CONFIG[$type][self::CONFIG_REPOSITORY_KEY]}->remove($object);
            $this->persistenceManager->persistAll();
        }
    }


    /**
     * @param string $message
     */
    private function infoMessage(string $message)
    {
        $this->addMessage(
            $message,
            FlashMessage::INFO
        );
    }

    /**
     * @param string $message
     */
    private function errorMessage(string $message)
    {
        $this->addMessage(
            $message,
            FlashMessage::ERROR
        );
    }

    /**
     * @param string $message
     * @param int $type
     */
    private function addMessage(string $message, int $type)
    {
        $this->flashMessageService
            ->getMessageQueueByIdentifier()
            ->addMessage(
                $this->objectManager->get(
                    FlashMessage::class,
                    $message,
                    'Info',
                    $type,
                    true
                )
            );
    }
}