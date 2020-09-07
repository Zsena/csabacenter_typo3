<?php

namespace DigitalZombies\Center\Controller;

use DigitalZombies\Center\Domain\Model\RecordBase;
use DigitalZombies\Center\Domain\Model\Records\Coupon;
use DigitalZombies\Center\Domain\Model\Records\Event;
use DigitalZombies\Center\Domain\Model\Records\Job;
use DigitalZombies\Center\Domain\Model\Records\News;
use DigitalZombies\Center\Domain\Model\Records\Offer;
use DigitalZombies\Center\Exception\InvalidPreviewRequestException;
use DigitalZombies\Center\Utility\AuthenticationHelper;
use DigitalZombies\Center\Utility\PreviewItemFactory;
use DigitalZombies\Center\Utility\PreviewRequest;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Exception\StopActionException;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017
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

/**
 * Class PreviewController
 * @package DigitalZombies\Center\Controller
 */
class PreviewController extends ActionController
{

    const MAPPING_ACTION_KEY = 'actionName';
    const MAPPING_CONTROLLER_KEY = 'controllerName';
    const MAPPING_EXTENSION_KEY = 'extensionName';
    const MAPPING_ARGUMENT_ITEM_KEY = 'itemArgumentName';
    const MAPPING_PRE_PROCESS_METHOD = 'preShowProcessor';

    /**
     * Maps object types to their corresponding show controllers and actions
     * @var array
     */
    private $requestForwardMapping = [
        Offer::class => [
            self::MAPPING_ACTION_KEY => 'show',
            self::MAPPING_CONTROLLER_KEY => 'Offer',
            self::MAPPING_EXTENSION_KEY => 'Center',
            self::MAPPING_ARGUMENT_ITEM_KEY => 'offer'
        ],
        Event::class => [
            self::MAPPING_ACTION_KEY => 'show',
            self::MAPPING_CONTROLLER_KEY => 'Event',
            self::MAPPING_EXTENSION_KEY => 'Center',
            self::MAPPING_ARGUMENT_ITEM_KEY => 'event'
        ],
        Coupon::class => [
            self::MAPPING_ACTION_KEY => 'show',
            self::MAPPING_CONTROLLER_KEY => 'Coupon',
            self::MAPPING_EXTENSION_KEY => 'Center',
            self::MAPPING_ARGUMENT_ITEM_KEY => 'coupon'
        ],
        News::class => [
            self::MAPPING_ACTION_KEY => 'show',
            self::MAPPING_CONTROLLER_KEY => 'News',
            self::MAPPING_EXTENSION_KEY => 'Center',
            self::MAPPING_ARGUMENT_ITEM_KEY => 'news',
            self::MAPPING_PRE_PROCESS_METHOD => 'preProcessNews'
        ],
        Job::class => [
            self::MAPPING_ACTION_KEY => 'show',
            self::MAPPING_CONTROLLER_KEY => 'Job',
            self::MAPPING_EXTENSION_KEY => 'Center',
            self::MAPPING_ARGUMENT_ITEM_KEY => 'job',
            self::MAPPING_PRE_PROCESS_METHOD => 'preProcessJob'
        ],
    ];

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var PreviewItemFactory
     */
    private $previewItemFactory;

    /**
     * @var PreviewRequest
     */
    private $previewRequest;

    public function initializeAction()
    {
        $authenticationHelper = $this->objectManager->get(AuthenticationHelper::class);
        if (!$authenticationHelper->isAuthenticated()) {
            $authenticationHelper->provideAuthentication();
        }

        $this->logger = $this->objectManager->get(LogManager::class)->getLogger(__CLASS__);
        $this->previewItemFactory = $this->objectManager->get(PreviewItemFactory::class);
        $this->previewRequest = $this->objectManager->get(PreviewRequest::class, $_GET);
    }

    /**
     * @throws InvalidPreviewRequestException
     */
    protected function listAction()
    {
        $forwardConfiguration = $this->retrieveForwardConfig($this->previewRequest->getPreviewItemObjectType());
        $item = $this->previewItemFactory->getPreviewItem($this->previewRequest);

        if (isset($forwardConfiguration[self::MAPPING_PRE_PROCESS_METHOD])
            && method_exists(self::class, $forwardConfiguration[self::MAPPING_PRE_PROCESS_METHOD])) {
            $this->{$forwardConfiguration[self::MAPPING_PRE_PROCESS_METHOD]}($item);
        }

        $this->view->assignMultiple(
            [
                'item' => $item
            ]
        );
    }

    /**
     * @throws StopActionException
     * @throws InvalidPreviewRequestException
     */
    protected function showAction()
    {
        $forwardConfiguration = $this->retrieveForwardConfig($this->previewRequest->getPreviewItemObjectType());
        $previewItem = $this->previewItemFactory->getPreviewItem($this->previewRequest);

        if (isset($forwardConfiguration[self::MAPPING_PRE_PROCESS_METHOD])
            && method_exists(self::class, $forwardConfiguration[self::MAPPING_PRE_PROCESS_METHOD])) {
            $this->{$forwardConfiguration[self::MAPPING_PRE_PROCESS_METHOD]}($previewItem);
        }

        $this->forward(
            $forwardConfiguration[self::MAPPING_ACTION_KEY],
            $forwardConfiguration[self::MAPPING_CONTROLLER_KEY],
            $forwardConfiguration[self::MAPPING_EXTENSION_KEY],
            [
                $forwardConfiguration[self::MAPPING_ARGUMENT_ITEM_KEY] => $previewItem
            ]
        );
    }

    /**
     * @param string $objectType
     * @return array
     * @throws InvalidPreviewRequestException
     */
    private function retrieveForwardConfig(string $objectType): array
    {
        if (!isset($this->requestForwardMapping[$objectType])) {
            throw new InvalidPreviewRequestException("Unsupported Preview Type");
        }
        $forwardConfiguration = $this->requestForwardMapping[$objectType];

        if (!(isset($forwardConfiguration[self::MAPPING_ACTION_KEY]) &&
            isset($forwardConfiguration[self::MAPPING_CONTROLLER_KEY]) &&
            isset($forwardConfiguration[self::MAPPING_EXTENSION_KEY]) &&
            isset($forwardConfiguration[self::MAPPING_ARGUMENT_ITEM_KEY]))) {
            throw new InvalidPreviewRequestException("Invalid Preview Configuration for type: " . $objectType);
        }

        return $forwardConfiguration;
    }

    /**
     * Preprocessor for News Objects
     * @param News $news
     */
    private function preProcessNews(News &$news)
    {
        $newsType = $news->getType();
        if ($newsType == News::NEWS || $newsType == News::PRESS) {
            $news->setTeaserCategory($newsType);
        }
    }

    /**
     * Preprocessor for Job Objects
     * @param Job $job
     */
    private function preProcessJob(Job &$job)
    {
        $job->setTeaserCategory($job->getJobCategory());
    }
}
