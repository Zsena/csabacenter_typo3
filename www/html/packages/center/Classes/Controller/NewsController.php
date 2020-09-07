<?php

namespace DigitalZombies\Center\Controller;

use DigitalZombies\Center\Domain\Model\Misc\Contactperson;
use DigitalZombies\Center\Domain\Model\Misc\Sender;
use DigitalZombies\Center\Domain\Model\Records\News;
use DigitalZombies\Center\Domain\Repository\Misc\ContactpersonRepository;
use DigitalZombies\Center\Domain\Repository\Records\NewsRepository;
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
 * Class NewsController
 * @package DigitalZombies\Center\Controller
 */
class NewsController extends MetaTagBaseController
{

	/**
	 * @var \DigitalZombies\Center\Domain\Repository\Misc\ContactpersonRepository
	 */
	protected $contactpersonRepository;

	/**
	 * @var \DigitalZombies\Center\Domain\Repository\Records\NewsRepository
	 */
	protected $newsRepository;

	/**
	 * @var \DigitalZombies\Center\Domain\Repository\RecordBaseRepository
	 */
	protected $recordBaseRepository;

	/**
	 * @param \DigitalZombies\Center\Domain\Repository\Misc\ContactpersonRepository $repository
	 *
	 * @return void
	 */
	public function injectContactpersonRepository(ContactpersonRepository $repository)
	{
		$this->contactpersonRepository = $repository;
	}

	/**
	 * @param \DigitalZombies\Center\Domain\Repository\Records\NewsRepository $repository
	 *
	 * @return void
	 */
	public function injectNewsRepository(NewsRepository $repository)
	{
		$this->newsRepository = $repository;
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
	 * Renders a detail page for News
	 *
	 * @param News $news
	 */
	public function showAction(News $news = null)
	{
		if ($news) {
			$existNewsInCenter = $this->recordBaseRepository->findRecordsByUid(
				ScopeConfiguration::getScope(),
				['tx_center_domain_model_records_news' => $news->getUid()],
				[$news->getUid() => 'tx_center_domain_model_records_news--' . $news->getUid()],
				false,
				'tx_center_domain_model_records_news'
			);

			if ($existNewsInCenter || $news->isPreview()) {
				parent::addCacheTags($news);

				BodyTitleConfiguration::getInstance()->setTitle($news->getTitle());

				$this->setMetaTags($news);

				$contactType = $news->getType() === News::NEWS ? Contactperson::NEWS : Contactperson::PRESS;

				$contact = $this->contactpersonRepository->findByTypeAndResponsibility($news->getSender(), $contactType);

				$GLOBALS['HTTP_GET_VARS']['tx_center_news']['endtime'] = ($news->getEndtime()) ? $news->getEndtime() : 0;

				$this->view->assign('news', $news);
				$this->view->assign('contact', $contact);

				if ($news->getSender()->getSenderType() === Sender::SENDER_CENTER) {
					$this->view->assign('directions', DirectionHelper::getDirections());
				}
			} else {
				$this->redirectToUri('404', 0, 404);
			}

		}
	}


	/**
	 * Renders a detail page for News
	 *
	 * @return string
	 */
	public function getNewsAction()
	{
		$response['news'] = [];
		if (ScopeConfiguration::hasCenter()) {
			$newsRecords = $this->newsRepository->listAllForCenter(ScopeConfiguration::getCenterUid());
			$cObj = $this->configurationManager->getContentObject();
			$detailLink = '';
			/** @var News $news */
			foreach ($newsRecords as $news) {
                if(isset($this->settings['detailPages']['news'])) {
                    $detailLink = $this->uriBuilder
                        ->reset()
                        ->setTargetPageUid($this->settings['detailPages']['news'])
                        ->setArguments(['tx_center_news' => [
                            'controller' => 'News',
                            'action' => 'show',
                            'coupon' => $news->getUid(),
                        ]])
                        ->setCreateAbsoluteUri(true)
                        ->buildFrontendUri();
                }
				$date = '';
				if ($news->getStarttime()) {
					$date = date($this->settings['dateFormat']['base'], $news->getStarttime());
				}
				$this->view->assign('news', $news);
				$content = $this->view->render();
				$newsArray = [
					'uid' => $news->getUid(),
					'date' => $date,
					'timestamp' => $news->getStarttime(),
                    'starttime' => $news->getStarttime(),
                    'endtime' => $news->getEndtime(),
					'sender' => $news->getSender()->getName(),
					'shop' => null,
					'detail' => [
					    'link' => $detailLink,
						'title' => $news->getTitle(),
						'abstract' => $news->getContentAbstract(),
						'content' => trim($content),
						'image' => $this->processImageAndGetUrl($news->getContentStagemedia(), 1200),
						'downloadLinkText' => $news->getContentDownloadlinktext(),
						'downloadLink' => $cObj->typoLink_URL(["parameter" => $news->getContentDownloadlink()]),
						'downloadFileText' => $news->getContentDownloadfiletext(),
						'downloadFile' => $this->getFileUrl($news->getContentDownloadfile())
					],
					'teaser' => [
						'title' => $news->getTitle(),
						'abstract' => $news->getTeaserAbstract(),
						'image' => $this->processImageAndGetUrl($news->getTeaserImage()),
                        'top' => $news->getTopInApp(),
					]
				];

				$this->fillShop($news, $newsArray);
				$response['news'][] = $newsArray;
			}
		}

		return json_encode($response);

	}
}
