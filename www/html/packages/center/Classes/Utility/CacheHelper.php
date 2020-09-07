<?php
namespace DigitalZombies\Center\Utility;
use DigitalZombies\Center\Domain\Model\RecordBase;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;


/***************************************************************
 *  Copyright notice
 *
 *    Based on:
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


class CacheHelper
{


	/**
	 * @param ContentObjectRenderer $contentObj
	 * @param array $teasers
	 * @param int $rootPageUid
	 */
	public static function addTeaserWallCacheTags(&$contentObj, $teasers, $rootPageUid = 0) {
		$cacheTags = '';

		if($rootPageUid) {
			$cacheTags = 'teaserwall_' . $rootPageUid . ',';
		}

		/** @var RecordBase $teaser */
		foreach ($teasers as $teaser) {
			$cacheTags .= $teaser::TABLE_NAME . '_post_' . $teaser->getUid() . ',';
		}

		$contentObj->stdWrap_addPageCacheTags('', [
			'addPageCacheTags' => rtrim($cacheTags, ',')
		]);
	}
}


?>