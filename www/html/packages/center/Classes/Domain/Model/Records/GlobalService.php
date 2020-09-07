<?php

namespace DigitalZombies\Center\Domain\Model\Records;

use DigitalZombies\Center\Domain\Model\Center\Center;
use DigitalZombies\Center\Domain\Model\PositionableInterface;
use DigitalZombies\Center\Domain\Model\RecordBase;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 *
 * This file is part of the "center" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Victor Young <v.young@plan-net.com>, Plan.Net Pulse
 *
 */
class GlobalService extends RecordBase implements PositionableInterface
{

	/**
	 * @var string
	 */
	protected $partialName = 'GlobalService';

	const TYPE = 'tx_center_domain_model_records_globalservice';
	/**
	 * Table name in the database
	 */
	const TABLE_NAME = self::TYPE;

	const LIST_DOKTYPE = 152;

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	protected $serviceIcon = null;

	/**
	 * @var integer
	 * @lazy
	 */
	protected $center = null;

	/**
	 * service link
	 *
	 * @var string
	 */
	protected $serviceLink = '';

	/**
	 * service link
	 *
	 * @var string
	 */
	protected $serviceLinkText = '';

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<DigitalZombies\Center\Domain\Model\Misc\Tag>
	 * @lazy
	 */
	protected $serviceTags = null;

	public function __construct()
	{
		parent::__construct();
		$this->weeklySchedule = new ObjectStorage();
		$this->yearlySchedule = new ObjectStorage();
		$this->serviceTags = new ObjectStorage();
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	public function getServiceIcon()
	{
		return $this->serviceIcon;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $serviceIcon
	 */
	public function setServiceIcon(FileReference $serviceIcon)
	{
		$this->serviceIcon = $serviceIcon;
	}

	/**
	 * @return string
	 */
	public function getServiceLink(): string
	{
		return $this->serviceLink;
	}

	/**
	 * @param string $serviceLink
	 */
	public function setServiceLink(string $serviceLink)
	{
		$this->serviceLink = $serviceLink;
	}

	/**
	 * @return string
	 */
	public function getServiceLinkText(): string
	{
		return $this->serviceLinkText;
	}

	/**
	 * @param string $serviceLinkText
	 */
	public function setServiceLinkText(string $serviceLinkText)
	{
		$this->serviceLinkText = $serviceLinkText;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getServiceTags()
	{
		return $this->serviceTags;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $serviceTags
	 */
	public function setServiceTags(ObjectStorage $serviceTags)
	{
		$this->serviceTags = $serviceTags;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	public function getThumbnail()
	{
		return $this->getServiceIcon();
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->getTitle();
	}

	/**
	 * @return integer
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
	public function getCategory()
	{
		return 	"global service";
	}


}
