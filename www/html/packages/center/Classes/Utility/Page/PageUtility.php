<?php
namespace DigitalZombies\Center\Utility\Page;

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


class PageUtility
{

	/**
	 * Hides pages if they should not be visible for the current language
	 *
	 * @param array $pages - Array of pages
	 * @param int $language - (optional) if the check should be made for a specific language
	 * @return array
	 */
	public static function hideNoneTranslated($pages, $language = -1)
	{
		if($language < 0) {
			$language = $GLOBALS['TSFE']->sys_language_uid;
		}
		$translatedPages = [];

		foreach ($pages as $pageUid => $page) {
			if (($page['l18n_cfg'] === 1 && $language == 0)
				|| ($language > 0 && !($page['l18n_cfg'] & 2) && !isset($page['_PAGES_OVERLAY']))) {
				continue;
			}
			$translatedPages[$pageUid] = $page;
		}

		return $translatedPages;
	}


}