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
 * Headlines
 */
class Headlines extends AbstractEntity
{
	/**
	 * additionalShops
	 *
	 * @var string
	 */
	protected $additionalShops = '';


	/**
	 * additionalEvents
	 *
	 * @var string
	 */
	protected $additionalEvents = '';

	/**
	 * additionalOffers
	 *
	 * @var string
	 */
	protected $additionalOffers = '';

	/**
	 * gallery
	 *
	 * @var string
	 */
	protected $gallery = '';


	/**
	 * Sender Center
	 *
	 * @var \DigitalZombies\Center\Domain\Model\Center\Center
	 */
	protected $center = null;

	/**
	 * @return string
	 */
	public function getAdditionalShops(): string
	{
		return $this->additionalShops;
	}

	/**
	 * @param string $additionalShops
	 */
	public function setAdditionalShops(string $additionalShops)
	{
		$this->additionalShops = $additionalShops;
	}

	/**
	 * @return string
	 */
	public function getAdditionalEvents(): string
	{
		return $this->additionalEvents;
	}

	/**
	 * @param string $additionalEvents
	 */
	public function setAdditionalEvents(string $additionalEvents)
	{
		$this->additionalEvents = $additionalEvents;
	}

	/**
	 * @return string
	 */
	public function getAdditionalOffers(): string
	{
		return $this->additionalOffers;
	}

	/**
	 * @param string $additionalOffers
	 */
	public function setAdditionalOffers(string $additionalOffers)
	{
		$this->additionalOffers = $additionalOffers;
	}

	/**
	 * @return string
	 */
	public function getGallery(): string
	{
		return $this->gallery;
	}

	/**
	 * @param string $gallery
	 */
	public function setGallery(string $gallery)
	{
		$this->gallery = $gallery;
	}

	/**
	 * @return \DigitalZombies\Center\Domain\Model\Center\Center
	 */
	public function getCenter()
	{
		return $this->center;
	}

	/**
	 * @param \DigitalZombies\Center\Domain\Model\Center\Center $center
	 */
	public function setCenter(Center $center)
	{
		$this->center = $center;
	}
}
