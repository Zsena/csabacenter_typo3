<?php

namespace DigitalZombies\Center\PushNotification\Api;

use DigitalZombies\Center\Exception\ApiNotReachableException;
use DigitalZombies\Center\Exception\InvalidApiUrlException;
use DigitalZombies\Center\PushNotification\Api\Response\ApiResponse;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2019- Fabian Gehrlicher <f.gehrlicher@plan-net.com>
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
abstract class AbstractApi implements PushServiceInterface
{
    /**
     * @param string $url
     * @throws ApiNotReachableException
     */
    protected function checkReachability(string $url)
    {
        $result = $this->sendGetCurlRequest($url, []);
        $statusCode = $result->getStatusCode();
        $statusCodeTopLevel = substr($statusCode, 0, 1);
        if (!($statusCodeTopLevel == "2" || $statusCodeTopLevel == "3")) {
            throw new ApiNotReachableException(
                $url . " is not reachable." . PHP_EOL .
                " Status code: " . $statusCode . PHP_EOL .
                "Error: " . $result->getError() . PHP_EOL .
                "Result: " . $result->getResultText()
            );
        };
    }

    /**
     * @param string $url
     * @throws InvalidApiUrlException
     */
    protected function validateUrl(string $url)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new InvalidApiUrlException($url . " is not valid");
        }
    }

    /**
     * @param string $url
     * @param string $requestBody
     * @param array $requestHeaders
     * @return ApiResponse
     */
    protected function sendPostCurlRequest(string $url, string $requestBody, array $requestHeaders): ApiResponse
    {
        return $this->sendCurlRequest($url, 'POST', $requestBody, $requestHeaders);
    }

    /**
     * @param string $url
     * @param array $requestHeaders
     * @return ApiResponse
     */
    protected function sendGetCurlRequest(string $url, array $requestHeaders): ApiResponse
    {
        return $this->sendCurlRequest($url, 'GET', "", $requestHeaders);
    }

    /**
     * @param string $url
     * @param string $httpMethod
     * @param string $requestBody
     * @param array $requestHeaders
     * @return ApiResponse
     */
    protected function sendCurlRequest(string $url, string $httpMethod, string $requestBody, array $requestHeaders): ApiResponse
    {
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, $httpMethod);

        if ($requestHeaders) {
            curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $requestHeaders);
        }

        if ($requestBody) {
            curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $requestBody);
        }

        $resultText = curl_exec($curlHandle);
        $statusCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CODE);
        $error = curl_error($curlHandle);
        $response = new ApiResponse($statusCode, $resultText, $error);

        curl_close($curlHandle);

        return $response;
    }
}