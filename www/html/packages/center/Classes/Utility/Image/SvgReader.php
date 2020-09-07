<?php
namespace DigitalZombies\Center\Utility;

use TYPO3\CMS\Core\Resource\FileReference;

/***************************************************************
 *  Copyright notice
 *
 *    Based on:
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


class SvgReader
{

	/**
	 * Reads an SVG as text
	 *
	 * @param FileReference $image
	 * @return bool|string
	 */
	public static function readSVGFromFAL($image) {
		$svgData = '';
		if($image) {
			$imageUri = str_replace('//', '/', PATH_site . $image->getStorage()->getConfiguration()['basePath'] . $image->getIdentifier());
			$fileHandle = fopen($imageUri, "r");
			$svgData = fread($fileHandle, filesize($imageUri));
			fclose($fileHandle);
		}
		return $svgData;
	}

	/**
	 * Reads an SVG as text
	 *
	 * @param string $filePath
	 * @return bool|string
	 */
	public static function readSVGFile($filePath) {
		$svgData = '';
		if($filePath && file_exists($filePath)) {
			$fileHandle = fopen($filePath, "r");
			$svgData = fread($fileHandle, filesize($filePath));
			fclose($fileHandle);
		}
		return $svgData;
	}

	/**
	 * Clean unnecessary markup in SVG data
	 *
	 * @param string $svgData
	 * @return string
	 */
	public static function cleanSVGCode($svgData) {

		//Illustrator cleaning. Source: https://halfelf.org/2017/cleaning-up-svgs/
		$svgData = preg_replace(
			'/(.*?)(<svg )/is',
			'$2',
			$svgData
		);

		$svgData = preg_replace(
			'/(id=".*?")/is',
			'',
			$svgData
		);

		$svgData = preg_replace(
			'/<\!DOCTYPE svg PUBLIC ".*?">/',
			'',
			$svgData
		);

		$svgData = preg_replace(
			'/xmlns:(x|i|graph)=".*?"/is',
			'',
			$svgData
		);

		$svgData = preg_replace(
			'/<foreignObject(.*)\/foreignObject>/is',
			'',
			$svgData
		);

		$svgData = preg_replace(
			'/<i:pgf (.*)\/i:pgf>/is',
			'',
			$svgData
		);

		$svgData = preg_replace(
			'/i:extraneous="self"/is',
			'',
			$svgData
		);


		return $svgData;
	}
}


?>