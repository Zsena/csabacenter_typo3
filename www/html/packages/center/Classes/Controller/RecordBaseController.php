<?php

namespace DigitalZombies\Center\Controller;

use DigitalZombies\Center\Domain\Model\Misc\Tag;
use DigitalZombies\Center\Domain\Model\RecordBase;
use DigitalZombies\Center\Domain\Model\Records\Service;
use DigitalZombies\Center\Domain\Model\Shop\Gastro;
use DigitalZombies\Center\Domain\Model\Shop\Shop;
use DigitalZombies\Center\Domain\Model\Center\Center;
use DigitalZombies\Center\Domain\Repository\Misc\TagRepository;
use DigitalZombies\Center\Domain\Repository\RecordBaseRepository;
use DigitalZombies\Center\Domain\Repository\Shop\ShopRepository;
use DigitalZombies\Center\Service\MenuService;
use DigitalZombies\Center\Configuration\ScopeConfiguration;
use DigitalZombies\Center\Utility\CacheHelper;
use DigitalZombies\Center\Utility\FalLoader;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Frontend\Page\PageRepository;

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
 * Class RecordBase
 * @package DigitalZombies\Center\Controller
 */
class RecordBaseController extends ActionController
{
	//region Repositories
	/**
	 * @var \DigitalZombies\Center\Domain\Repository\RecordBaseRepository
	 */
	protected $recordBaseRepository;


	/**
	 * @var \DigitalZombies\Center\Domain\Repository\Misc\TagRepository
	 */
	protected $tagRepository;

    /**
     * @var \DigitalZombies\Center\Domain\Repository\Shop\ShopRepository
     */
    protected $shopRepository;


	/**
	 * Runs before each and every action
	 *
	 * @return void
	 */
	public function initializeAction()
	{
		parent::initializeAction();
		if (isset($this->settings['teaserwall']['hideCategoryInFE'])) {
			$this->settings['hideCategoryInFE'] = $this->settings['teaserwall']['hideCategoryInFE'];
		}

		$this->settings['isLoginActivated'] = ScopeConfiguration::getScope()->isLoginActivated();
		$this->settings['hideLoginInWeb'] = ScopeConfiguration::getScope()->getDisableLoginInWeb();
        $this->settings['usergroup'] = $GLOBALS['TSFE']->fe_user->user['usergroup'];
    }


	/**
	 * @param \DigitalZombies\Center\Domain\Repository\RecordBaseRepository $repository
	 *
	 * @return void
	 */
	public function injectRecordBaseRepository(RecordBaseRepository $repository)
	{
		$this->recordBaseRepository = $repository;
	}

	/**
	 * @param \DigitalZombies\Center\Domain\Repository\Misc\TagRepository $repository
	 *
	 * @return void
	 */
	public function injectTagRepository(TagRepository $repository)
	{
		$this->tagRepository = $repository;
	}
    /**
     * @param \DigitalZombies\Center\Domain\Repository\Shop\ShopRepository $repository
     *
     * @return void
     */
    public function injectShopRepository(ShopRepository $repository)
    {
        $this->shopRepository = $repository;
    }
	//endregion

	//region Ajax Actions

	/**
	 * Renders a list of different record base elements and returns them as a json encoded array
	 *
	 * url => the url of the "next page"
	 * content => the rendered article elements
	 *
	 * @param int $elements
	 * @param array $settings
	 * @return string
	 */
	public function ajaxListAction($elements = 0, $settings = [])
	{
		return $this->getJsonResponseFromView($elements, $settings);
	}

	/**
	 * Renders a list of different record base elements
	 *
	 * @param int $elements
	 * @return string
	 */
	public function ajaxListShopsFromSettingsAction($elements = 0)
	{
		$settings = $this->fillShopSettingsFromPage();
		$settings['teaserwall']['cid'] = 0;
		return $this->getJsonResponseFromView($elements, $settings);
	}

	/**
	 * Renders a list of different record base elements
	 *
	 * @param int $elements
	 * @return string
	 */
	public function ajaxListServicesFromSettingsAction($elements = 0)
	{
		$settings = $this->fillServicesSettingsFromPage(true);
		$optionCount = count($settings);
		if ($optionCount > 0 && isset($settings['teaserwall'])) {
			$this->settings['teaserwall'] = $settings['teaserwall'];
		}

		$resultsText = LocalizationUtility::translate('fe.serviceList.search.results', 'center');

		$services = [
			'title' => $resultsText,
			'services' => []
		];

		$teaserItems = $this->getRecords($elements);

		/** @var Service $teaserItem */
		foreach ($teaserItems as $teaserItem) {
			$this->view->assign('item', $teaserItem);
			$item = [
				'name' => $teaserItem->getName(),
				'markup' => $this->view->render()
			];
			$services['services'][] = $item;
		}

		$contentObj = $this->configurationManager->getContentObject();

		CacheHelper::addTeaserWallCacheTags($contentObj,
			$teaserItems,
			$this->settings['rootPageId']);

		return json_encode($services);
	}

	//endregion

	//region Actions

	/**
	 * Renders a list of different record base elements
	 *
	 * @param int $elements
	 * @return void
	 */
	public function listAction($elements = 0)
	{
		$this->listRecords($elements);
	}

	/**
	 * Renders a list of different record base elements
	 *
	 * @param int $elements
	 * @return void
	 */
	public function listInterestAction($elements = 0)
	{
		$this->listRecords($elements);
	}

	/**
	 * Renders a list of different record base elements
	 *
	 * @param int $elements
	 * @return void
	 */
	public function listBookmarksAction($elements = 0)
	{
		$this->listRecords($elements);
	}

	/**
	 * Content teaser menu automatic generated from the subpages
	 * Requirement that teaser_abstract, title and teaser_image are filled
	 * and that the doktype is 1 or 4. (Standard and Shortcut)
	 *
	 * @return void
	 */
	public function listContentMenuAction()
	{

		/** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
		$objectManager = GeneralUtility::makeInstance(ObjectManager::class);

		/** @var \TYPO3\CMS\Frontend\Page\PageRepository $pageRepository */
		$pageRepository = $objectManager->get(PageRepository::class);

		$menuEntryPid = $GLOBALS['TSFE']->id;

		if (isset($this->settings['teaserwall']['menuEntryPid']) && $this->settings['teaserwall']['menuEntryPid']) {
			$menuEntryPid = (int)$this->settings['teaserwall']['menuEntryPid'];
		}

		$pageRepository->where_groupAccess = $pageRepository->getMultipleGroupsWhereClause('pages.fe_group', 'pages');
		$pages = $pageRepository->getMenu($menuEntryPid, '*', 'sorting',
			'AND doktype IN (1,3,4) AND hidden = 0 AND deleted = 0 AND (starttime = 0 OR starttime < UNIX_TIMESTAMP()) AND (endtime = 0 OR endtime > UNIX_TIMESTAMP())');

		$typesAndUids = [];
		//With this sortedUids we can have exactly the final sorting just like by the getMenu.
		$sortedUids = [];

		foreach ($pages as $page) {
			$typesAndUids[$page['doktype']][] = $page['uid'];
			$sortedUids[] = $page['doktype'] . '--' . $page['uid'];
		}

		//'pages' as a tableName is important because we can eliminate a coincidence with a content teaser with the same uid as a page uid.
		$teasers = $this->recordBaseRepository->findRecordsByUid(ScopeConfiguration::getScope(), $typesAndUids, $sortedUids, false, 'pages');
		$this->view->assign('teasers', $teasers);
	}

	public function listHomeAdTeasersAction()
	{

		$cols = [
			'333333' => true,
			'33' => true,
			'66' => false,
			'100' => false
		];

		foreach ($cols as $colName => $forceTeaserFormatToOne) {
			$uids = isset($this->settings['hometeaser']['records']['col'][$colName]) ?
				$this->settings['hometeaser']['records']['col'][$colName] : '';
			$this->assignTeasersByUids($uids, $colName, $forceTeaserFormatToOne);
		}
	}

	/**
	 * Wrapper action for listHomeTeasers
	 */
	public function listHomeServiceTeasersAction()
	{
		$uids = isset($this->settings['hometeaser']['records']) ? $this->settings['hometeaser']['records'] : '';
		$this->assignTeasersByUids($uids, 'teasers', false);
	}

	/**
	 * Wrapper action for listHomeTeasers
	 */
	public function listHomeShopGastroTeasersAction()
	{
		if ($this->settings['hometeaser']['banderole'] == 1) {
			$uids = isset($this->settings['hometeaser']['recordsbanderole']) ? $this->settings['hometeaser']['recordsbanderole'] : '';
		} else {
			$uids = isset($this->settings['hometeaser']['records']) ? $this->settings['hometeaser']['records'] : '';
		}
		$this->assignTeasersByUids($uids, 'teasers', false);
	}

	/**
	 * Renders a list of different record base elements
	 *
	 * @return void
	 */
	public function listHomeTeasersAction()
	{
		$uids = isset($this->settings['hometeaser']['records']) ? $this->settings['hometeaser']['records'] : '';

		if ($this->settings['hometeaser']['automaticContent']) {
			$this->assignTeasersAutomaticAndFallback();
		} else {
			$this->assignTeasersByUidsAndFallback($uids);
		}
		$this->view->assign('backgroundImage', FalLoader::getImage($this->settings['hometeaser']['backgroundImage']));
	}

	/**
	 * Renders a list of different record base elements
	 *
	 * @param int $elements
	 * @param array $settings
	 * @return void
	 */
	public function listShopsAction($elements = 0, $settings = [])
	{
		$optionCount = count($settings);
		if ($optionCount > 0 && isset($settings['teaserwall'])) {
			$this->settings['teaserwall'] = $settings['teaserwall'];
		}
		if ($optionCount > 0 && isset($settings['teaserwall']['action'])) {
			$this->view->assign('action', $settings['teaserwall']['action']);
		}
		$title = $GLOBALS['TSFE']->page['title'];
		if ($GLOBALS['TSFE']->page['subtitle']) {
			$title = $GLOBALS['TSFE']->page['subtitle'];
		}
		$this->view->assign('pageTitle', $title);

		if(isset($settings['teaserwall']['specTags']) && count($settings['teaserwall']['specTags']) > 0) {
            $wallItems = $this->shopRepository->findByCenterAndTags(ScopeConfiguration::getScope()->getUid(), $settings['teaserwall']['specTags']);
        }else {
            $wallItems = $this->shopRepository->findByCenter(ScopeConfiguration::getScope()->getUid());
        }

        $contentObj = $this->configurationManager->getContentObject();

        CacheHelper::addTeaserWallCacheTags($contentObj, $wallItems, $this->settings['rootPageId']);

        $this->view->assign('items', $wallItems);
        $this->view->assign('cid', $contentObj->data['uid']);
        $this->view->assign('pageId', (int)$GLOBALS['TSFE']->id);
        $this->view->assign('center', ScopeConfiguration::getScope());
	}

	/**
	 * Renders a list of shop/gastro records based on the settings made on the page itself.
	 * It works only with a special page (!!)
	 *
	 * @return void
	 */
	public function listShopsFromPageSettingsAction()
	{
		$settings = $this->fillShopSettingsFromPage();
		$this->forward('listShops',
			'RecordBase',
			'center',
			[
				'elements' => 0,
				'settings' => $settings
			]);
	}

	/**
	 * Prepares the list module for services
	 *
	 * @param int $elements
	 * @param array $settings
	 * @return void
	 */
	public function listServicesAction($elements = 0, $settings = [])
	{
		$optionCount = count($settings);
		if ($optionCount > 0 && isset($settings['teaserwall'])) {
			$this->settings['teaserwall'] = $settings['teaserwall'];
		}

		$this->listRecords($elements);
		$this->buildMenu();
	}

	/**
	 * Renders a list of shop/gastro records based on the settings made on the page itself.
	 * It works only with a special page (!!)
	 *
	 * @return void
	 */
	public function listServicesFromPageSettingsAction()
	{
		$settings = $this->fillServicesSettingsFromPage();
		$this->forward('listServices',
			'RecordBase',
			'center',
			[
				'elements' => 0,
				'settings' => $settings
			]);
	}
	//endregion

	//region protected functions

	/**
	 * Builds a menu with filters for the list plugin
	 */
	protected function buildMenu()
	{
		$menuItems = MenuService::buildSiblingsAnsSubpages($GLOBALS['TSFE']->page['pid']);
		$currentPageSub = 0;
		$currentPage = 0;
		if (isset($menuItems[$GLOBALS['TSFE']->id])) {
			$currentPage = $menuItems[$GLOBALS['TSFE']->id];
		} else if (isset($menuItems[$GLOBALS['TSFE']->page['pid']])) {
			$currentPage = $menuItems[$GLOBALS['TSFE']->page['pid']];
			$currentPageSub = $currentPage['pages'][$GLOBALS['TSFE']->id];
		}

		$this->view->assignMultiple(array(
			'menuItems' => $menuItems,
			'currentPage' => $currentPage,
			'currentPageSub' => $currentPageSub,
		));
	}

	/**
	 * If there records that are not shown yet
	 *
	 * @param $elements
	 * @return bool
	 */
	protected function needLoadMoreButton($elements)
	{
		if (isset($this->settings['teaserwall']['loadMore']) && (int)$this->settings['teaserwall']['loadMore'] == 0) {
			return false;
		} else {
			$count = $this->recordBaseRepository->countRecords(ScopeConfiguration::getScope(), $this->settings['teaserwall']);
			return $elements < $count;
		}
	}

	/**
	 * Fills teaserwall settings based on the page itself.
	 * This only working with SHOP::LIST_DOKTYPE correctly. (!!!)
	 *
	 * @return mixed
	 */
	protected function fillShopSettingsFromPage()
	{
		$settings['teaserwall'] = [];
		if ((isset($GLOBALS['TSFE']->page['doktype'])
				&& $GLOBALS['TSFE']->page['doktype'] == Shop::LIST_DOKTYPE)
			|| isset($GLOBALS['TSFE']->page['shop_list_type'])) {
			//Prepare settings for this plugin (it has no settings)
			$settings['teaserwall']['cols'] = isset($this->settings['shopList']['cols']) ? (int)$this->settings['shopList']['cols'] : 5;
			$settings['teaserwall']['rows'] = isset($this->settings['shopList']['rows']) ? (int)$this->settings['shopList']['rows'] : 4;
			$settings['teaserwall']['sorting'] = isset($this->settings['shopList']['orderBy']) ? (int)$this->settings['shopList']['orderBy'] : RecordBaseRepository::SORTING_TITLE;
			$settings['teaserwall']['action'] = 'ajaxListShopsFromSettings';

			$type = Shop::TYPE;
			if (isset($GLOBALS['TSFE']->page['shop_list_type'])) {
				$type = preg_replace('/_/', ',', $GLOBALS['TSFE']->page['shop_list_type']);
			}

			$tags = $this->tagRepository->findTagsForTable($GLOBALS['TSFE']->id, 'tags');

			$specTagsShop = $this->tagRepository->findTagsForTable($GLOBALS['TSFE']->id, 'shop_tags');
			$specTagsGastro = $this->tagRepository->findTagsForTable($GLOBALS['TSFE']->id, 'gastro_tags');

			$specTags = array_merge($specTagsShop, $specTagsGastro);


			if (count($specTagsShop) > 0) {
				$settings['teaserwall']['types'] .= Shop::TYPE . ',';
			}

			if (count($specTagsGastro) > 0) {
				$settings['teaserwall']['types'] .= Gastro::TYPE . ',';
			}

			if (!$settings['teaserwall']['types']) {
				$settings['teaserwall']['types'] = $type;
			}

			$settings['teaserwall']['types'] = rtrim($settings['teaserwall']['types'], ',');

			$settings['teaserwall']['tags'] = $tags;
			$settings['teaserwall']['specTags'] = $specTags;
		}
		return $settings;
	}

	/**
	 * Fills teaserwall settings based on the page itself.
	 * This only working with SERVICE::LIST_DOKTYPE correctly. (!!!)
	 *
	 * @param bool $forceSettings Set the settings even if the page not a list_doktype
	 * @return mixed
	 */
	protected function fillServicesSettingsFromPage($forceSettings = false)
	{
		$settings['teaserwall'] = [];
		if ((isset($GLOBALS['TSFE']->page['doktype'])
				&& $GLOBALS['TSFE']->page['doktype'] == Service::LIST_DOKTYPE)
			|| (isset($GLOBALS['TSFE']->page['backend_layout'])
				&& $GLOBALS['TSFE']->page['backend_layout'] == 'pagets__serviceListPage')
			|| $forceSettings) {
			//Prepare settings for this plugin (it has no settings)
			$settings['teaserwall']['cols'] = isset($this->settings['serviceList']['cols']) ? (int)$this->settings['serviceList']['cols'] : 4;
			$settings['teaserwall']['rows'] = isset($this->settings['serviceList']['rows']) ? (int)$this->settings['serviceList']['rows'] : 20;
			$settings['teaserwall']['sorting'] = isset($this->settings['serviceList']['orderBy']) ? (int)$this->settings['serviceList']['orderBy'] : RecordBaseRepository::SORTING_TITLE;

			$type = Service::TYPE;

			if (isset($GLOBALS['TSFE']->page['service_tag'])
				&& $GLOBALS['TSFE']->page['service_tag']) {
				/** @var Tag $tag */
				$tag = $this->tagRepository->findByUid($GLOBALS['TSFE']->page['service_tag']);
				$tagUids = explode(',', $GLOBALS['TSFE']->page['service_tag']);

				// General tags are normal tags, otherwise we are talking about a special tag
				if ($tag->getType() === RecordBase::TYPE) {
					$settings['teaserwall']['tags'] = $tagUids;
				} else {
					$settings['teaserwall']['specTags'] = $tagUids;
				}

			}

			$settings['teaserwall']['types'] = $type;
		}
		return $settings;
	}

	/**
	 * @param int $elements
	 * @return array
	 */
	protected function getRecords($elements = 0)
	{
		$results = $this->recordBaseRepository->findRecords(ScopeConfiguration::getScope(), $this->settings['teaserwall'], $elements);
		unset($center);

		return $results;
	}

	/**
	 * @param $wallItems
	 * @return mixed
	 */
	protected function createClassForInactiveTeasers($wallItems)
	{
		foreach ($wallItems as $wallItem) {
			if ($wallItem->getEndtime() != 0) {
				$start = date_create('@' . $wallItem->getEndtime());
				$end = date_create(); // Current time and date
				$diff = date_diff($start, $end);

				if (($diff->invert == 0)) {
					$wallItem->setInactiveClass('tsr--disabled');
				}
			}
		}
		return $wallItems;
	}

	/**
	 * Renders a list of different record base elements
	 *
	 * @param int $elements
	 * @return void
	 */
	protected function listRecords($elements = 0)
	{
		$wallItems = $this->getRecords($elements);

		$contentObj = $this->configurationManager->getContentObject();

		CacheHelper::addTeaserWallCacheTags($contentObj, $wallItems, $this->settings['rootPageId']);

		$currentElementCount = $elements + count($wallItems);

		if ($this->settings['teaserwall']['bookmarksOnly'] == 1) {
			$wallItems = $this->createClassForInactiveTeasers($wallItems);
		}

		$this->view->assign('items', $wallItems);
		$this->view->assign('elements', $currentElementCount);
		$this->view->assign('cid', $contentObj->data['uid']);
		$this->view->assign('pageId', (int)$GLOBALS['TSFE']->id);
		$this->view->assign('needLoadMore', $this->needLoadMoreButton($currentElementCount));
		$this->view->assign('center', ScopeConfiguration::getScope());
	}


	protected function assignTeasersByUidsAndFallback($uids, $variableName = 'teasers', $forceTeaserFormatToOne = true)
	{
		$teasers = $this->assignTeasersByUids($uids, $variableName, $forceTeaserFormatToOne, false);
		$teaserCount = count($teasers);
		$teasers = $this->getFallBackTeasers($teaserCount, $teasers);
		$this->view->assign($variableName, $teasers);
	}

	protected function assignTeasersAutomaticAndFallback($variableName = 'teasers')
	{
		$types['types'] = str_replace('-', ',', $this->settings['hometeaser']['types']);
		$customLimit = 0;
		if ($this->settings['hometeaser']['automaticContent']) {
			$customLimit = $this->settings['maxNumberHomeTeaser'];
		}

		$teasers = $this->recordBaseRepository->findRecords(
			ScopeConfiguration::getScope(),
			$types,
			$offset = 0,
			$customLimit,
			$this->settings['hometeaser']['automaticContent']
		);

		$teaserCount = count($teasers);
		$teasers = $this->getFallBackTeasers($teaserCount, $teasers);
		$this->view->assign($variableName, $teasers);
	}

	protected function getFallBackTeasers($teaserCount, $teasers)
	{
		if ($teaserCount < 3 && $teaserCount > 0) {
			$fallBackTeasers = $this->recordBaseRepository->findFallBackTeasrs(
				ScopeConfiguration::getScope(),
				$teaserCount);
			foreach ($fallBackTeasers as $fallBackTeaser) {
				$teasers[] = $fallBackTeaser;
			}
		}
		return $teasers;
	}


	/**
	 * Register teasers for the view
	 *
	 * @param string $uids comma separeted list of type_uids or a single value
	 * @param string $variableName the name for the view
	 * @param boolean $forceTeaserFormatToOne force the teaser format to take the single column version
	 * @param boolean $assignVariable assigns the selected teasers to the $variableName
	 *
	 * @return boolean|array
	 */
	protected function assignTeasersByUids($uids, $variableName = 'teasers', $forceTeaserFormatToOne = true, $assignVariable = true)
	{
		$teasers = [];
		if ($uids) {
			$typesAndUids = [];

			$recordTypes = explode(',', $uids);

			foreach ($recordTypes as $recordType) {
				if ($recordType) {
					$typeAndUid = preg_split('/--/', $recordType);

					if (isset($typeAndUid[0]) && $typeAndUid[0]
						&& isset($typeAndUid[1]) && $typeAndUid[1]
					) {
						$typesAndUids[$typeAndUid[0]][] = $typeAndUid[1];
					}
				}
			}

			$teasers = $this->recordBaseRepository->findRecordsByUid(ScopeConfiguration::getScope(), $typesAndUids, $recordTypes, $forceTeaserFormatToOne);

			$contentObj = $this->configurationManager->getContentObject();

			CacheHelper::addTeaserWallCacheTags($contentObj,
				$teasers,
				$this->settings['rootPageId']);

			if ($assignVariable) {
				$this->view->assign($variableName, $teasers);
			}

		}

		return $assignVariable ? $assignVariable : $teasers;
	}

	/**
	 * Returns a json string based on the action's view.
	 * !!!The view here is defined by the calling action!!!
	 *
	 * @param int $elements
	 * @param array $settings
	 * @return string
	 */
	protected function getJsonResponseFromView($elements, $settings)
	{
		$count = count($settings);
		$action = 'ajaxList';
		if ($count > 0 && isset($settings['teaserwall'])) {
			$this->settings['teaserwall'] = $settings['teaserwall'];
		}
		if ($count > 0 && isset($settings['teaserwall']['action'])) {
			$action = $settings['teaserwall']['action'];
		}
		$wallItems = $this->getRecords($elements);

		$contentObj = $this->configurationManager->getContentObject();

		CacheHelper::addTeaserWallCacheTags($contentObj,
			$wallItems,
			$this->settings['rootPageId']);

		$this->view->assign('items', $wallItems);

		if (isset($settings['teaserwall']['cid'])) {
			$cid = $settings['teaserwall']['cid'];
		} else {
			$cid = $contentObj->data['uid'];
		}

		$currentElementCount = $elements + count($wallItems);

		//We send an url only if there are records for the next page
		$needLoadMore = $this->needLoadMoreButton($currentElementCount);

		$uri = '';

		if ($needLoadMore) {
			$this->uriBuilder->reset();
			$this->uriBuilder->setTargetPageUid((int)$GLOBALS['TSFE']->id)
				->setTargetPageType((int)$this->settings['ajaxTeaserWall'])
				->setArguments(['tx_center_teaserwall' => [
					'controller' => 'RecordBase',
					'action' => $action,
					'cid' => $cid,
					'elements' => $currentElementCount,
				]]);
			$uri = $this->uriBuilder->build();
		}


		$response = [
			'url' => $uri,
			'content' => trim($this->view->render())
		];

		return json_encode($response);
	}

	//endregion


}
