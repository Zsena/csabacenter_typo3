<?php

namespace DigitalZombies\Center\PushNotification\Api;

use DigitalZombies\Center\Exception\ApiException;
use DigitalZombies\Center\Exception\ApiNotReachableException;
use DigitalZombies\Center\Exception\InvalidApiUrlException;
use DigitalZombies\Center\PushNotification\Api\Config\AirNotifierApiConfig;
use DigitalZombies\Center\PushNotification\Api\Request\PushServiceRequestInterface;
use DigitalZombies\Center\PushNotification\Api\Response\ApiResponse;

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
 * Class Airnotifier
 * @package DigitalZombies\Center\PushNotification\Api
 */
class AirNotifierApi extends AbstractApi
{
    /**
     * @var AirNotifierApiConfig
     */
    private $config;

    /**
     * AirNotifierApi constructor.
     * @param AirNotifierApiConfig $config
     * @throws ApiNotReachableException
     * @throws InvalidApiUrlException
     */
    public function __construct(AirNotifierApiConfig $config)
    {
        $this->config = $config;

        $url = $this->config->getBaseUrl();
        $this->validateUrl($url);
        $this->checkReachability($url);
    }

    /**
     * @param RequestList $requests
     * @return RequestList The initial List with all results attached to the request objects
     * @throws ApiException
     */
    public function sendPostRequests(RequestList $requests): RequestList
    {
        /** @var  PushServiceRequestInterface $request */
        foreach ($requests as $request) {
            $url = $this->config->getBaseUrl()
                . ((substr($this->config->getBaseUrl(), -1) != "/") ? "/" : "")
                . $request->getEndpointUrl();

            $requestBody = $request->renderBody();
            $requestHeaders = $request->renderHeaders();

            $result = $this->sendPostCurlRequest($url, $requestBody, $requestHeaders);
            $statusCode = $result->getStatusCode();
            if (in_array($statusCode, self::AIR_NOTIFIER_ERROR_STATUS_CODES)) {
                throw new ApiException(
                    $url . " failed." . PHP_EOL .
                    " Status code: " . $statusCode . PHP_EOL .
                    "Error: " . $result->getError() . PHP_EOL .
                    "Result: " . $result->getResultText()
                );
            };
        }
        return $requests;
    }
}