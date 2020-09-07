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
use DigitalZombies\Center\Domain\Model\Center\Center;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Test case for class DigitalZombies\Center\Domain\Model\Center\Center.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CenterTest extends UnitTestCase {
	/**
	 * @var \DigitalZombies\Center\Domain\Model\Center\Center
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = GeneralUtility::makeInstance(Center::class);
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
	public function addressIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getAddress());
	}

	/**
	 * @test
	 */
	public function appStoreLinksInitializedByDefault() {
		$links = $this->subject->getAppStoreLinks();
		$this->assertEquals(ObjectStorage::class, get_class($links));
		unset($links);
	}

	/**
	 * @test
	 */
	public function socialChannelsInitializedByDefault() {
		$channels = $this->subject->getSocialChannels();
		$this->assertEquals(ObjectStorage::class, get_class($channels));
		unset($channels);
	}

	/**
	 * @test
	 */
	public function centerNameIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getCenterName());
	}


	/**
	 * @test
	 */
	public function communicationGroupIsEmptyByDefault() {
		$this->assertEquals(null, $this->subject->getCommunicationGroup());
	}

	/**
	 * @test
	 */
	public function communicationLineIsEmptyByDefault() {
		$this->assertEquals(null, $this->subject->getCommunicationLine());
	}

	/**
	 * @test
	 */
	public function emailIsBlankByDefault() {
		$this->assertEquals(null, $this->subject->getEmail());
	}

	/**
	 * @test
	 */
	public function gaCenterIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getGaCenter());
	}

	/**
	 * @test
	 */
	public function gaEceAccountIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getGaEceAccount());
	}

	/**
	 * @test
	 */
	public function latIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getLat());
	}

	/**
	 * @test
	 */
	public function lngIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getLng());
	}

	/**
	 * @test
	 */
	public function mapZoomIsZeroByDefault() {
		$this->assertEquals(0, $this->subject->getMapZoom());
	}

	/**
	 * @test
	 */
	public function regionIsZeroByDefault() {
		$this->assertEquals(0, $this->subject->getRegion());
	}

	/**
	 * @test
	 */
	public function levelsInitializedByDefault() {
		$levels = $this->subject->getLevels();
		$this->assertEquals(ObjectStorage::class, get_class($levels));
		unset($levels);
	}

	/**
	 * @test
	 */
	public function overrideCoordinatesIsZeroByDefault() {
		$this->assertEquals(0, $this->subject->getOverrideCoordinates());
	}

	/**
	 * @test
	 */
	public function pageIdIsZeroByDefault() {
		$this->assertEquals(0, $this->subject->getPageId());
	}

	/**
	 * @test
	 */
	public function pidIsZeroByDefault() {
		$this->assertEquals(0, $this->subject->getPid());
	}

	/**
	 * @test
	 */
	public function shortNameIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getShortName());
	}

	/**
	 * @test
	 */
	public function titleIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getTitle());
	}

	/**
	 * @test
	 */
	public function titlePostFixIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getTitlePostFix());
	}

	/**
	 * @test
	 */
	public function themeIsEmptyByDefault() {
		$this->assertEquals(null, $this->subject->getTheme());
	}

	/**
	 * @test
	 */
	public function phoneIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getPhone());
	}
}
