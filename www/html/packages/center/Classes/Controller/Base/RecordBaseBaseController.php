<?php

namespace DigitalZombies\Center\Controller;

use DigitalZombies\Center\Domain\Model\Center\CenterLevelPosition;
use DigitalZombies\Center\Domain\Model\Misc\Sender;
use DigitalZombies\Center\Domain\Model\RecordBase;
use DigitalZombies\Center\Domain\Model\Shop\Shop;
use DigitalZombies\Center\Configuration\ScopeConfiguration;
use DigitalZombies\Ecesolr\Helper\ImageHelper;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

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
 * Class RecordBaseBaseController
 * @package DigitalZombies\Center\Controller
 */
class RecordBaseBaseController extends ActionController
{

	/**
	 * @param FileReference $imageReference
	 * @return string
	 */
	protected function getFileUrl(FileReference $imageReference = null)
	{
		if ($imageReference) {
			return $GLOBALS['TSFE']->config['config']['absRefPrefix']
				. $imageReference->getOriginalResource()->getOriginalFile()->getPublicUrl();
		}
		return '';
	}

	/**
	 * @param FileReference $imageReference
	 * @return string
	 */
	protected function processImageAndGetUrl(FileReference $imageReference = null, $width = 456)
	{
		if ($imageReference) {
			return ImageHelper::getProcessedImage( $imageReference->getOriginalResource(), ['width' => $width] );
		}
		return '';
	}

	/**
	 * Fills the shop key in the recordArray if the sender of the record base is a shop
	 *
	 * @param RecordBase $recordBase
	 * @param array $recordArray
	 */
	protected function fillShop(RecordBase $recordBase, array &$recordArray)
	{
		if ($recordBase->getSender()->getSenderType() === Sender::SENDER_SHOP) {
			$shop = $recordBase->getSender()->getShop();
			if ($shop) {
				$recordArray['shop'] = $this->fillFromShop( $shop );
			}
		}
	}

	/**
	 * Returns the important information from the shop as an array
	 *
	 * @param Shop $shop
	 * @return array
	 */
	protected function fillFromShop(Shop $shop)
	{
		$shopUrl = $this->uriBuilder
			->reset()
			->setTargetPageUid( $shop->getUid() )
			->setCreateAbsoluteUri( true )
			->buildFrontendUri();
		$recordArray = [
			'uid' => $shop->getUid(),
			'name' => $shop->getName(),
			'website' => $shop->getContactWebsite(),
			'type' => $shop::TYPE === Shop::TYPE ? 'shop' : 'gastro',
			'description' => $shop->getText(),
			'email' => $shop->getContactEmail(),
			'phone' => $shop->getPhone(),
			'positions' => [],
			'logo' => $this->getFileUrl( $shop->getThumbnail() ),
			'thumbnail' => '',
			'datailLink' => $shopUrl,
			'centerPlanLink' => '',
            'centerPlanLinkType' => 1,
			'tags' => []
		];

		if (!is_null( $shop->getChainStore() )) {
			$recordArray += [
				'chainStore' => [
					'uid' => $shop->getChainStore()->getUid(),
					'name' => $shop->getChainStore()->getName()
				],
			];
		}

		if (ScopeConfiguration::hasCenter()
            && ScopeConfiguration::getScope()->isWayfinderActivated()) {
			// for 3D maps
			$wayFinderUrl = ScopeConfiguration::getScope()->getWayfinderUrl();
			$parameters = "&menu=none&id=" . $shop->getUid();
			$recordArray['centerPlanLink'] = \UrlCheckUtilityHelper::check( $wayFinderUrl, $parameters );
			$recordArray['centerPlanLinkType'] = 2;
			$recordArray['positions'] = [];
		} else {
            /** @var CenterLevelPosition $position */
			foreach ($shop->getPositions() as $position) {
				if (!$recordArray['centerPlanLink'] && isset( $this->settings['detailPages']['centerPlan'] )) {
                    $serviceArray['centerPlanLinkType'] = 1;
					$recordArray['centerPlanLink'] = $this->uriBuilder
						->reset()
						->setTargetPageUid( $this->settings['detailPages']['centerPlan'] )
						->setArguments( ['location' => $position->getPathID()] )
						->setCreateAbsoluteUri( true )
						->buildFrontendUri();
				}
				$recordArray['positions'][] = [
					'id' => $position->getPathID(),
					'name' => ($position->getCenterLevel() ? $position->getCenterLevel()->getTitle() : ''),
					'shortName' => ($position->getCenterLevel() ? $position->getCenterLevel()->getShortName() : ''),
				];
			}
		}

		foreach ($shop->getTagIds() as $tagId) {
			$recordArray['tags'][] = [
				'uid' => $tagId
			];
		}


		return $recordArray;
	}

}
