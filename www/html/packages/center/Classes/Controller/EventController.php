<?php

namespace DigitalZombies\Center\Controller;

use DigitalZombies\Center\Domain\Model\Misc\Sender;
use DigitalZombies\Center\Domain\Model\Records\Event;
use DigitalZombies\Center\Domain\Repository\Records\EventRepository;
use DigitalZombies\Center\Domain\Repository\RecordBaseRepository;
use DigitalZombies\Center\Service\Page\BodyTitleConfiguration;
use DigitalZombies\Center\Configuration\ScopeConfiguration;
use DigitalZombies\Center\Utility\DirectionHelper;

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
 * Class EventController
 * @package DigitalZombies\Center\Controller
 */
class EventController extends MetaTagBaseController
{
	/**
	 * @var \DigitalZombies\Center\Domain\Repository\Records\EventRepository
	 */
	protected $eventRepository;

	/**
	 * @var \DigitalZombies\Center\Domain\Repository\RecordBaseRepository
	 */
	protected $recordBaseRepository;

	/**
	 * @param \DigitalZombies\Center\Domain\Repository\Records\EventRepository $repository
	 *
	 * @return void
	 */
	public function injectEventRepository(EventRepository $repository)
	{
		$this->eventRepository = $repository;
	}

	/**
	 * @param \DigitalZombies\Center\Domain\Repository\Records\RecordBaseRepository $repository
	 *
	 * @return void
	 */
	public function injectRecordBaseRepository(RecordBaseRepository $repository)
	{
		$this->recordBaseRepository = $repository;
	}

	/**
	 * Renders a detail page for Event
	 *
	 * @param Event $event
	 */
	public function showAction(Event $event = null)
	{
		if ($event) {
			$existEventInCenter = $this->recordBaseRepository->findRecordsByUid(
				ScopeConfiguration::getScope(),
				['tx_center_domain_model_records_event' => $event->getUid()],
				[$event->getUid() => 'tx_center_domain_model_records_event--' . $event->getUid()],
				false,
				'tx_center_domain_model_records_event'
			);

			if ($existEventInCenter || $event->isPreview()) {
				parent::addCacheTags($event);

				BodyTitleConfiguration::getInstance()->setTitle($event->getTitle());

				$this->setMetaTags($event);

				$this->view->assign('event', $event);

				$GLOBALS['HTTP_GET_VARS']['tx_center_event']['endtime'] = ($event->getEndtime()) ? $event->getEndtime() : 0;

				if (($event->getEventEndtime() > time()) && ($event->getEventShowical() == 1)) {
					$referer = str_replace('/', '_', $_SERVER['REQUEST_URI']);
					$this->view->assign('referer', str_replace('-', '.', $referer));
					$this->view->assign('showIcon', true);
				}

				if ($event->getSender()->getSenderType() === Sender::SENDER_CENTER) {
					$this->view->assign('directions', DirectionHelper::getDirections());
				}
			} else {
				$this->redirectToUri('404', 0, 404);
			}
		}
	}


	/**
	 * Renders a detail page for Event
	 *
	 * @return string
	 */
	public function getEventsAction()
	{
		$response['events'] = [];
		if (ScopeConfiguration::hasCenter()) {
			$events = $this->eventRepository->listAllForCenter(ScopeConfiguration::getCenterUid());
			$cObj = $this->configurationManager->getContentObject();
			/** @var Event $event */
			foreach ($events as $event) {
				$eventUri = $this->uriBuilder->reset()
					->setTargetPageUid($this->settings['detailPages']['event'])
					->setArguments([
						'tx_center_event' => [
							'event' => $event->getUid()
						]
					])->setCreateAbsoluteUri(true)->buildFrontendUri();
                $icalLink = '';
                if (($event->getEventEndtime() > time()) && ($event->getEventShowical() == 1)) {
                    $icalLink = $this->uriBuilder->reset()
                        ->setTargetPageUid($this->settings['detailPages']['event'])
                        ->setTargetPageType(84525)
                        ->setArguments([
                            'tx_center_geteventincalender' => [
                                'controller' => 'Ical',
                                'action' => 'show',
                                'eventUid' => $event->getUid(),
                                'referer' => str_replace('-', '.', str_replace('/', '_', $eventUri))
                            ]
                        ])->setCreateAbsoluteUri(true)
                        ->buildFrontendUri();
                }
				$this->view->assign('event', $event);
				$content = $this->view->render();
				$eventArray = [
					'uid' => $event->getUid(),
					'sender' => $event->getSender()->getName(),
                    'starttime' => $event->getStarttime(),
                    'endtime' => $event->getEndtime(),
					'shop' => null,
					'ical' => $icalLink,
					'detail' => [
					    'link' => $eventUri,
						'date' => $event->getDetailDate(),
						'time' => $event->getDetailTime(),
						'title' => $event->getTitle(),
						'abstract' => $event->getContentAbstract(),
						'content' => trim($content),
						'image' => $this->processImageAndGetUrl($event->getContentStagemedia(), 1200),
						'downloadLinkText' => $event->getContentDownloadlinktext(),
						'downloadLink' => $cObj->typoLink_URL(["parameter" => $event->getContentDownloadlink()]),
						'downloadFileText' => $event->getContentDownloadfiletext(),
						'downloadFile' => $this->getFileUrl($event->getContentDownloadfile())
					],
					'teaser' => [
						'title' => $event->getTitle(),
						'date' => $event->getTeaserDate(),
						'time' => $event->getTeaserTime(),
						'abstract' => $event->getTeaserAbstract(),
						'image' => $this->processImageAndGetUrl($event->getTeaserImage(), 363),
                        'top' => $event->getTopInApp(),
					]
				];
				$this->fillShop($event, $eventArray);
				$response['events'][] = $eventArray;
			}
		}

		return json_encode($response);

	}
}
