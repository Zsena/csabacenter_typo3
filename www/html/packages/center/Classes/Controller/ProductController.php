<?php

namespace DigitalZombies\Center\Controller;

use DigitalZombies\Center\Domain\Model\Shop\Shop;
use DigitalZombies\Center\Domain\Repository\Shop\ShopRepository;
use DigitalZombies\Center\Helper\TokenHelper;
use DigitalZombies\Center\Service\ProductAPIService;

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
 * Class ProductController
 * @package DigitalZombies\Center\Controller
 */
class ProductController extends MetaTagBaseController
{

    const HOME_TEASER_LAYOUT_SLIDER = 'slider';
    const HOME_TEASER_LAYOUT_TAGS = 'tags';

    /**
     * @var ShopRepository
     */
    protected $shopRepository;

    /**
     * @param ShopRepository $repository
     *
     * @return void
     */
    public function injectShopRepository(ShopRepository $repository)
    {
        $this->shopRepository = $repository;
    }

    /**
     * Renders a home teaser for the digital mall's shops
     *
     */
    public function listDigitalMallShopsAction()
    {
        $uids = isset($this->settings['hometeaser']['records']) ? $this->settings['hometeaser']['records'] : '';
        $shops = [];
        $usedIds = [];

        $digitalMallShops = ProductAPIService::sendRequest(TokenHelper::getUrl($this->settings['productsApiDomain'],
            TokenHelper::MODE_PARTICIPANT_SHOPS, $this->settings['productsApiMallShortName']),
            '', '', '', [], 'retailers', false);

        if ($uids
            && isset($this->settings['hometeaser']['layout'])
            && $this->settings['hometeaser']['layout'] == self::HOME_TEASER_LAYOUT_TAGS) {
            $uidArray = explode(',', $uids);
            $sortId = 0;
            foreach ($uidArray as $uid) {
                /** @var Shop $shop */
                $shop = $this->shopRepository->findByUid($uid);
                $digitalMallShop = $this->getShopById($digitalMallShops["retailers"], $uid);
                $shops['00000000000' . $sortId . '_' . strtolower($shop->getUid())] = [
                    'uid' => $shop->getUid(),
                    'name' => $shop->getName(),
                    'link' => $digitalMallShop["retailerProductPageUrl"],
                    'new' => 1
                ];
                $sortId++;
                $usedIds[] = $uid;
            }
        }

        if ($digitalMallShops['status']) {

            foreach ($digitalMallShops["retailers"] as $digitalMallShop) {
                if (isset($digitalMallShop['cmsId']) && !in_array($digitalMallShop["cmsId"], $usedIds)) {
                    /** @var Shop $shop */
                    $shop = $this->shopRepository->findByUid($digitalMallShop['cmsId']);
                    if ($shop &&
                        $digitalMallShop["retailerProductPageUrl"]
                        && $digitalMallShop["retailerProductPageUrl"] != '#404-category-not-found') {
                        $shops[strtolower($shop->getName())] = [
                            'uid' => $shop->getUid(),
                            'name' => $shop->getName(),
                            'thumbnail' => $shop->getThumbnail(),
                            'link' => $digitalMallShop["retailerProductPageUrl"],
                        ];
                    }
                }
            }
        }
        ksort($shops);
        $this->view->assign('shops', $shops);
    }

    private function getShopById($digitalMallShops, $id)
    {
        $shop = [];
        foreach ($digitalMallShops as $digitalMallShop) {
            if ($digitalMallShop["cmsId"] == $id) {
                $shop = $digitalMallShop;
            }
        }
        return $shop;
    }

    /**
     * Renders a home teaser for the products
     *
     */
    public function listHomeTeasersAction()
    {

        $mode = TokenHelper::MODE_PRODUCTS;
        if (isset($this->settings['hometeaser']['mode'])) {
            $mode = (int)$this->settings['hometeaser']['mode'];
        }

        $domain = $this->settings['productsApiDomain'];
        $token = "";
        switch ($mode) {
            case TokenHelper::MODE_PRODUCTS:
                if (isset($this->settings['hometeaser']['productIds'])) {
                    $token = TokenHelper::encodeTokenForProducts($domain, $this->settings['hometeaser']['productIds']);
                }
                break;
            case TokenHelper::MODE_CATEGORY:
                if (isset($this->settings['hometeaser']['categoryId'])) {
                    $token = TokenHelper::encodeTokenForCategory($domain, $this->settings['hometeaser']['categoryId']);
                }
                break;
            case TokenHelper::MODE_SEARCH:
                if (isset($this->settings['hometeaser']['searchWord'])) {
                    $token = TokenHelper::encodeTokenForSearchWord($domain,
                        $this->settings['hometeaser']['searchWord']);
                }
                break;
            case TokenHelper::MODE_TOPSELLERS:
                $token = TokenHelper::encodeTokenForTopSellers($domain);
                break;
        }
        $this->view->assign("token", $token);

    }
}