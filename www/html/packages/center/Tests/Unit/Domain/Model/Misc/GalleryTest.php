<?php

namespace DigitalZombies\Center\Tests\Unit\Domain\Model\Misc;

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

use DigitalZombies\Center\Domain\Model\Misc\Gallery;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Test case for class DigitalZombies\Center\Domain\Model\Records\Job.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class GalleryTest extends UnitTestCase {
	/**
	 * @var \DigitalZombies\Center\Domain\Model\Misc\Gallery
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = GeneralUtility::makeInstance(Gallery::class);
	}

	protected function tearDown() {
		unset($this->subject);
	}


	/**
	 * center
	 *
	 * @var \DigitalZombies\Center\Domain\Model\Center\Center
	 */
	protected $center = null;

	/**
	 * images
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
	 */
	protected $images = null;

	/**
	 * @test
	 */
	public function nameIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getName());
	}

	/**
	 * @test
	 */
	public function endtimeIsZeroByDefault() {
		$this->assertEquals(0, $this->subject->getEndtime());
	}

	/**
	/**
	 * @test
	 */
	public function centerIsEmptyByDefault() {
		$this->assertEquals(null, $this->subject->getCenter());
	}

	/**
	 * @test
	 */
	public function imagesInitializedByDefault() {
		$images = $this->subject->getImages();
		$this->assertEquals(ObjectStorage::class, get_class($images));
		unset($images);
	}


}
