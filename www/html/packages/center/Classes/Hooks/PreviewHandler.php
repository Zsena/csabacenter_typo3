<?php

namespace DigitalZombies\Center\Hooks;

use DigitalZombies\Center\Exception\UnusableHostNameException;
use DigitalZombies\Center\Utility\PreviewItemFactory;
use DigitalZombies\Center\Utility\PreviewRequest;
use DigitalZombies\Center\Utility\RootPidResolver;
use DigitalZombies\Center\Utility\TsfeHelper;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

/***************************************************************
 *  Copyright notice
 *
 *    Based on:
 *
 *  (c) 2018 Fabian Gehrlicher <f.gehrlicher@plan-net.com>
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

/**
 * Class PreviewHandler
 * @package DigitalZombies\Center\Hooks
 */
class PreviewHandler
{

    const GLOBAL_ROOT_PID = 985;
    const PREVIEW_PATH_SEGMENT = 'preview';

    /**
     * @param $previewUrl
     * @param $pageUid
     * @param $rootLine
     * @param $anchorSection
     * @param $viewScript
     * @param $additionalGetVars
     * @param $switchFocus
     * @return string
     */
    public function postProcess(
        $previewUrl,
        $pageUid,
        $rootLine,
        $anchorSection,
        $viewScript,
        $additionalGetVars,
        $switchFocus
    )
    {
        return $this->isPreviewRequest($previewUrl) ? $this->replacePidWithPathSegement($previewUrl) : $previewUrl;
    }

    /**
     * @param string $previewUrl
     * @return bool
     */
    private function isPreviewRequest(string $previewUrl): bool
    {
        return boolval(preg_match('/' . PreviewRequest::PREVIEW_KEY . '/', $previewUrl));
    }

    /**
     * @param string $previewUrl
     * @return string
     */
    private function replacePidWithPathSegement(string $previewUrl): string
    {
        $previewUrl = str_replace("index.php?", '', $previewUrl);
        $previewUrl = preg_replace('/(id=[0-9]*.)/', self::PREVIEW_PATH_SEGMENT . "/?", $previewUrl);
        return $previewUrl;
    }
}