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
use DigitalZombies\Center\Domain\Model\RecordBase;
use TYPO3\CMS\Core\Tests\UnitTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;
/**
 * Test case for class DigitalZombies\Center\Domain\Model\RecordBase.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class RecordBaseTest extends UnitTestCase {
	/**
	 * @var \DigitalZombies\Center\Domain\Model\RecordBase
	 */
	protected $subject = NULL;

	protected function setUp() {
		$this->subject = GeneralUtility::makeInstance(RecordBase::class);
	}

	protected function tearDown() {
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function typeIsZeroByDefault() {
		$this->assertEquals(0, $this->subject->getUid());
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
	public function descriptionIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getDescription());
	}
	
	/**
	 * @test
	 */
	public function ogImageIsEmptyByDefault() {
		$this->assertEquals(null, $this->subject->getOgImage());
	}

	/**
	 * @test
	 */
	public function ogTitleIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getOgTitle());
	}

	/**
	 * @test
	 */
	public function ogDescriptionIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getOgDescription());
	}

	/**
	 * @test
	 */
	public function teaserImageIsEmptyByDefault() {
		$this->assertEquals(null, $this->subject->getTeaserImage());
	}

	/**
	 * @test
	 */
	public function teaserFormatIsEmptyByDefault() {
		$this->assertEquals(null, $this->subject->getTeaserFormat());
	}

	/**
	 * @test
	 */
	public function teaserAbstractIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getTeaserAbstract());
	}

	/**
	 * @test
	 */
	public function contentAbstractIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getContentAbstract());
	}

	/**
	 * @test
	 */
	public function contentTextIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getContentText());
	}

	/**
	 * @test
	 */
	public function contentHeadlineIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getContentHeadline());
	}

	/**
	 * @test
	 */
	public function contentDownloadfileIsEmptyByDefault() {
		$this->assertEquals(null, $this->subject->getContentDownloadfile());
	}

	/**
	 * @test
	 */
	public function contentDownloadfiletextIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getContentDownloadfiletext());
	}

	/**
	 * @test
	 */
	public function contentDownloadlinkIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getContentDownloadlink());
	}

	/**
	 * @test
	 */
	public function contentDownloadlinktextIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getContentDownloadlinkttext());
	}

	/**
	 * @test
	 */
	public function contentEpilogueIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getContentEpilogue());
	}

	/**
	 * @test
	 */
	public function contentPrologueIsBlankByDefault() {
		$this->assertEquals('', $this->subject->getContentPrologue());
	}

	/**
	 * @test
	 */
	public function contentStageimageIsEmptyByDefault() {
		$this->assertEquals(null, $this->subject->getContentStageimage());
	}

	/**
	 * @test
	 */
	public function contentImageIsBlankByDefault() {
		$this->assertEquals(null, $this->subject->getContentImage());
	}

	/**
	 * @test
	 */
	public function contentVideoIsBlankByDefault() {
		$this->assertEquals(null, $this->subject->getContentVideo());
	}
	
	/**
	 * @test
	 */
	public function galleryIsEmptyByDefault() {
		$this->assertEquals(null, $this->subject->getGallery());
	}

}
