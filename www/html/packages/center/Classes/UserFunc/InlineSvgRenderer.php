<?php

namespace DigitalZombies\Center\UserFunc;

use DigitalZombies\Center\Utility\SvgReader;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 David Miltz <D.Miltz@plan-net.com>
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
class InlineSvgRenderer
{

	/**
	 * Renders an svg from a file
	 *
	 * @param string $content
	 * @param array $conf
	 * @return string
	 */
    public function renderFromFile($content, $conf)
    {
    	$svgData = '';
    	if(isset($conf['fileName'])) {

    		$path = GeneralUtility::getFileAbsFileName($conf['fileName']);
    		if(file_exists($path)) {
				$svgData = SvgReader::readSVGFile($path);

				if (!is_null($conf['class'])) {
					if (strpos($svgData, 'class="') === false) {
						$svgData = preg_replace(
							'/<svg/',
							'<svg class="' . htmlspecialchars($conf['class']) . '"',
							$svgData
						);
					}
				}

				if (!is_null($conf['ariaHidden'])) {
					if (strpos($svgData, 'aria-hidden="') === false) {
						$svgData = preg_replace(
							'/<svg/',
							'<svg aria-hidden="' . htmlspecialchars($conf['ariaHidden']) . '"',
							$svgData
						);
					}
				}
			}
			$svgData = SvgReader::cleanSVGCode($svgData);

		}
    	
		return $svgData;
    }

}