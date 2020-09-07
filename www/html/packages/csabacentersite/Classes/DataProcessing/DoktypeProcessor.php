<?php
namespace DigitalZombies\Csabacentersite\DataProcessing;

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

use DigitalZombies\Center\Domain\Model\Records\Blog;
use DigitalZombies\Center\Domain\Model\Shop\Gastro;
use DigitalZombies\Center\Domain\Model\Shop\Shop;
use DigitalZombies\Center\Mapper\RecordBaseDataMapper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

/**
 * Class DoktypeProcessor
 * @package DigitalZombies\Csabacentersite\DataProcessing
 */
class DoktypeProcessor implements DataProcessorInterface
{

    /**
     * Maps the current page to an object if it is possible based on the doktype property
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
    	if(isset($processedData['data']['doktype'])) {

			$mappedObject = null;

    		/** @var ObjectManager $objectManager */
    		$objectManager = GeneralUtility::makeInstance(ObjectManager::class);

    		/** @var RecordBaseDataMapper $dataMapper */
    		$dataMapper = $objectManager->get(RecordBaseDataMapper::class);
			if((int)$processedData['data']['doktype'] === Shop::DOKTYPE
				||  (int)$processedData['data']['doktype'] === Gastro::DOKTYPE) {

				$mappedObject = $dataMapper->map(Shop::class, [$processedData['data']]);

				if(count($mappedObject) > 0) {

					$processedData['shop'] = $mappedObject[0];
				}

			} else if ((int)$processedData['data']['doktype'] === Blog::DOKTYPE ) {

				$mappedObject = $dataMapper->map(Blog::class, [$processedData['data']]);

				if(count($mappedObject) > 0) {
					$processedData['blog'] = $mappedObject[0];
				}

			}
		}

        return $processedData;
    }
}
