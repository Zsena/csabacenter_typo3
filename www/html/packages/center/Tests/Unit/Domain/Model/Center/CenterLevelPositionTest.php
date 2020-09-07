<?php

namespace DigitalZombies\Center\Tests\Unit\Domain\Model\Center;

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
use DigitalZombies\Center\Domain\Model\Center\CenterLevelPosition;
use DigitalZombies\Center\Domain\Model\Records\Service;
use DigitalZombies\Center\Domain\Model\Shop\Shop;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Test case for class DigitalZombies\Center\Domain\Model\Center\CenterLevelPosition.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CenterLevelPositionTest extends UnitTestCase {
	/**
	 * @var \DigitalZombies\Center\Domain\Model\Center\CenterLevelPosition
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = GeneralUtility::makeInstance(CenterLevelPosition::class);
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function uidIsZeroByDefault() {
		$this->assertEquals(0, $this->subject->getUid());
	}

	/**
	 * @test
	 */
	public function pidIsEmptyByDefault() {
		$this->assertEquals(null, $this->subject->getPid());
	}

	/**
	 * @test
	 */
	public function objectPositionIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getObjectPosition());
	}

	/**
	 * @test
	 */
	public function centerLevelIsEmptyByDefault() {
		$this->assertEquals(null, $this->subject->getCenterLevel());
	}

	/**
	 * @test
	 */
	public function shopIsEmptyByDefault() {
		$this->assertEquals(null, $this->subject->getShop());
	}

	/**
	 * @test
	 */
	public function serviceIsEmptyByDefault() {
		$this->assertEquals(null, $this->subject->getService());
	}

	/**
	 * @test
	 */
	public function centerIsEmptyByDefault() {
		$this->assertEquals(null, $this->subject->getCenter());
	}

	/**
	 * @test
	 */
	public function typeIsEmptyByDefault() {
		$this->assertEquals(null, $this->subject->getType());
	}

	/**
	 * @test
	 */
	public function parentIsEmptyByDefault() {
		$this->assertEquals(null, $this->subject->getParent());
	}

	/**
	 * @test
	 */
	public function parentIsShopIfSet() {
		/** @var \DigitalZombies\Center\Domain\Model\Shop\Shop $shop */
		$shop = GeneralUtility::makeInstance(Shop::class);
		$this->subject->setShop($shop);
		$this->assertEquals($shop, $this->subject->getParent());
		unset($shop);
	}

	/**
	 * @test
	 */
	public function parentIsServiceIfSet() {
		/** @var \DigitalZombies\Center\Domain\Model\Records\Service $service */
		$service = GeneralUtility::makeInstance(Service::class);
		$this->subject->setService($service);
		$this->assertEquals($service, $this->subject->getParent());
		unset($service);
	}

	/**
	 * @test
	 */
	public function xIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getX());
	}

	/**
	 * @test
	 */
	public function yIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getY());
	}

	/**
	 * @test
	 */
	public function pathIdIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getPathId());
	}

	/**
	 * @test
	 */
	public function xIs40IfObjectPositionSet() {
		$this->subject->setObjectPosition('1_100_40:40');
		$this->assertEquals('40', $this->subject->getX());
	}

	/**
	 * @test
	 */
	public function yIs40IfObjectPositionSet() {
		$this->subject->setObjectPosition('1_100_40:40');
		$this->assertEquals('40', $this->subject->getY());
	}

	/**
	 * @test
	 */
	public function pathIdIs1_100IfObjectPositionSet() {
		$this->subject->setObjectPosition('1_100_40:40');
		$this->assertEquals('1_100', $this->subject->getPathID());
	}
}
