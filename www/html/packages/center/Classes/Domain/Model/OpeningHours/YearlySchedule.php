<?php
namespace DigitalZombies\Center\Domain\Model\OpeningHours;

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
 * YearlySchedule
 */
class YearlySchedule extends AbstractEntity
{
	/**
	 * days
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\OpeningHours\Holiday>
	 */
	protected $holidays = null;

	/**
	 * days
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\OpeningHours\SpecialClosingDay>
	 */
	protected $specialClosingDays = null;

	/**
	 * @var int
	 */
	protected $parent = 0;

	/**
	 * @var string
	 */
	protected $parentTable = '';

	/**
	 * year
	 *
	 * @var integer
	 */
	protected $year = 2016;

	/**
	 * WeeklySchedule constructor.
	 */
	public function __construct() {
		$this->holidays = new ObjectStorage();
		$this->specialClosingDays = new ObjectStorage();
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getHolidays()
	{
		return $this->holidays;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $holidays
	 */
	public function setHolidays(ObjectStorage $holidays)
	{
		$this->holidays = $holidays;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getSpecialClosingDays()
	{
		return $this->specialClosingDays;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $specialClosingDays
	 */
	public function setSpecialClosingDays(ObjectStorage $specialClosingDays)
	{
		$this->specialClosingDays = $specialClosingDays;
	}

	/**
	 * @return int
	 */
	public function getYear(): int
	{
		return $this->year;
	}

	/**
	 * @param int $year
	 */
	public function setYear(int $year)
	{
		$this->year = $year;
	}

	/**
	 * @return int
	 */
	public function getParent(): int
	{
		return $this->parent;
	}

	/**
	 * @param int $parent
	 */
	public function setParent(int $parent)
	{
		$this->parent = $parent;
	}

	/**
	 * @return string
	 */
	public function getParentTable(): string
	{
		return $this->parentTable;
	}

	/**
	 * @param string $parentTable
	 */
	public function setParentTable(string $parentTable)
	{
		$this->parentTable = $parentTable;
	}
}
