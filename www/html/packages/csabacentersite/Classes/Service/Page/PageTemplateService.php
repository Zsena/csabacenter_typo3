<?php
namespace DigitalZombies\Csabacentersite\Service\Page;

use DigitalZombies\Center\Domain\Model\Records\Service;
use DigitalZombies\Center\Domain\Model\Shop\Gastro;
use DigitalZombies\Center\Domain\Model\Shop\Shop;
use TYPO3\CMS\Core\SingletonInterface;

/***************************************************************
 *  Copyright notice
 *
 * 	Based on:
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


class PageTemplateService implements SingletonInterface {

	/**
	 * Extend the cache_tags field in the page record to handle different center scopes
	 *
	 * @param array $fieldArray
	 */
	public static function setDefaultTemplate( array &$fieldArray) {
		if(isset($fieldArray['doktype'])) {
			switch ($fieldArray['doktype']) {
				case Shop::DOKTYPE:
				case Gastro::DOKTYPE:
					$fieldArray['backend_layout'] = 'pagets__shopDetailPage';
					break;
				case Shop::LIST_DOKTYPE:
					$fieldArray['backend_layout'] = 'pagets__shopListPage';
					break;
				case Service::LIST_DOKTYPE:
					$fieldArray['backend_layout'] = 'pagets__serviceListPage';
					break;
			}
		}
	}
}

?>