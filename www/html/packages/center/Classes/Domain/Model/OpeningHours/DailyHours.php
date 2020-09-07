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
 * DailyHours
 */
class DailyHours extends AbstractEntity
{
	/**
	 * Day of week
	 * @var int
	 */
	protected $dayOfWeek = 0;

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
	 * Closed
	 * @var int
	 */
	protected $closed = 0;

	/**
	 * Open from extended
	 * @var int
	 */
	protected $fromExt = 0;

	/**
	 * Open till extended
	 * @var int
	 */
	protected $tillExt = 0;


	/**
	 * @var int
	 */
	protected $parent = 0;

	/**
	 * @var string
	 */
	protected $parentTable = '';

	/**
	 * @return int
	 */
	public function getDayOfWeek(): int
	{
		return $this->dayOfWeek;
	}

	/**
	 * @param int $dayOfWeek
	 */
	public function setDayOfWeek(int $dayOfWeek)
	{
		$this->dayOfWeek = $dayOfWeek;
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
	 * @return int
	 */
	public function getClosed(): int
	{
		return $this->closed;
	}

	/**
	 * @param int $closed
	 */
	public function setClosed(int $closed)
	{
		$this->closed = $closed;
	}

	/**
	 * @return int
	 */
	public function getFromExt(): int
	{
		return $this->fromExt;
	}

	/**
	 * @param int $fromExt
	 */
	public function setFromExt(int $fromExt)
	{
		$this->fromExt = $fromExt;
	}

	/**
	 * @return int
	 */
	public function getTillExt(): int
	{
		return $this->tillExt;
	}

	/**
	 * @param int $tillExt
	 */
	public function setTillExt(int $tillExt)
	{
		$this->tillExt = $tillExt;
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
