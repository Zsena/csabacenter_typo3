<?php
namespace DigitalZombies\Center\Domain\Model\Interest;

use DigitalZombies\Center\Domain\Model\Center\Center;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 *
 * This file is part of the "center" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 András Ottó <andras.otto@plan-net.com>, Plan.Net Pulse
 *
 */



/**
 * InterestList
 */
class InterestList extends AbstractEntity
{
	/**
	 * title
	 *
	 * @var string
	 */
	protected $title = null;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\Interest\InterestLabel>
	 */
	protected $interests = null;

	/**
	 * @return string
	 */
	public function getTitle(): string
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 */
	public function setTitle(string $title)
	{
		$this->title = $title;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getInterests()
	{
		return $this->interests;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $interests
	 */
	public function setInterests(ObjectStorage $interests)
	{
		$this->interests = $interests;
	}
}
