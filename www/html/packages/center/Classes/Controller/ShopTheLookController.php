<?php

namespace DigitalZombies\Center\Controller;

use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Resource\Index\MetaDataRepository;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Service\ImageService;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2020- Fabian Gehrlicher <f.gehrlicher@plan-net.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
class ShopTheLookController extends ActionController
{
    const REST_PATH = "rest/products/";
    const PRODUCT_PARAMETER = "product";

    const EID_NAME = "shop_the_look";
    const TOKEN_PARAMTER = "token";

    function showAction()
    {
        $productDomain = $this->settings['productsApiDomain'];

        $products = $this->settings['productIds'];

        $encodedProducts = urlencode($products);

        $novomindUrl = $productDomain . self::REST_PATH . "?" . self::PRODUCT_PARAMETER . "=" . $encodedProducts;

        $encodedUrl = base64_encode($novomindUrl);

        $queryString = "?eID=" . self::EID_NAME . "&" . self::TOKEN_PARAMTER . "=" . $encodedUrl;

        $resourceFactory = ResourceFactory::getInstance();
        $metaDataRepo = MetaDataRepository::getInstance();

        if ($this->settings['image']) {
            $fileReference = $resourceFactory->getFileReferenceObject($this->settings['image'], [], true);
            $metaData = $metaDataRepo->findByFile($fileReference->getOriginalFile());

            $this->view->assign('image', $fileReference);
            $this->view->assign('imageheight', $metaData['height']);
            $this->view->assign('imagewidth', $metaData['width']);
        }

        try {
            $video = $resourceFactory->getFileReferenceObject($this->settings['video'], [], true);
            $this->view->assign('video', $video);
        } catch (\Exception $e) {
            $this->view->assign('video', '');
        }

        $this->view->assignMultiple(
            [
                'headline' => $this->settings['headline'],
                'ctaButtonText' => $this->settings['ctaButtonText'],
                'ctaButtonLink' => $this->settings['ctaButtonLink'],
                'layout' => $this->settings['layout'],
                'showVideoOnMobile' => $this->settings['showVideoOnMobile'],
                'numShownProducts' => $this->settings['numShownProducts'],
                'queryString' => $queryString,
            ]
        );
    }
}
