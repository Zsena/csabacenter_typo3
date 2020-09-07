<?php
namespace DigitalZombies\Center\Domain\Model\Center;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;

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
 * CenterLevelPosition
 */
class CenterLevelPosition extends AbstractEntity
{

	/**
	 * An important property.
	 * It holds three information for mapplic.
	 * FOrmat is <image_uid>_<path_id_in_svg>_<x>:<y>
	 *
	 * Path id is <image_uid>_<path_id_in_svg>. This is unique and has to be unique for the center,
	 * because we can switch between levels. The uid of the image is the identifier for the level
	 *
	 * Coordinates: <x>:<y> are used to move the focus to the building. In BE the wizard tracks the click position of
	 * the editor and saves this information into the object position as well.
	 *
	 * @var string
	 */
	protected $objectPosition = "";

	/**
	 * @var \DigitalZombies\Center\Domain\Model\Center\CenterLevel
	 */
	protected $centerLevel = null;

	/**
	 * @var int
	 */
	protected $type = 0;

	/**
	 * @var int
	 */
	protected $center = 0;

	/**
	 * @var \DigitalZombies\Center\Domain\Model\Shop\Shop
	 * @lazy
	 */
	protected $shop = null;

	/**
	 * @var \DigitalZombies\Center\Domain\Model\Records\Service
	 * @lazy
	 */
	protected $service = null;

	/**
	 * @return string
	 */
	public function getObjectPosition()
	{
		return $this->objectPosition;
	}

	/**
	 * @param string $objectPosition
	 */
	public function setObjectPosition($objectPosition)
	{
		$this->objectPosition = $objectPosition;
	}

	/**
	 * @return CenterLevel
	 */
	public function getCenterLevel()
	{
		return $this->centerLevel;
	}

	/**
	 * @param CenterLevel $centerLevel
	 */
	public function setCenterLevel($centerLevel)
	{
		$this->centerLevel = $centerLevel;
	}

	/**
	 * @return int
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param int $type
	 */
	public function setType($type)
	{
		$this->type = $type;
	}

	/**
	 * @return int
	 */
	public function getCenter()
	{
		return $this->center;
	}

	/**
	 * @param int $center
	 */
	public function setCenter($center)
	{
		$this->center = $center;
	}

	/**
	 * @return \DigitalZombies\Center\Domain\Model\Shop\Shop
	 */
	public function getShop()
	{
		if ($this->shop instanceof LazyLoadingProxy) {
			$this->shop->_loadRealInstance();
		}
		return $this->shop;
	}

	/**
	 * @param \DigitalZombies\Center\Domain\Model\Shop\Shop $shop
	 */
	public function setShop($shop)
	{
		$this->shop = $shop;
	}

	/**
	 * @return \DigitalZombies\Center\Domain\Model\Records\Service
	 */
	public function getService()
	{
		if ($this->service instanceof LazyLoadingProxy) {
			$this->service->_loadRealInstance();
		}
		return $this->service;
	}

	/**
	 * @param \DigitalZombies\Center\Domain\Model\Records\Service $service
	 */
	public function setService($service)
	{
		$this->service = $service;
	}

	/**
	 * @return \DigitalZombies\Center\Domain\Model\PositionableInterface
	 */
	public function getParent() {
		$parent = $this->getService();
		if(!$parent) {
			$parent = $this->getShop();
		}
		return $parent;
	}

	/**
	 * Extracts the first part of the object position
	 *
	 * @return string
	 */
	public function getPathID() {
		return preg_replace('/(^p?[0-9]*[-_][0-9]*)[-_].*/', '$1', $this->getObjectPosition());
	}

	/**
	 * Extracts the second part of the object position
	 *
	 * @return string
	 */
	public function getX() {
		return preg_replace('/^p?[0-9]*[-_][0-9]*[-_]([\.0-9]{1,6}):([\.0-9]{1,6})/', '$1', $this->getObjectPosition());
	}

	/**
	 * Extracts the third part of the object position
	 *
	 * @return string
	 */
	public function getY() {
		return preg_replace('/^p?[0-9]*[-_][0-9]*[-_]([\.0-9]{1,6}):([\.0-9]{1,6})/', '$2', $this->getObjectPosition());
	}
}
