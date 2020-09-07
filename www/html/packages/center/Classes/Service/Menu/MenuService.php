<?php

namespace DigitalZombies\Center\Service;

use DigitalZombies\Center\Utility\Page\PageUtility;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Frontend\Page\PageRepository;

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
class MenuService implements SingletonInterface
{

    /**
     * Returns a menu from a parentId
     *
     * @param int $pid
     * @param int $depth
	 * @param int $language - (optional) if the check should be made for a specific language
	 * @param boolean $forceMenu - (optional) if the menu should shown anyway
     * @return array
     */
    public static function buildSiblingsAnsSubpages($pid, $depth = 1, $language = -1, $forceMenu = false)
    {
    	if($language < 0) {
    		$language = $GLOBALS['TSFE']->sys_language_uid;
		}

        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var \TYPO3\CMS\Frontend\Page\PageRepository $pageRepository */
        $pageRepository = $objectManager->get(PageRepository::class);
        $modifiedPid = self::getParentPage($pid, $pageRepository->getRootLine($pid));

        $additionalWhere = 'AND doktype < 200 AND hidden = 0 AND deleted = 0 AND nav_hide = 0 AND (starttime = 0 OR starttime < UNIX_TIMESTAMP()) AND (endtime = 0 OR endtime > UNIX_TIMESTAMP())';

        //if we check the grandparent we need to increase the levels of the menu with one
        if ($modifiedPid !== $pid) {
            $depth++;
        }
		$pageRepository->where_groupAccess = $pageRepository->getMultipleGroupsWhereClause('pages.fe_group', 'pages');

        $pages = $pageRepository->getMenu($modifiedPid, '*', 'sorting', $additionalWhere);
        $pages = PageUtility::hideNoneTranslated($pageRepository->getPagesOverlay($pages, $language));

        self::fillSubPages($pages, $pageRepository, '*', 'sorting', $additionalWhere, $depth, $language);

        if(!$forceMenu) {
			// ECER-530 Check if parent is root -> if yes check if page has subpages --> if no unset array pages and hide 2. level menu in fluidtemplate \ext\center\Resources\Private\Partials\RecordBase\Menu.html
			foreach ($GLOBALS['TSFE']->rootLine as $page) {
				if ($page['is_siteroot'] == 1 && $page['uid'] == $pid) {
					if (!isset($pages[$GLOBALS['TSFE']->id]['pages'])) {
						$pages = [];
					}
				}
			}
		}

        return $pages;
    }


    /**
     * @param array $pages
     * @param \TYPO3\CMS\Frontend\Page\PageRepository $pageRepository
     * @param string $fields
     * @param string $sorting
     * @param string $additionalWhere
     * @param int $depth
	 * @param int $language if the check should be made for a specific language
     */
    protected static function fillSubPages(&$pages, $pageRepository, $fields, $sorting, $additionalWhere, $depth, $language)
    {
        foreach ($pages as $pageId => $page) {
            $subPages = $pageRepository->getMenu($page['uid'], $fields, $sorting, $additionalWhere);
            if ($depth > 0) {
                self::fillSubPages($subPages, $pageRepository, $fields, $sorting, $additionalWhere, $depth - 1, $language);

                $pages[$pageId]['pages'] = PageUtility::hideNoneTranslated($pageRepository->getPagesOverlay($subPages, $language));
            }
        }
    }

    /**
     * @param int $pid
     * @param array $rootline
     * @return int
     */
    public static function getParentPage($pid, $rootline)
    {
        $pageCount = 0;

        foreach ($rootline as $page) {
            $pageCount++;
            if ($page['is_siteroot']) {
                break;
            }
        }

        if ($pageCount > 2) {
            $page = $rootline[count($rootline) - 1];
            $pid = $page['pid'];
        }

        return $pid;
    }

}

?>