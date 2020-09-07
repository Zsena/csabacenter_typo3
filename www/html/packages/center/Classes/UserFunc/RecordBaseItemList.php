<?php

namespace DigitalZombies\Center\UserFunc;

use DigitalZombies\Center\Domain\Model\RecordBase;
use DigitalZombies\Center\Domain\Model\Records\Banner;
use DigitalZombies\Center\Domain\Model\Records\Blog;
use DigitalZombies\Center\Domain\Model\Records\ContentTeaser;
use DigitalZombies\Center\Domain\Model\Records\Event;
use DigitalZombies\Center\Domain\Model\Records\Job;
use DigitalZombies\Center\Domain\Model\Records\News;
use DigitalZombies\Center\Domain\Model\Records\Coupon;
use DigitalZombies\Center\Domain\Model\Records\Offer;
use DigitalZombies\Center\Domain\Model\Records\Service;
use DigitalZombies\Center\Domain\Model\Shop\Gastro;
use DigitalZombies\Center\Domain\Model\Shop\Shop;
use DigitalZombies\Center\Domain\Repository\Center\CenterRepository;
use DigitalZombies\Center\Domain\Repository\Misc\TagRepository;
use DigitalZombies\Center\Domain\Repository\RecordBaseRepository;
use DigitalZombies\Center\Utility\Configuration\ConfigurationHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 András Ottó <andras.otto@plan-net.com>
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
class RecordBaseItemList
{

	const adTeaserTypes = News::TYPE . ',' . Event::TYPE . ',' . Offer::TYPE . ',' . Job::TYPE . ',' . Blog::TYPE . ',' . ContentTeaser::TYPE;

	public $sort = 'recordbase.title';

	/**
	 * Lists specific items from the database based on a comma separated list
	 *
	 * @param array $settings
	 * @param boolean $addTypeToLabel
	 * @param string $sort
	 * @return array
	 */
	public function listItemsBySettings($settings, $addTypeToLabel = false, $rootPid = null)
	{
		if ($rootPid && ((int)$num == $num && (int)$num > 0)) {
			$siteRootUid = $rootPid;
		} else {
			$siteRootUid = $this->getRootPageIdFromQuery();
		}

		$items = [];

		/** @var ObjectManager $objectManager */
		$objectManager = GeneralUtility::makeInstance(ObjectManager::class);

		/** @var CenterRepository $centerRepository */
		$centerRepository = $objectManager->get(CenterRepository::class);

		$center = $centerRepository->findByPageId($siteRootUid);

		if ($center) {
			/** @var RecordBaseRepository $recordBaseRepository */
			$recordBaseRepository = $objectManager->get(RecordBaseRepository::class);

			$records = $recordBaseRepository->findAllRecordsBySpecificSetting($center, $settings, $this->sort);

			//Generate items as label => value for a selectbox
			/** @var  $record */
			foreach ($records as $record) {
				if ($addTypeToLabel) {
					//Get the type of the element if it is needed
					$typeLabel = LocalizationUtility::translate(
						'fe.teaserWall.category.' . $record['type'],
						'center');

					$itemLabel = sprintf("%s (%s)", $record['title'], $typeLabel);
				} else {
					$itemLabel = $record['title'];
				}

				$items[] = [
					0 => $itemLabel,
					1 => $record['type_uid']
				];
			}

		}
		unset($center);
		return $items;
	}

	/**
	 * Lists specific items from the database based on a comma separated list
	 *
	 * @param $types
	 * @param boolean $addTypeToLabel
	 * @param string $sort
	 * @return array
	 */
	public function listItemsByTypes($types, $addTypeToLabel = false, $rootPid)
	{
		$settings['types'] = $types;

		return $this->listItemsBySettings($settings, $addTypeToLabel, $rootPid);
	}

	/**
	 * Returns the rootPageId of the current page
	 *
	 * @return int
	 */
	protected function getRootPageId()
	{
		$settings = ConfigurationHelper::getConfiguration();

		$siteRootUid = isset($settings['rootPageId']) ? (int)$settings['rootPageId'] : 0;

		return $siteRootUid;
	}

	/**
	 * Add news, events and press records to the config items
	 *
	 * @param $config
	 */
	public function listNEP(&$config)
	{

		$types = News::TYPE . ',' . Event::TYPE . ',' . Banner::TYPE;

		//News, Press & Events Teaser Offer only appears in root page
		$rootPid = $config['flexParentDatabaseRow']['pid'];

		$items = $this->listItemsByTypes($types, true, $rootPid);

		$config['items'] = $items;
	}

	/**
	 * Adds each type of recordbase objects only with teaser_format = 2
	 *
	 * @param $config
	 */
	public function listColAll(&$config)
	{

		$settings['teaserFormat'] = '1,2,3';
		$settings['types'] = self::adTeaserTypes;

		//Ad Teaser only appears in root page
		$rootPid = $config['flexParentDatabaseRow']['pid'];

		$items = $this->listItemsBySettings($settings, true, $rootPid);

		$config['items'] = $items;
	}

	/**
	 * Adds each type of recordbase objects only with teaser_format = 2
	 *
	 * @param $config
	 */
	public function listCol2(&$config)
	{

		$settings['teaserFormat'] = '2';
		$settings['types'] = self::adTeaserTypes;

		//Ad Teaser only appears in root page
		$rootPid = $config['flexParentDatabaseRow']['pid'];

		$items = $this->listItemsBySettings($settings, true, $rootPid);

		$config['items'] = $items;
	}

	/**
	 * Add news, events and press records to the config items
	 *
	 * @param $config
	 */
	public function listCol3(&$config)
	{

		$settings['teaserFormat'] = '3';
		$settings['types'] = self::adTeaserTypes;

		//Ad Teaser only appears in root page
		$rootPid = $config['flexParentDatabaseRow']['pid'];

		$items = $this->listItemsBySettings($settings, true, $rootPid);

		$config['items'] = $items;
	}

	/**
	 * Add news, events and press records to the config items
	 *
	 * @param $config
	 */
	public function listJob(&$config)
	{

		$types = Job::TYPE;

		$this->sort = 'recordbase.starttime';

		$rootPid = $config['flexParentDatabaseRow']['pid'];

		$items = $this->listItemsByTypes($types, false, $rootPid);

		$config['items'] = $items;
	}

	/**
	 * Add news, events and press records to the config items
	 *
	 * @param $config
	 */
	public function listOffer(&$config)
	{
		$types = Offer::TYPE . ',' . Coupon::TYPE;

		//Home Teaser Offer only appears in root page
		$rootPid = $config['flexParentDatabaseRow']['pid'];

		$items = $this->listItemsByTypes($types, false, $rootPid);

		$config['items'] = $items;
	}

	/**
	 * Add news, events and press records to the config items
	 *
	 * @param array $config
	 * @param string $type
	 */
	public function listServiceCategoryItems(&$config, $type)
	{
		$siteRootUid = $this->getRootPageId();

		$items = [];

		/** @var ObjectManager $objectManager */
		$objectManager = GeneralUtility::makeInstance(ObjectManager::class);

		/** @var CenterRepository $centerRepository */
		$centerRepository = $objectManager->get(CenterRepository::class);

		$center = $centerRepository->findByPageId($siteRootUid);

		if ($center) {

			/** @var TagRepository $tagRepository */
			$tagRepository = $objectManager->get(TagRepository::class);

			$records = $tagRepository->findTagsByType($type);

			//Generate items as label => value for a selectbox
			foreach ($records as $record) {
				$items[] = [
					0 => $record['title'],
					1 => $record['uid']
				];
			}

		}

		$config['items'] = $items;
	}

	/**
	 * Adds service tags to the select box
	 *
	 * @param $config
	 */
	public function listServiceCategories(&$config)
	{
		$type = Service::TYPE;
		$this->listServiceCategoryItems($config, $type);
	}

	/**
	 * Adds general tags to the select box
	 *
	 * @param $config
	 */
	public function listOptionalServiceCategories(&$config)
	{
		$type = RecordBase::TYPE;
		$this->listServiceCategoryItems($config, $type);
	}

	/**
	 * Add news, events and press records to the config items
	 *
	 * @param $config
	 */
	public function listServices(&$config)
	{
		$types = Service::TYPE;

		//Home Teaser Service only appears in root page
		$rootPid = $config['flexParentDatabaseRow']['pid'];

		$items = $this->listItemsByTypes($types, false, $rootPid);

		$config['items'] = $items;
	}

	/**
	 * Add news, events and press records to the config items
	 *
	 * @param $config
	 */
	public function listShopGastro(&$config)
	{
		$types = Shop::TYPE . ',' . Gastro::TYPE;

		//List Shop Gastro Teaser Offer only appears in root page
		$rootPid = $config['flexParentDatabaseRow']['pid'];

		$items = $this->listItemsByTypes($types, true, $rootPid);

		$config['items'] = $items;
	}

	public function getRootPageIdFromQuery(){
		$query = parse_url($_GET['returnUrl']);
		if(isset($query['query'])) {
			parse_str(urldecode($query['query']), $query['query']);
		}

		return $query['query']['id'];
	}

}
