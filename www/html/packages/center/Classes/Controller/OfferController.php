<?php

namespace DigitalZombies\Center\Controller;

use DigitalZombies\Center\Domain\Model\Misc\Sender;
use DigitalZombies\Center\Domain\Model\Records\Offer;
use DigitalZombies\Center\Domain\Repository\Misc\ContactpersonRepository;
use DigitalZombies\Center\Domain\Repository\Records\OfferRepository;
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
 * Class OfferController
 * @package DigitalZombies\Center\Controller
 */
class OfferController extends MetaTagBaseController
{

	/**
	 * @var \DigitalZombies\Center\Domain\Repository\Misc\ContactpersonRepository
	 */
	protected $contactpersonRepository;

	/**
	 * @var \DigitalZombies\Center\Domain\Repository\Records\OfferRepository
	 */
	protected $offerRepository;


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
	 * @param \DigitalZombies\Center\Domain\Repository\Records\OfferRepository $repository
	 *
	 * @return void
	 */
	public function injectOfferRepository(OfferRepository $repository)
	{
		$this->offerRepository = $repository;
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
	 * Renders a detail page for Offer
	 *
	 * @param Offer $offer
	 */
	public function showAction(Offer $offer = null)
	{
		if ($offer) {
			$existOfferInCenter = $this->recordBaseRepository->findRecordsByUid(
				ScopeConfiguration::getScope(),
				['tx_center_domain_model_records_offer' => $offer->getUid()],
				[$offer->getUid() => 'tx_center_domain_model_records_offer--' . $offer->getUid()],
				false,
				'tx_center_domain_model_records_offer'
			);

			if ($existOfferInCenter || $offer->isPreview()) {
				parent::addCacheTags($offer);

				BodyTitleConfiguration::getInstance()->setTitle($offer->getTitle());

				$this->setMetaTags($offer);

				$GLOBALS['HTTP_GET_VARS']['tx_center_offer']['endtime'] = ($offer->getEndtime()) ? $offer->getEndtime() : 0;

				$this->view->assign('offer', $offer);
				$this->view->assign('center', ScopeConfiguration::getScope());

				if ($offer->getSender()->getSenderType() === Sender::SENDER_CENTER) {
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
	public function getOffersAction()
	{
		$response['offers'] = [];
		if (ScopeConfiguration::hasCenter()) {
			$offerRecords = $this->offerRepository->listAllForCenter(ScopeConfiguration::getCenterUid());
			$detailLink = '';
			/** @var Offer $offer */
			foreach ($offerRecords as $offer) {
                if(isset($this->settings['detailPages']['offer'])) {
                    $detailLink = $this->uriBuilder
                        ->reset()
                        ->setTargetPageUid($this->settings['detailPages']['offer'])
                        ->setArguments(['tx_center_offer' => [
                            'controller' => 'Offer',
                            'action' => 'show',
                            'offer' => $offer->getUid(),
                        ]])
                        ->setCreateAbsoluteUri(true)
                        ->buildFrontendUri();
                }
				$this->view->assign('offer', $offer);
				$content = $this->view->render();
				$offerArray = [
					'uid' => $offer->getUid(),
					'timestamp' => $offer->getStarttime(),
                    'starttime' => $offer->getStarttime(),
                    'endtime' => $offer->getEndtime(),
					'sender' => $offer->getSender()->getName(),
					'shop' => null,
					'detail' => [
					    'link' => $detailLink,
						'title' => $offer->getTitle(),
						'abstract' => $offer->getContentAbstract(),
						'content' => trim($content),
						'date' => $offer->getDetailDate(),
						'image' => $this->processImageAndGetUrl($offer->getContentStagemedia(), 1200),
					],
					'teaser' => [
						'title' => $offer->getTitle(),
						'abstract' => $offer->getTeaserAbstract(),
						'date' => $offer->getTeaserDate(),
						'image' => $this->processImageAndGetUrl($offer->getTeaserImage()),
                        'top' => $offer->getTopInApp(),
					]
				];
				$this->fillShop($offer, $offerArray);
				$response['offers'][] = $offerArray;
			}
		}

		return json_encode($response);

	}
}
