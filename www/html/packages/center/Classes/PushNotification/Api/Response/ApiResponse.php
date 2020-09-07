<?php

namespace DigitalZombies\Center\PushNotification\Api\Response;

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

/**
 * Class AirNotifierResponse
 * @package DigitalZombies\Center\PushNotification\Api\Response
 */
class ApiResponse
{
    /**
     * @var int
     */
    private $statusCode;

    /**
     * @var string
     */
    private $resultText;

    /**
     * @var string
     */
    private $error;

    /**
     * AirnotifierResponse constructor.
     * @param int $statusCode
     * @param string $resultText
     * @param string $error
     */
    public function __construct(int $statusCode, string $resultText, string $error)
    {
        $this->statusCode = $statusCode;
        $this->resultText = $resultText;
        $this->error = $error;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getResultText(): string
    {
        return $this->resultText;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }
}