<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2009-2015 Ingo Renner <ingo@typo3.org>
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

use TYPO3\CMS\Core\Utility\GeneralUtility;
use DigitalZombies\Center\Helper\TokenHelper;
use DigitalZombies\Center\Helper\TemplateHelper;


$jsonResponse = [];
try {

	$token = GeneralUtility::_GET('token');
	if ($token) {
		$endPointUrl = TokenHelper::decodeToken($token);
		if (filter_var($endPointUrl, FILTER_VALIDATE_URL) === false) {
			$jsonResponse['errorMessage'] = 'Token is invalid';
			$jsonResponse['status'] = 0;
		} else {
            $jsonResponse = \DigitalZombies\Center\Service\ProductAPIService::sendRequest($endPointUrl);
		}
	} else {
		$jsonResponse['errorMessage'] = 'Missing token';
		$jsonResponse['status'] = 0;
	}
}
catch (\Exception $e) {
	$jsonResponse['errorMessage'] = 'Exception occurred';
	$jsonResponse['status'] = 0;
}
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
header('Content-Type: application/json; charset=utf-8');
header('Content-Transfer-Encoding: 8bit');
echo json_encode($jsonResponse);
