<?php
namespace DigitalZombies\Center\Domain\Model\Misc;

use DigitalZombies\Center\Domain\Model\Center\Center;
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
 * Direction
 */
class Direction extends AbstractEntity
{
	/**
	 * name
	 *
	 * @var string
	 */
	protected $title = '';

	/**
	 * page
	 *
	 * @var int
	 */
	protected $page = 0;

	/**
	 * function
	 *
	 * @var string
	 */
	protected $function = 0;

	/**
	 * function
	 *
	 * @var \DigitalZombies\Center\Domain\Model\Center\Center
	 */
	protected $center = null;

	/**
	 * icon
	 *
	 * @var string
	 */
	protected $icon = '';

	/**
	 * buttonText
	 *
	 * @var string
	 */
	protected $buttonText = '';

	/**
	 * buttonText
	 *
	 * @var string
	 */
	protected $lat;

	/**
	 * buttonText
	 *
	 * @var string
	 */
	protected $long;

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
	 * @return int
	 */
	public function getPage(): int
	{
		return $this->page;
	}

	/**
	 * @param int $page
	 */
	public function setPage(int $page)
	{
		$this->page = $page;
	}

	/**
	 * @return string
	 */
	public function getFunction(): string
	{
		return $this->function;
	}

	/**
	 * @param string $function
	 */
	public function setFunction(string $function)
	{
		$this->function = $function;
	}

	/**
	 * @return Center
	 */
	public function getCenter(): Center
	{
		return $this->center;
	}

	/**
	 * @param Center $center
	 */
	public function setCenter(Center $center)
	{
		$this->center = $center;
	}

	/**
	 * @return string
	 */
	public function getIcon(): string
	{
		return $this->icon;
	}

	/**
	 * @param string $icon
	 */
	public function setIcon(string $icon)
	{
		$this->icon = $icon;
	}

	/**
	 * @return string
	 */
	public function getButtonText(): string
	{
		return $this->buttonText;
	}

	/**
	 * @param string $buttonText
	 */
	public function setButtonText(string $buttonText)
	{
		$this->buttonText = $buttonText;
	}

	/**
	 * @return string
	 */
	public function getLat()
	{
		return $this->lat;
	}

	/**
	 * @param string $lat
	 */
	public function setLat($lat)
	{
		$this->lat = $lat;
	}

	/**
	 * @return string
	 */
	public function getLong()
	{
		return $this->long;
	}

	/**
	 * @param string $long
	 */
	public function setLong($long)
	{
		$this->long = $long;
	}

}
