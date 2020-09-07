<?php

namespace DigitalZombies\Center\PushNotification\Api\Config;

use TYPO3\CMS\Core\Exception;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2018- Fabian Gehrlicher <f.gehrlicher@plan-net.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
class AirNotifierAppConfig implements AppConfigInterface
{
    /**
     * @var string
     */
    private $appName;

    /**
     * @var string
     */
    private $appKey;

    /**
     * AirNotifierAppConfig constructor.
     * @param string $appName
     * @param string $appKey
     * @throws Exception
     */
    public function __construct(string $appName, string $appKey)
    {
        if ($appName == "" || $appKey == "") {
            throw new Exception("app key missing");
        }
        $this->appName = $appName;
        $this->appKey = $appKey;
    }

    /**
     * @return string
     */
    public function getTopic(): string
    {
        return $this->appName;
    }

    /**
     * @return string
     */
    public function getAppKey(): string
    {
        return $this->appKey;
    }
}
