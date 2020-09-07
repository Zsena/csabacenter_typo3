<?php
namespace DigitalZombies\Center\Controller;

use DigitalZombies\Center\Domain\Model\Misc\Sender;
use DigitalZombies\Center\Domain\Model\Records\Offer;
use DigitalZombies\Center\Domain\Model\Shop\Gastro;
use DigitalZombies\Center\Domain\Model\Shop\Shop;
use DigitalZombies\Center\Domain\Repository\Records\OfferRepository;
use DigitalZombies\Center\Domain\Repository\Shop\ShopRepository;
use DigitalZombies\Center\Configuration\ScopeConfiguration;
use DigitalZombies\Center\Utility\Page\PageUtility;
use DigitalZombies\Center\Utility\ShopOpeningsHelper;
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
 * Class NewsController
 * @package DigitalZombies\Center\Controller
 */
class ShopController  extends RecordBaseBaseController
{
	/**
	 * @var PageRepository
	 */
	protected $pageRepository;

	/**
	 * @var ShopRepository
	 */
	protected $shopRepository;

	/**
	 * @var OfferRepository
	 */
	protected $offerRepository;

	/**
	 * @param \TYPO3\CMS\Frontend\Page\PageRepository $repository
	 *
	 * @return void
	 */
	public function injectPageRepository(PageRepository $repository){
		$this->pageRepository = $repository;
	}

	/**
	 * @param ShopRepository $repository
	 *
	 * @return void
	 */
	public function injectShopRepository(ShopRepository $repository){
		$this->shopRepository = $repository;
	}

	/**
	 * @param OfferRepository $repository
	 *
	 * @return void
	 */
	public function injectOfferRepository(OfferRepository $repository){
		$this->offerRepository = $repository;
	}

	/**
	 * Lists all shops as a json array or an empty string if none exists
	 *
	 * @return string
	 */
	public function ajaxListAllAction(){
		if(ScopeConfiguration::hasCenter()) {
			/** @var array $shops */
			$shops = $this->shopRepository->findByCenter(ScopeConfiguration::getScope()->getUid());
			if(count($shops) > 0) {
				$this->view->assign('shops', $shops);
				return $this->view->render();
			}
		}
		return '';
	}

	/**
	 * Lists all shops as a json array or an empty string if none exists
	 *
	 * @return string
	 */
	public function ajaxListAll1_1_0Action(){
		$resultsArray["shops"] = [];
		if(ScopeConfiguration::hasCenter()) {
			/** @var array $shops */
			$shops = $this->shopRepository->findByCenter(ScopeConfiguration::getScope()->getUid());

			/** @var array $offers */
			$offers = $this->offerRepository->listAllForCenter(ScopeConfiguration::getScope()->getUid());
			$shopsWithOffer = [];
			/** @var Offer $offer */
			foreach ($offers as $offer) {
				if($offer->getSender()->getSenderType() === Sender::SENDER_SHOP) {
					$shopsWithOffer[$offer->getSender()->getShop()->getUid()][] = $offer->getUid();
				}

			}
			/** @var Shop $shop */
			foreach ($shops as $shop) {
				$this->view->assign('shop', $shop);
				$thumbnailUrl = trim($this->view->render());

				$shopArray = $this->fillFromShop($shop);

				if(key_exists($shop->getUid(), $shopsWithOffer)) {
					foreach ($shopsWithOffer[$shop->getUid()] as $offerId) {
						$shopArray['offers'][] = [
							'uid' => $offerId
						];
					}
				}

				$shopArray['thumbnail'] = $thumbnailUrl;
				$shopArray['openings'] = ShopOpeningsHelper::createOpeningsArrayForShop($shop, $this->settings['dateFormat']['baseStrftime']);
				$resultsArray["shops"][] = $shopArray;
			}
		}

		return json_encode($resultsArray);
	}

	/**
	 * Get tags to the shop categories and send a json response
	 *
	 * @return string
	 */
	public function getShopCategoriesAction(){
		$response['categories'] = [];
		$sorting = 'sorting';
		$field = '*';
		$where = 'AND hidden = 0 AND deleted = 0 AND nav_hide = 0 AND doktype IN (' . Shop::LIST_DOKTYPE .',' . Gastro::LIST_DOKTYPE . ')';

		$level1Pages = $this->pageRepository->getMenu(ScopeConfiguration::getScope()->getPageId());

		foreach ($level1Pages as $parentPage) {
			$pages = $this->pageRepository->getMenu($parentPage['uid'], $field, $sorting, $where);
			$pages = PageUtility::hideNoneTranslated($this->pageRepository->getPagesOverlay($pages, $GLOBALS['TSFE']->sys_language_uid));
			foreach ($pages as $page) {
				$tags = $this->shopRepository->findShopTags($page['uid']);

				if(count($tags) > 0) {
					$category = [
						'uid' => $page['uid'],
						'title' => $page['title'],
						'types' => [],
						'tags' => $tags
					];
					if($page['shop_tags']) {
						$category['types'][] = 'shop';
					}
					if($page['gastro_tags']) {
						$category['types'][] = 'gastro';
					}

					$response['categories'][] = $category;
				}
			}
		}

		return json_encode($response);
	}


	/**
	 * Renders a detail page for News
	 *
	 */
	public function showFilterAction(){

		$sorting = 'sorting';
		$field = 'uid, title';
		$where = 'AND hidden = 0 AND deleted = 0 AND nav_hide = 0 AND doktype = ' . Shop::LIST_DOKTYPE;

		$currentPid = $GLOBALS['TSFE']->page['pid'];

		$parentPage = $this->pageRepository->getPage($currentPid);

		$mainLevelUid = $GLOBALS['TSFE']->page['pid'];
		$secondLevelUid = $GLOBALS['TSFE']->page['uid'];

		$activeMainLevel = $GLOBALS['TSFE']->id;
		$activeSecondLevel = 0;

		if(isset($parentPage['doktype'])
		&& $parentPage['doktype'] == Shop::LIST_DOKTYPE) {
			$mainLevelUid = $parentPage['pid'];
			$secondLevelUid = $parentPage['uid'];

			$activeMainLevel = $GLOBALS['TSFE']->page['pid'];
			$activeSecondLevel = $GLOBALS['TSFE']->page['uid'];
		}

		$type = Shop::TYPE;
		$subCategories = [];
		// 31.08.2017 Quickfix vor Livegang da zum Livegang keine Subkategorien für Gastro verfügbar
		$showSubCategories = true;
		$placeHolderKey = 'fe.shopfilter.placeHolder.shopName';
		$filterValue = 'shop';

		if(isset($GLOBALS['TSFE']->page['shop_list_type'])) {
			$type = $GLOBALS['TSFE']->page['shop_list_type'];
		}

		if($type == Gastro::TYPE) {
			$placeHolderKey = 'fe.shopfilter.placeHolder.gastroName';
			$filterValue = 'gastro';
			$showSubCategories = false;
		}
		$this->pageRepository->where_groupAccess = $this->pageRepository->getMultipleGroupsWhereClause('pages.fe_group', 'pages');
		$categories = $this->pageRepository->getMenu($mainLevelUid, $field, $sorting, $where);
		$categories =  PageUtility::hideNoneTranslated($this->pageRepository->getPagesOverlay($categories, $GLOBALS['TSFE']->sys_language_uid));

		if($showSubCategories) {
			$subCategories = $this->pageRepository->getMenu($secondLevelUid, $field, $sorting, $where);
			$subCategories =  PageUtility::hideNoneTranslated($this->pageRepository->getPagesOverlay($subCategories, $GLOBALS['TSFE']->sys_language_uid));
		}

		$page1 = null;
		$page2 = null;
		$primaryPage = null;

		if(isset($this->settings['shopfilter']['page1']['page']) && $this->settings['shopfilter']['page1']['page']) {
			$page1 = $this->settings['shopfilter']['page1'];
		}

		if(isset($this->settings['shopfilter']['page2']['page']) && $this->settings['shopfilter']['page2']['page']) {
			$page2 = $this->settings['shopfilter']['page2'];
		}

		$secondaryPage = $page2;

		// If we have page2 and page1 then page1 is the primary ribbon and page2 is the second
		if($secondaryPage && $page1) {
			$primaryPage = $page1;
			//if only page1 is set it will be a "secondary" ribbon.
		} else if ($page1) {
			$secondaryPage = $page1;
		}

		$this->view->assign('categoryPages', $categories);
		$this->view->assign('subCategoryPages', $subCategories);
		$this->view->assign('showSubCategories', $showSubCategories);
		$this->view->assign('currentMainLevelUid',$activeMainLevel);
		$this->view->assign('currentSecondLevelUid', $activeSecondLevel);
		$this->view->assign('primaryPage', $primaryPage);
		$this->view->assign('secondaryPage', $secondaryPage);
		$this->view->assign('pageUid', $GLOBALS['TSFE']->id);
		$this->view->assign('L', $GLOBALS['TSFE']->sys_language_uid);
		$this->view->assign('language', $GLOBALS['TSFE']->config['config']['language']);
		$this->view->assign('filterValue', $filterValue);
		$this->view->assign('placeHolderKey', $placeHolderKey);

	}
}