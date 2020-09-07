<?php
namespace DigitalZombies\Center\Service;

use Esolut\Esolutdev\Utility\DebuggerUtility;
use DigitalZombies\Center\Helper\TemplateHelper;
use DigitalZombies\Center\Helper\TokenHelper;

/***************************************************************
 *  Copyright notice
 *
 * 	Based on:
 *
 *  (c) 2017 András Ottó <andras.otto@plan-net.com>
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


class ProductAPIService implements \TYPO3\CMS\Core\SingletonInterface {

    /**
     * @param $endPointUrl
     * @param string $templateName
     * @param string $templatePath
     * @param string $partialPath
     * @param array $variables
     * @param string $keyword
     * @param bool $renderTemplate
     * @return array
     */
	public static function sendRequest($endPointUrl,
                                       $templateName = 'Product/ListTeasers',
                                       $templatePath = 'EXT:center/Resources/Private/Templates',
                                       $partialPath = 'EXT:center/Resources/Private/Partials',
                                       $variables = [],
                                       $keyword = 'products',
                                       $renderTemplate = true) {
        $ch = curl_init($endPointUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $shopResponse = curl_exec($ch);
        $jsonResponse = [];
        if ($shopResponse) {
            $shopResponseArray = json_decode($shopResponse, true);
            if (isset($shopResponseArray[$keyword])) {
                $hasElements = count($shopResponseArray[$keyword]) > 0;
                if($hasElements) {

                    $results = $shopResponseArray[$keyword];
                    $numResults = isset($shopResponseArray['search']['resultCount']) ?
                        $shopResponseArray['search']['resultCount'] : count($shopResponseArray[$keyword]);

                    if($renderTemplate) {
                        $variables[$keyword] = $results;
                        $variables['numResults'] = $numResults;

                        $content = TemplateHelper::generateTemplate($variables,
                            $templateName,
                            $templatePath,
                            $partialPath);

                        $jsonResponse['content'] = $content;
                    }

                    $jsonResponse['status'] = 1;
                    $jsonResponse[$keyword] = $results;
                    $jsonResponse['numResults'] = $numResults;

                }
                else {
                    $jsonResponse['errorMessage'] = 'No products found';
                    $jsonResponse['status'] = 0;
                }
            }
            else {
                $jsonResponse['errorMessage'] = 'Response structure is not correct';
                $jsonResponse['status'] = 0;
            }
        }

        return $jsonResponse;
	}
}