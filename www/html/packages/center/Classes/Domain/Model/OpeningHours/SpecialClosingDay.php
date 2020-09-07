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
 * SpecialClosingDay
 */
class SpecialClosingDay extends AbstractEntity
{
	/**
	 * name
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * endtime
	 *
	 * @var integer
	 */
	protected $closingDay = 0;

	/**
	 * Yearly schedule
	 *
	 * @var \DigitalZombies\Center\Domain\Model\OpeningHours\YearlySchedule
	 */
	protected $schedule = null;

	/**
	 * Open from
	 * @var int
	 */
	protected $from = 0;

	/**
	 * Open till
	 * @var int
	 */
	protected $till = 0;

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
	 * @return \DigitalZombies\Center\Domain\Model\OpeningHours\YearlySchedule
	 */
	public function getSchedule()
	{
		return $this->schedule;
	}

	/**
	 * @param \DigitalZombies\Center\Domain\Model\OpeningHours\YearlySchedule $schedule
	 */
	public function setSchedule($schedule)
	{
		$this->schedule = $schedule;
	}

	/**
	 * @return int
	 */
	public function getFrom(): int
	{
		return $this->from;
	}

	/**
	 * @param int $from
	 */
	public function setFrom(int $from)
	{
		$this->from = $from;
	}

	/**
	 * @return int
	 */
	public function getTill(): int
	{
		return $this->till;
	}

	/**
	 * @param int $till
	 */
	public function setTill(int $till)
	{
		$this->till = $till;
	}

	/**
	 *  Returns if a from or till time set or not
	 */
	public function hasHoursSet() {
		return $this->getFrom() > 0 || $this->getTill() > 0;
	}
}
