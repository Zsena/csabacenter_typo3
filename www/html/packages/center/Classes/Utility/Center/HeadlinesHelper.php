<?php
namespace DigitalZombies\Center\Utility;

use DigitalZombies\Center\Domain\Model\Center\Center;
use DigitalZombies\Center\Domain\Repository\Misc\HeadlinesRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;

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


class HeadlinesHelper
{

	/**
	 * Returns the directions to the current center in scope
	 *
	 * @param Center $center
	 * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public static function getHeadlines($center) {
		$headlines = [];
		/** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
		$objectManager = GeneralUtility::makeInstance(ObjectManager::class);

		if ($center) {
			/** @var \DigitalZombies\Center\Domain\Repository\Misc\HeadlinesRepository $headlinesRepository */
			$headlinesRepository = $objectManager->get(HeadlinesRepository::class);

			$headlines = $headlinesRepository->findByCenter($center->getUid());
		}

		return $headlines;
	}
}


?>