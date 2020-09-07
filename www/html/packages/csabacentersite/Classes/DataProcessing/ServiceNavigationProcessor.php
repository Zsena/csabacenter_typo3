<?php

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\TypoScript\TypoScriptService;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

/**
 * Class SettingsProcessor
 * @package DigitalZombies\Csabacentersite\DataProcessing
 */
class ServiceNavigationProcessor implements DataProcessorInterface
{

    /**
     * Adds the csabacentersite settings to each page (it is needed for partials mainly)
     *
     * @param \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer $cObj The data of the content element or page
     * @param array $contentObjectConfiguration The configuration of Content Object
     * @param array $processorConfiguration The configuration of this processor
     * @param array $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     *
     * @return array the processed data as key/value store
	 * @throws \Exception
     */
    public function process(ContentObjectRenderer $cObj, array $contentObjectConfiguration, array $processorConfiguration, array $processedData)
    {
		if(isset($contentObjectConfiguration['settings.'])) {

			$serviceMenuPages = [];
			if(isset($contentObjectConfiguration['settings.']['detailPages.']['openingHours'])
                && $contentObjectConfiguration['settings.']['detailPages.']['openingHours']) {
				$serviceMenuPages[] = [
					'id' => $contentObjectConfiguration['settings.']['detailPages.']['openingHours'],
					'svgKey' => 'time',
				];
			}
			if(isset($contentObjectConfiguration['settings.']['detailPages.']['directions'])
                && $contentObjectConfiguration['settings.']['detailPages.']['directions']) {
				$serviceMenuPages[] = [
					'id' => $contentObjectConfiguration['settings.']['detailPages.']['directions'],
					'svgKey' => 'location',
				];
			}
			if(isset($contentObjectConfiguration['settings.']['detailPages.']['centerPlan'])
                && $contentObjectConfiguration['settings.']['detailPages.']['centerPlan']) {
				$serviceMenuPages[] = [
					'id' => $contentObjectConfiguration['settings.']['detailPages.']['centerPlan'],
					'svgKey' => 'map',
				];
			}
			if(isset($contentObjectConfiguration['settings.']['detailPages.']['contact'])
                && $contentObjectConfiguration['settings.']['detailPages.']['contact']) {
				$serviceMenuPages[] = [
					'id' => $contentObjectConfiguration['settings.']['detailPages.']['contact'],
					'svgKey' => 'call',
				];
			}

			$processedData['serviceNavigation'] = $serviceMenuPages;
		}

        return $processedData;
    }
}
