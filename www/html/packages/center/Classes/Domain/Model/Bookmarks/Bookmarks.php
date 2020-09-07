<?php

namespace DigitalZombies\Center\Domain\Model\Bookmarks;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

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
 * Bookmarks
 */
class Bookmarks extends AbstractEntity
{
	/**
	 * User Id
	 *
	 * @var integer
	 */
	protected $userId = '';

	/**
	 * Center Id
	 *
	 * @var integer
	 */
	protected $centerId = '';

	/**
	 * Item Id
	 *
	 * @var integer
	 */
	protected $itemId = '';

	/**
	 * Table Name
	 *
	 * @var string
	 */
	protected $tablename = '';

	/**
	 * timestamp of Bookmark
	 *
	 * @var int
	 */
	protected $bookmarkDate = '';

	/**
	 * @return int
	 */
	public function getUserId()
	{
		return $this->userId;
	}

	/**
	 * @param int $userId
	 */
	public function setUserId($userId)
	{
		$this->userId = $userId;
	}

	/**
	 * @return int
	 */
	public function getCenterId()
	{
		return $this->centerId;
	}

	/**
	 * @param int $centerId
	 */
	public function setCenterId($centerId)
	{
		$this->centerId = $centerId;
	}

	/**
	 * @return int
	 */
	public function getItemId()
	{
		return $this->itemId;
	}

	/**
	 * @param int $itemId
	 */
	public function setItemId($itemId)
	{
		$this->itemId = $itemId;
	}

	/**
	 * @return string
	 */
	public function getTablename()
	{
		return $this->tablename;
	}

	/**
	 * @param string $tablename
	 */
	public function setTablename($tablename)
	{
		$this->tablename = $tablename;
	}

	/**
	 * @return int
	 */
	public function getBookmarkDate()
	{
		return $this->bookmarkDate;
	}

	/**
	 * @param int $bookmarkDate
	 */
	public function setBookmarkDate($bookmarkDate)
	{
		$this->bookmarkDate = $bookmarkDate;
	}
}
