<?php
namespace DigitalZombies\Center\Utility;

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

use DigitalZombies\Center\Domain\Model\Center\CenterLevel;
use DigitalZombies\Center\Domain\Repository\Center\CenterLevelPositionRepository;
use DigitalZombies\Center\Configuration\ScopeConfiguration;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;
use \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class JSONHelper
{

    /**
     * Creates a valid json for the 3rd party mapplic plugin.
     *
     * @return null|string
     */
    public static function createPlan()
    {
        if(ScopeConfiguration::hasCenter())
            $usedCategoryIds = [];

        $mapWidth = 1000;
        $mapHeight = 600;

        $centerConfig = [];

        $centerConfig['categories'] = [];
        $centerConfig['levels'] = [];

        // internationalization
        $centerConfig['i18n'] = [];
        $centerConfig['i18n']['mapplicSearchLabel'] = LocalizationUtility::translate('fe.mapplic.search.label', 'center');
        $centerConfig['i18n']['mapplicPopupLink'] = LocalizationUtility::translate('fe.mapplic.popup.link', 'center');
        $centerConfig['i18n']['mapplicNotFoundMessage'] = LocalizationUtility::translate('fe.mapplic.notFound.message', 'center');

        $mapSizeSet = false;

        /** @var ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        /** @var \DigitalZombies\Center\Domain\Repository\Center\CenterLevelPositionRepository $centerLevelPositionRepository */
        $centerLevelPositionRepository = $objectManager->get(CenterLevelPositionRepository::class);
        /** @var UriBuilder $uriBuilder */
        $uriBuilder = $objectManager->get(UriBuilder::class);

        $settings = JSONHelper::getTyposcriptSettings();

        $categoryId = 0;

        $locationsToMerge = [];
        /** @var CenterLevel $centerLevel */
        foreach (ScopeConfiguration::getScope()->getLevels() as $centerLevel) {

            if(!$mapSizeSet
                && $centerLevel->getImage()) {
                /** @var File $originalFile */
                $originalFile = $centerLevel->getImage()->getOriginalResource()->getOriginalFile();
                $mapWidth = $originalFile->getProperty('width');
                $mapHeight = $originalFile->getProperty('height');

                $mapSizeSet = true;
            }

            $positions = $centerLevelPositionRepository->findByCenterLevel($centerLevel->getUid());

            $locations = [];
            $titles = [];
            $links = [];

            /** @var \DigitalZombies\Center\Domain\Model\Center\CenterLevelPosition $position */
            foreach ($positions as $position) {
                $parent = $position->getParent();
                if($position->getParent()) {

                    $category = $parent->getCategory();

                    if($parent->getCategory()=="service"){
                        /** @var \DigitalZombies\Center\Domain\Model\Records\Service $parent */
                        if($parent->isElevator() && $position->getX()){
                            $category = 'elevator';
                        }
                    }

                    if (!in_array($category, $usedCategoryIds)) {
                        $centerConfig['categories'][$category] = [
                            'id' => $categoryId++,
                            'title' => LocalizationUtility::translate('fe.mapplic.category.' . $category,
                                'center'),
                            'show' => 'false'
                        ];
                        $usedCategoryIds[] = $category;
                    }

                    $imagePath = '';

                    /** @var \TYPO3\CMS\Extbase\Domain\Model\FileReference $logo */
                    $logo = $parent->getThumbnail();
                    if ($logo) {

                        $imagePath = $logo->getOriginalResource()->getPublicUrl();
                    }

                    if ($position->getPathID()) {
                        $link = null;
                        $type = 'location';

                        $id = 0;
                        if ($position->getShop() != null) {
                            $type = 'shop';
                            $id = $position->getShop()->getUid();
                        } else if ($position->getService() != null) {
                            if($position->getService()->isElevator()){
                                $type = 'elevator';
                                $id = $position->getService()->getUid();
                            }else{
                                $type = 'service';
                                $id = $position->getService()->getUid();
                            }
                        }

                        if (array_key_exists($type . $id, $links)) {
                            $link = $links[$type . $id];
                        } else {
                            $uriBuilder->reset();
                            if ($type === 'shop') {
                                $link = $uriBuilder->setTargetPageUid($position->getShop()->getUid())->build();
                            } else if ($type === 'service' || $type === 'elevator') {
                                $link = $uriBuilder
                                    ->setTargetPageUid($settings['detailPages']['service'])
                                    ->uriFor('show', ['service' => $position->getService()->getUid()], 'Service', 'center', 'Service');

                            }
                            $links[$type . $id] = $link;
                        }

                        $title = $parent->getTitle();
                        if (key_exists($title, $titles)) {
                            $titles[$title] = $titles[$title] + 1;

                            $title = $title . ' ' . $titles[$title];
                        } else {
                            $titles[$title] = 1;
                        }
                        $locations[] = [
                            "id" => $position->getPathID(),
                            "title" => $title . ', ' . $centerLevel->getShortName(),
                            "description" => $parent->getDescription(),
                            "category" => $centerConfig['categories'][$category]['id'],
                            "thumbnail" => '/' . $imagePath,
                            "link" => $link,
                            "x" => $position->getX(),
                            "y" => $position->getY(),
                            "zoom" => 0.9,
                            "type" => $type
                        ];
                    }
                }

                unset($parent);
            }

            $centerConfig['levels'][] = [
                "id" => "level" . $centerLevel->getUid(),
                "title" => $centerLevel->getLabel(),
                "map" => '/' . $centerLevel->getImage()->getOriginalResource()->getOriginalFile()->getPublicUrl(),
                "locations" => $locations
            ];

            $locationsToMerge[] = $locations;
        }

        $centerConfig['locations'] = self::mergeAndSortLocations($locationsToMerge);

        $centerConfig['mapwidth'] = $mapWidth;
        $centerConfig['mapheight'] = $mapHeight;

        return json_encode($centerConfig);
    }


    /**
     * @param null $array
     * @return array
     */
    public static function mergeAndSortLocations($locations = null) {
        $result = call_user_func_array("array_merge", $locations);

        usort($result, function($a, $b) {
            return strtolower($a['title']) <=> strtolower ($b['title']);
        });

        return $result;
    }


    /**
     * Returns a JSON response with opening hours and the next special closing day
     *
     * @param string $dateFormat
     * @return string
     */
    public static function createOpeningHoursJSONResponse($dateFormat)
    {
        $openingHours = OpeningHoursHelper::createOpeningHoursForCenter($dateFormat);

        return json_encode($openingHours);
    }


    /**
     * Returns the TypoScript setting of a given extension
     *
     * @param string $extension name of the extension to retrieve the settings from
     * @return mixed Plain settings array
     */
    public static function getTyposcriptSettings($extension = 'center'){
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var ConfigurationManagerInterface $configurationManager */
        $configurationManager = $objectManager->get(ConfigurationManagerInterface::class);

        return $configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            $extension
        );
    }

}
