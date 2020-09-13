<?php

namespace DigitalZombies\Center\Utility;

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/***************************************************************
 *  Copyright notice
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


class TeaserBuilder
{
	/**
	 * Calculates a wall based on the number of free places
	 *
	 * @param array $teaserElements
	 * @param int $cols
	 * @param int $rows
	 * @param int $fetchAutomaticContent
	 * @return array
	 */
	public static function buildWall($teaserElements, $cols = 3, $rows = 3, $fetchAutomaticContent = '')
	{
		$wallItems = [];
		$currentRow = 0;
		$currentIndex = 0;

		/** @var \DigitalZombies\Center\Domain\Model\RecordBase $teaserElement */
		foreach ($teaserElements as $teaserElement) {

			$teaserColumns = $teaserElement->getTeaserFormat();
			$remainedPlaces = $cols - $currentIndex;

			if ($teaserColumns > $remainedPlaces || $fetchAutomaticContent == 1) {
				$teaserColumns = 1;
				$teaserElementClone = clone $teaserElement;
				$teaserElementClone->setTeaserFormat($teaserColumns);
				$wallItems[] = $teaserElementClone;
			} else {
				$wallItems[] = $teaserElement;
			}

			$currentIndex += $teaserColumns;

			if ($currentIndex === $cols) {
				$currentIndex = 0;
				$currentRow++;
			}
			if ($currentRow === $rows) {
				break;
			}
		}

		unset($teaserElements);

		return $wallItems;
	}
}
