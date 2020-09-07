<?php

namespace DigitalZombies\Center\UserFunc;

use DigitalZombies\Center\Helper\TokenHelper;
use DigitalZombies\Center\Service\ProductAPIService;
use TYPO3\CMS\Backend\Utility\BackendUtility;

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
class DigitalMallShops
{

    /**
     * Adds each type of recordbase objects only with teaser_format = 2
     *
     * @param $config
     */
    public function listAll(&$config)
    {
        $items = [];
        $rootPid = $config['flexParentDatabaseRow']['pid'];
        if (!$rootPid) {
            $rootPid = $this->getRootPageIdFromQuery();
        }
        $tsConfig = BackendUtility::getPagesTSconfig($rootPid);
        if (isset($tsConfig['TCEMAIN.']['params.']['digitalMallApi'])) {
            $domain = $tsConfig['TCEMAIN.']['params.']['digitalMallApi'];
            $centerShortName = $tsConfig['TCEMAIN.']['params.']['centerShortName'];

            $productsJson = ProductAPIService::sendRequest(TokenHelper::getUrl($domain,
                TokenHelper::MODE_PARTICIPANT_SHOPS, $centerShortName),
                '', '', '', [], 'retailers', false);

            if ($productsJson['status']) {
                foreach ($productsJson['retailers'] as $item) {
                    if(isset($item['cmsId'])
                        && $item["retailerProductPageUrl"]
                        && $item["retailerProductPageUrl"] != '#404-category-not-found')
                    $items[] = [
                        0 => $item["retailerName"],
                        1 => $item["cmsId"]
                    ];
                }
            }
        }
        $config['items'] = $items;

    }

    public function getRootPageIdFromQuery()
    {
        $query = parse_url($_GET['returnUrl']);
        if (isset($query['query'])) {
            parse_str(urldecode($query['query']), $query['query']);
        }

        return $query['query']['id'];
    }

}
