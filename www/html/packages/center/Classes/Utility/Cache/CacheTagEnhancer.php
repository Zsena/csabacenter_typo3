<?php
namespace DigitalZombies\Center\Utility\Cache;

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

use DigitalZombies\Center\Configuration\ScopeConfiguration;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;

/**
 * Class CacheTagEnhancer
 * @package DigitalZombies\Center\Utility\Cache
 */
class CacheTagEnhancer
{

    /**
     * Maps the current page to an object if it is possible based on the doktype property

     * @return array the processed data as key/value store
	 * @throws \Exception
     */
    public function addRootPageTag()
    {
		$GLOBALS['TSFE']->addCacheTags(['pageId_' . ScopeConfiguration::getScope()->getPageId()]);
    }
}
