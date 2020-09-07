<?php

namespace DigitalZombies\Center\Controller;

use DigitalZombies\Center\Domain\Model\Records\ContentTeaser;
use DigitalZombies\Center\Domain\Repository\Records\ContentTeaserRepository;
use DigitalZombies\Center\Configuration\ScopeConfiguration;

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
 * Class ContentTeaserController
 * @package DigitalZombies\Center\Controller
 */
class ContentTeaserController extends MetaTagBaseController
{

	/**
	 * @var \DigitalZombies\Center\Domain\Repository\Records\ContentTeaserRepository
	 */
	protected $contentTeaserRepository;

	/**
	 * @param \DigitalZombies\Center\Domain\Repository\Records\ContentTeaserRepository $repository
	 *
	 * @return void
	 */
	public function injectContentTeaserRepository(ContentTeaserRepository $repository)
	{
		$this->contentTeaserRepository = $repository;
	}

	/**
	 * Renders a detail page for News
	 *
	 * @return string
	 */
	public function getContentTeasersAction()
	{
		$response['contentTeasers'] = [];
		if (ScopeConfiguration::hasCenter()) {
			$contentTeaserRecords = $this->contentTeaserRepository->listAllForCenter(ScopeConfiguration::getCenterUid());
			$cObj = $this->configurationManager->getContentObject();
			$detailLink = '';
			/** @var ContentTeaser $contentTeaser */
			foreach ($contentTeaserRecords as $contentTeaser) {
                if($contentTeaser->getLink()) {
                    $detailLink = $cObj->typoLink_URL(["parameter" => $contentTeaser->getLink()]);
                }
				$date = '';
				if ($contentTeaser->getStarttime()) {
					$date = date($this->settings['dateFormat']['base'], $contentTeaser->getStarttime());
				}
				$this->view->assign('news', $contentTeaser);
				$contentTeaserArray = [
					'uid' => $contentTeaser->getUid(),
					'date' => $date,
					'timestamp' => $contentTeaser->getStarttime(),
                    'starttime' => $contentTeaser->getStarttime(),
                    'endtime' => $contentTeaser->getEndtime(),
					'sender' => $contentTeaser->getSender()->getName(),
					'shop' => null,
					'detail' => [
					    'link' => $detailLink,
					],
					'teaser' => [
						'title' => $contentTeaser->getTitle(),
						'abstract' => $contentTeaser->getTeaserAbstract(),
						'image' => $this->processImageAndGetUrl($contentTeaser->getTeaserImage()),
                        'top' => $contentTeaser->getTopInApp(),
					]
				];

				$this->fillShop($contentTeaser, $contentTeaserArray);
				$response['contentTeasers'][] = $contentTeaserArray;
			}
		}

		return json_encode($response);

	}
}
