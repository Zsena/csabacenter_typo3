<?php
namespace DigitalZombies\Center\Domain\Model\Misc;

use DigitalZombies\Center\Domain\Model\Center\Center;
use DigitalZombies\Center\Domain\Model\Shop\Shop;
use DigitalZombies\Center\Configuration\ScopeConfiguration;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
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
 * Sender
 */
class Sender extends AbstractEntity
{

	const SENDER_CENTER = 1;
	const SENDER_SHOP = 2;

	/**
	 * Sender shop
	 *
	 * @var \DigitalZombies\Center\Domain\Model\Shop\Shop
	 */
	protected $shop = null;

	/**
	 * OpeningHours array
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\OpeningHours\DailyHours>
	 */
	protected $openingHours = null;

	/**
	 * Sender type
	 *
	 * @var int
	 */
	protected $senderType = 0;

	/**
	 * Sender's name
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * Sender's logo
	 *
	 * @var FileReference
	 */
	protected $logo = null;

	/**
	 * Contactperson record
	 *
	 * @var Contactperson
	 */
	protected $contactperson = null;

	/**
	 * @return \DigitalZombies\Center\Domain\Model\Center\Center
	 */
	public function getCenter()
	{
		return ScopeConfiguration::getScope();
	}

	/**
	 * @return \DigitalZombies\Center\Domain\Model\Shop\Shop
	 */
	public function getShop()
	{
		return $this->shop;
	}

	/**
	 * @param \DigitalZombies\Center\Domain\Model\Shop\Shop $shop
	 */
	public function setShop(Shop $shop)
	{
		$this->shop = $shop;
	}

	/**
	 * Returns the sender type: 1 for CENTER, 2 for SHOP
	 *
	 * @return int
	 */
	public function getSenderType()
	{
		if ($this->senderType === 0) {
			$this->senderType = self::SENDER_CENTER;
			if ($this->getShop()) {
				$this->senderType = self::SENDER_SHOP;
			}
		}
		return $this->senderType;
	}

	/**
	 * Returns the sender's name
	 *
	 * @return string
	 */
	public function getName()
	{
		if ($this->name === '') {
			if ($this->getSenderType() === self::SENDER_CENTER) {
				if ($this->getCenter()) {
					$this->name = $this->getCenter()->getCenterName();
				}
			} else if ($this->getShop()) {
				$this->name = $this->getShop()->getName();
			}
		}
		return $this->name;
	}

	/**
	 * Returns the sender's logo
	 *
	 * @return FileReference
	 */
	public function getLogo()
	{
		if (!$this->logo) {
			if ($this->getSenderType() === self::SENDER_CENTER
				&& $this->getCenter()
			) {
				$this->logo = $this->getCenter()->getThumbnail();
			} else if ($this->getShop()) {
				$this->logo = $this->getShop()->getThumbnail();
			}
		}
		return $this->logo;
	}

	/**
	 * Returns the sender's logo
	 *
	 * @return array|ObjectStorage
	 */
	public function getOpeningHours()
	{
		if ($this->getShop()) {
			$this->openingHours = $this->getShop()->getWeeklySchedule();
		}
		// fallback: use center opening hours
		if (!$this->openingHours ||
            ($this->openingHours && $this->openingHours->count() == 0)) {
			$this->openingHours = $this->getCenter()->getWeeklySchedule();
		}
		
		return $this->openingHours;
	}

	/**
	 * Returns the phone number of the contact
	 *
	 * @return string
	 */
	public function getContactPhone()
	{
		if ($this->getSenderType() === self::SENDER_CENTER) {
			return $this->getCenter()->getPhone();
		} else {
			return $this->getShop()->getContactPhone();
		}
	}

	/**
	 * Returns the website of the contact
	 *
	 * @return string
	 */
	public function getContactWebsite()
	{
		if ($this->getSenderType() === self::SENDER_CENTER) {
			return '';
		} else {
			return $this->getShop()->getContactWebsite();
		}

	}

	/**
	 * Returns the email of the contact
	 *
	 * @return string
	 */
	public function getContactEmail()
	{
		if ($this->getSenderType() === self::SENDER_CENTER) {
			return $this->getCenter()->getEmail();
		} else {
			return $this->getShop()->getContactEmail();
		}
	}
}
