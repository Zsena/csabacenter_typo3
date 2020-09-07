<?php

namespace DigitalZombies\Center\UserFunc;

use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Frontend\Page\PageRepository;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 David Miltz <D.Miltz@plan-net.com>
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
class LanguageMenu
{
    /**
     * Returns field tta or centername from center record for title tag
     *
     * @return string
     */
    public function makeLanguageMenu()
    {
        /** @var ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var ConfigurationManagerInterface $configurationManager */
        $configurationManager = $objectManager->get(ConfigurationManagerInterface::class);

        $setting = $configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'center'
        );

        $languages = [];
        $languageMenu = [];

        if(isset($setting['availableTranslations'])) {
            //
        } else {
            // Possible languages
        }

        $result = "TEST";

        /** @var PageRepository $pageRepository */
        $pageRepository = $objectManager->get(PageRepository::class);

        /** @var UriBuilder $uriBuilder */
        $uriBuilder = $objectManager->get(UriBuilder::class);

        $currentPageId = $GLOBALS['TSFE']->id;

        foreach ($languages as $language) {
            $translation = $pageRepository->getPageOverlay($currentPageId, $language);

            if(count($translation) > 0) {
                //generate link
                $languageMenu[$language] = [
                    'label' => 'xx',
                    'url' => $uriBuilder->reset()->setTargetPageUid($currentPageId)
                        ->setAddQueryString(true)
                        ->setArguments(['L' => $language])
                        ->buildFrontendUri()
                ];
            }
        }

        //Template usage


        return $result;
    }
}

?>