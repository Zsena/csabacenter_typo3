<?php
namespace DigitalZombies\Center\Helper;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009-2015 Ingo Renner <ingo@typo3.org>
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Fluid\View\StandaloneView;


class TokenHelper
{

	const MODE_PRODUCTS = 0;
	const MODE_CATEGORY = 1;
	const MODE_SEARCH = 2;
	const MODE_TOPSELLERS = 3;
	const MODE_PARTICIPANT_SHOPS = 4;

	/**
	 * @param string $domain
	 * @param string $productIds
	 * @return string
	 */
	static public function encodeTokenForProducts($domain, $productIds)
	{
		return self::encodeUrl($domain, self::MODE_PRODUCTS, $productIds);
	}

	/**
	 * @param string $domain
	 * @param int $categoryId
	 * @return string
	 */
	static public function encodeTokenForCategory($domain, $categoryId)
	{
		return self::encodeUrl($domain, self::MODE_CATEGORY, $categoryId);
	}

	/**
	 * @param string $domain
	 * @param string $searchWord
	 * @return string
	 */
	static public function encodeTokenForSearchWord($domain, $searchWord)
	{
		return self::encodeUrl($domain, self::MODE_SEARCH, $searchWord);
	}

    /**
     * @param string $domain
     * @param string $centerName
     * @return string
     */
    static public function encodeTokenForParticipantShops($domain, $centerName)
    {
        return self::encodeUrl($domain, self::MODE_PARTICIPANT_SHOPS, $centerName);
    }

	/**
	 * @param string $domain
	 * @return string
	 */
	static public function encodeTokenForTopSellers($domain)
	{
		return self::encodeUrl($domain, self::MODE_TOPSELLERS);
	}

	static public function getUrl($domain, $mode, $value = '') {
        $path = "rest/products";
        $query = "?";
        switch ($mode) {
            case self::MODE_PRODUCTS:
                $productIds = explode(',', $value);
                foreach ($productIds as $productId) {
                    $query .= 'product=' . urlencode($productId) . '&';
                }
                $query = rtrim($query, '&');
                break;
            case self::MODE_CATEGORY:
                $path .= "/category/";
                $query .= 'id=' . urlencode($value);
                break;
            case self::MODE_SEARCH:
                $path .= "/search/";
                $query .= 'q=' . urlencode($value);
                break;
            case self::MODE_TOPSELLERS:
                $path .= "/recommendation/";
                $query .= 'id=TopSeller';
                break;
            case self::MODE_PARTICIPANT_SHOPS:
                $path = "api/v1/retailer/" . $value . "/";
                $query = '';
                break;
        }

        $url = $domain . $path . $query;

        return $url;
    }

	static protected function encodeUrl($domain, $mode, $value = '') {
		return base64_encode(self::getUrl($domain, $mode, $value));
	}

	static public function decodeToken($token) {
		return base64_decode($token);
	}
}
