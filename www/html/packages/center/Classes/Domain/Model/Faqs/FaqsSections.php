<?php

namespace DigitalZombies\Center\Domain\Model\Faqs;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

use DigitalZombies\Center\Domain\Model\Center\Center;

/**
 *
 * This file is part of the "center" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2018
 *
 */

/**
 * Faq's Sections
 */
class FaqsSections extends AbstractEntity
{
	/**
	 * function
	 *
	 * @var \DigitalZombies\Center\Domain\Model\Center\Center
	 */
	protected $centerId = null;

	/**
	 * Section Name
	 *
	 * @var string
	 */
	protected $sectionName = '';

	/**
	 * @return Center
	 */
	public function getCenterId(): Center
	{
		return $this->centerId;
	}

	/**
	 * @param Center $center
	 */
	public function setCenterId(Center $centerId)
	{
		$this->centerId = $centerId;
	}

	/**
	 * @return string
	 */
	public function getSectionName()
	{
		return $this->sectionName;
	}

	/**
	 * @param string $sectionName
	 */
	public function setSectionName($sectionName)
	{
		$this->sectionName = $sectionName;
	}
}
