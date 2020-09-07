<?php

namespace DigitalZombies\Center\Tests\Unit\Domain\Model\Shop;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017
 *
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

use DigitalZombies\Center\Domain\Model\Shop\ChainStore;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Test case for class DigitalZombies\Center\Domain\Model\Shop\Shop.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ChainStoreTest extends UnitTestCase {
	/**
	 * @var \DigitalZombies\Center\Domain\Model\Shop\ChainStore
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = GeneralUtility::makeInstance(ChainStore::class);
	}

	protected function tearDown() {
		unset($this->subject);
	}


	/**
	 * @test
	 */
	public function descriptionIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getDescription());
	}

	/**
	 * @test
	 */
	public function nameIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getName());
	}

	/**
	 * @test
	 */
	public function metaTitleIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getMetaTitle());
	}

	/**
	 * @test
	 */
	public function metaDescriptionIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getMetaDescription());
	}

	/**
	 * @test
	 */
	public function logoIsEmptyByDefault() {
		$this->assertEquals(null, $this->subject->getLogo());
	}
}
