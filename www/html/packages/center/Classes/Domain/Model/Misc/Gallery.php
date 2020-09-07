<?php
namespace DigitalZombies\Center\Domain\Model\Misc;

use DigitalZombies\Center\Domain\Model\Center\Center;
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
 * Gallery
 */
class Gallery extends AbstractEntity
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
	protected $endtime = 0;

	/**
	 * center
	 *
	 * @var \DigitalZombies\Center\Domain\Model\Center\Center
	 */
	protected $center = null;

	/** @var string  */
	protected $titleIntern = '';

	/**
	 * images
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
	 */
	protected $images = null;

	/**
	 * Gallery constructor.
	 */
	public function __construct()
	{
		$this->images = new ObjectStorage();
	}

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
	public function getEndtime(): int
	{
		return $this->endtime;
	}

	/**
	 * @param int $endtime
	 */
	public function setEndtime(int $endtime)
	{
		$this->endtime = $endtime;
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


	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getImages()
	{
		return $this->images;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $images
	 */
	public function setImages(ObjectStorage $images)
	{
		$this->images = $images;
	}

	/**
	 * @return string
	 */
	public function getTitleIntern(): string
	{
		return $this->titleIntern;
	}

	/**
	 * @param string $titleIntern
	 */
	public function setTitleIntern(string $titleIntern)
	{
		$this->titleIntern = $titleIntern;
	}
}
