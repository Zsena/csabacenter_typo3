<?php
namespace DigitalZombies\Center\Domain\Model\Interest;

use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

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
 * InterestLabel
 */
class InterestLabel extends AbstractEntity
{
	/**
	 * label
	 *
	 * @var string
	 */
	protected $label = '';

	/** @var \DigitalZombies\Center\Domain\Model\Interest\Interest */
	protected $interest = null;

	/**
	 * @return string
	 */
	public function getLabel(): string
	{
		return $this->label;
	}

	/**
	 * @param string $label
	 */
	public function setLabel(string $label)
	{
		$this->label = $label;
	}

	/**
	 * @return Interest
	 */
	public function getInterest()
	{
		return $this->interest;
	}

	/**
	 * @param Interest $interest
	 */
	public function setInterest($interest)
	{
		$this->interest = $interest;
	}
}
