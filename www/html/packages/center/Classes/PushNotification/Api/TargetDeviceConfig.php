<?php

namespace DigitalZombies\Center\PushNotification\Api;

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
class TargetDeviceConfig
{
    const SINGLE_TOKEN_TYPE = 1;
    const MULTI_TOKEN_TYPE = 2;
    const BROADCAST_TYPE = 3;
    const TYPES = [
        self::SINGLE_TOKEN_TYPE,
        self::MULTI_TOKEN_TYPE,
        self::BROADCAST_TYPE
    ];

    /**
     * @var int
     */
    private $pushType;

    /**
     * @var string
     */
    private $token;

    /**
     * @var array
     */
    private $tokens;

    /**
     * AirNotifierTargetDeviceConfig constructor.
     * @param int $pushType
     * @param string $token
     * @param array $tokens
     * @throws InvalidPushRequestException
     */
    public function __construct(int $pushType, string $token = "", array $tokens = [])
    {
        if (!in_array($pushType, self::TYPES)) {
            throw new InvalidPushRequestException("invalid target Type");
        }
        $this->pushType = $pushType;
        $this->token = $token;
        $this->tokens = $tokens;
    }

    /**
     * @return mixed
     */
    public function getPushType()
    {
        return $this->pushType;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return mixed
     */
    public function getTokens()
    {
        return $this->tokens;
    }
}