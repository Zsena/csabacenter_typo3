<?php

namespace DigitalZombies\Center\Hooks;

/***************************************************************
 *  Copyright notice
 *
 *  Based on:
 *
 *  (c) 2018 Victor Young <D.Miltz@plan-net.com>
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController;
use TYPO3\CMS\Extbase\Object\ObjectManager;

use DigitalZombies\Center\Configuration\ScopeConfiguration;
use DigitalZombies\Center\Domain\Repository\Bookmarks\BookmarksRepository;


class BookmarksHandler implements SingletonInterface
{
	/** @var BookmarksRepository $bookmarksRepository */
	protected $bookmarksRepository = null;

	public function contentPostProcAll(array $params, TypoScriptFrontendController &$parent)
	{
		$this->replaceMarkersInDetailPages($parent);
	}

	public function replaceMarkersInDetailPages($parent)
	{
		$value = '';

		if ($GLOBALS['HTTP_GET_VARS']['tx_center_offer']['offer']) {
			$marker = '/###BOOKMARKS_OFFER_ID###/';
			$value = $GLOBALS['HTTP_GET_VARS']['tx_center_offer']['offer'];
			$markerEndtime = '/###BOOKMARKS_OFFER_ENDTIME###/';
			$valueEndtime = $GLOBALS['HTTP_GET_VARS']['tx_center_offer']['endtime'];
		}

		if ($GLOBALS['HTTP_GET_VARS']['tx_center_coupon']['coupon']) {
			$marker = '/###BOOKMARKS_COUPON_ID###/';
			$value = $GLOBALS['HTTP_GET_VARS']['tx_center_coupon']['coupon'];
			$markerEndtime = '/###BOOKMARKS_COUPON_ENDTIME###/';
			$valueEndtime = $GLOBALS['HTTP_GET_VARS']['tx_center_coupon']['endtime'];

		}

		if ($GLOBALS['HTTP_GET_VARS']['tx_center_news']['news']) {
			$marker = '/###BOOKMARKS_NEWS_ID###/';
			$value = $GLOBALS['HTTP_GET_VARS']['tx_center_news']['news'];
			$markerEndtime = '/###BOOKMARKS_NEWS_ENDTIME###/';
			$valueEndtime = $GLOBALS['HTTP_GET_VARS']['tx_center_news']['endtime'];
		}

		if ($GLOBALS['HTTP_GET_VARS']['tx_center_event']['event']) {
			$marker = '/###BOOKMARKS_EVENT_ID###/';
			$value = $GLOBALS['HTTP_GET_VARS']['tx_center_event']['event'];
			$markerEndtime = '/###BOOKMARKS_EVENT_ENDTIME###/';
			$valueEndtime = $GLOBALS['HTTP_GET_VARS']['tx_center_event']['endtime'];
		}

		if ($marker) {
			$parent->content = preg_replace($marker, $value, $parent->content);
		}

		if ($markerEndtime) {
			$parent->content = preg_replace($markerEndtime, $valueEndtime, $parent->content);
		}
	}
}
