<?php
namespace DigitalZombies\Center\Domain\Model\OpeningHours;

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
 * Holiday
 */
class Holiday extends AbstractEntity
{
	/**
	 * Name
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * Closing day
	 *
	 * @var integer
	 */
	protected $closingDay = 0;

	/**
	 * Country
	 *
	 * @var \DigitalZombies\Center\Domain\Model\Misc\Country
	 */
	protected $country = null;

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName(string $name)
	{
		$this->name = $name;
	}

	/**
	 * @return int
	 */
	public function getClosingDay(): int
	{
		return $this->closingDay;
	}

	/**
	 * @param int $closingDay
	 */
	public function setClosingDay(int $closingDay)
	{
		$this->closingDay = $closingDay;
	}

	/**
	 * @return \DigitalZombies\Center\Domain\Model\Misc\Country
	 */
	public function getCountry()
	{
		return $this->country;
	}

	/**
	 * @param \DigitalZombies\Center\Domain\Model\Misc\Country $country
	 */
	public function setCountry($country)
	{
		$this->country = $country;
	}

}
