<?php

namespace DigitalZombies\Center\PushNotification\Api;

use DigitalZombies\Center\Exception\ApiException;
use DigitalZombies\Center\PushNotification\Api\Config\FirebaseApiConfig;
use DigitalZombies\Center\PushNotification\Api\Request\PushServiceRequestInterface;

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
class FirebaseApi extends AbstractApi
{
	const ERROR_STATUS_CODES = [400, 401, 405, 404];
	//404 and 405 added because FCM does not accept post anymore
	//This is why checkReachability is not called anymore

	/**
	 * @var FirebaseApiConfig
	 */
	private $config;

	/**
	 * FirebaseApi constructor.
	 * @param FirebaseApiConfig $config
	 * @throws \DigitalZombies\Center\Exception\ApiNotReachableException
	 * @throws \DigitalZombies\Center\Exception\InvalidApiUrlException
	 */
	public function __construct(FirebaseApiConfig $config)
	{
		$this->config = $config;

		$url = $this->config->getBaseUrl();
		$this->validateUrl($url);
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
			$result = $this->sendPostCurlRequest(
				$this->config->getBaseUrl(),
				$request->renderBody(),
				$request->renderHeaders()
			);
			$statusCode = $result->getStatusCode();
			if (in_array($statusCode, self::ERROR_STATUS_CODES) ||
				substr($statusCode, 0, 1) == "5") {
				throw new ApiException(
					$this->config->getBaseUrl() . " failed." . PHP_EOL .
					" Status code: " . $statusCode . PHP_EOL .
					"Error: " . $result->getError() . PHP_EOL .
					"Result: " . $result->getResultText()
				);
			};
		}
		return $requests;
	}
}
