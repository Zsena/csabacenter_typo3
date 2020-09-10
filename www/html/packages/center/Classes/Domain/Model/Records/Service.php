<?php

namespace DigitalZombies\Center\Domain\Model\Records;

use DigitalZombies\Center\Domain\Model\Center\Center;
use DigitalZombies\Center\Domain\Model\Misc\Tag;
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
 *  (c) 2017 David Miltz <d.miltz@plan-net.com>, Plan.Net Pulse
 *
 */
class Service extends RecordBase implements PositionableInterface
{

	/**
	 * @var string
	 */
	protected $partialName = 'Service';

	const TYPE = 'tx_center_domain_model_records_service';
	/**
	 * Table name in the database
	 */
	const TABLE_NAME = self::TYPE;

	const LIST_DOKTYPE = 152;

	/**
	 *
	 * @var bool
	 */
	protected $service247 = "";

	/**
	 *
	 * @var bool
	 */
	protected $ownOpenings = "";

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	protected $serviceIcon = null;

	/**
	 * @var \DigitalZombies\Center\Domain\Model\Center\Center
	 * @lazy
	 */
	protected $center = null;

	/**
	 * @var \DigitalZombies\Center\Domain\Model\Records\GlobalService
	 * @lazy
	 */
	protected $globalService = null;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\Center\CenterLevelPosition>
	 * @lazy
	 */
	protected $positions = null;


	/**
	 * weekly schedule
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\OpeningHours\DailyHours>
	 * @lazy
	 */
	protected $weeklySchedule = null;

	/**
	 * yearly schedule
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\OpeningHours\YearlySchedule>
	 * @lazy
	 */
	protected $yearlySchedule = null;

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

	/**
	 * @var int
	 */
	protected $contentShowglobalservicedata = 0;

    /**
     *
     * @var bool
     */
    protected $elevator = "";

	/**
	 * @var string
	 */
    protected $contentGoogleplay;

	/**
	 * @var string
	 */
    protected $contentApplestore;

	/**
	 * @var array
	 */
	protected $tagIds = [];

	public function __construct()
	{
		parent::__construct();
		$this->positions = new ObjectStorage();
		$this->weeklySchedule = new ObjectStorage();
		$this->yearlySchedule = new ObjectStorage();
		$this->serviceTags = new ObjectStorage();
	}

	/**
	 * @return bool
	 */
	public function getService247(): bool
	{
		return $this->service247;
	}

	/**
	 * @param bool $service247
	 */
	public function setService247(bool $service247)
	{
		$this->service247 = $service247;
	}

	/**
	 * @return bool
	 */
	public function getOwnOpenings(): bool
	{
		return $this->ownOpenings;
	}

	/**
	 * @param bool $ownOpenings
	 */
	public function setOwnOpenings(bool $ownOpenings)
	{
		$this->ownOpenings = $ownOpenings;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	public function getServiceIcon()
	{
		if($this->getGlobalService()) {
			return $this->getGlobalService()->getServiceIcon();
		} else {
			return $this->serviceIcon;
		}
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $serviceIcon
	 */
	public function setServiceIcon(FileReference $serviceIcon)
	{
		$this->serviceIcon = $serviceIcon;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getPositions()
	{
		return $this->positions;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $positions
	 */
	public function setPositions(ObjectStorage $positions)
	{
		$this->positions = $positions;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getWeeklySchedule()
	{
		return $this->weeklySchedule;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $weeklySchedule
	 */
	public function setWeeklySchedule(ObjectStorage $weeklySchedule)
	{
		$this->weeklySchedule = $weeklySchedule;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getYearlySchedule()
	{
		return $this->yearlySchedule;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $yearlySchedule
	 */
	public function setYearlySchedule(ObjectStorage $yearlySchedule)
	{
		$this->yearlySchedule = $yearlySchedule;
	}

	/**
	 * @return string
	 */
	public function getServiceLink(): string
	{
		$serviceLink = $this->serviceLink;

		if(!$serviceLink && $this->getContentShowglobalservicedata() == 1) {
			return $this->getGlobalService()->getServiceLink();
		} else {
			return $serviceLink;
		}
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
		$serviceLinkText = $this->serviceLinkText;

		if(!$serviceLinkText && $this->getContentShowglobalservicedata() == 1) {
			return $this->getGlobalService()->getServiceLinkText();
		} else {
			return $serviceLinkText;
		}
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
		$serviceTags =  $this->serviceTags;

		if(!$serviceTags && $this->getContentShowglobalservicedata() == 1) {
			return $this->getGlobalService()->getServiceTags();
		} else {
			return $serviceTags;
		}
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
		$title = $this->getTitle();

		if($this->getGlobalService()) {
			return $this->getGlobalService()->getTitle();
		} else {
			return $title;
		}
	}

	/**
	 * @return \DigitalZombies\Center\Domain\Model\Center\Center
	 */
	public function getCenter(): Center
	{
		if ($this->center instanceof LazyLoadingProxy) {
			$this->center->_loadRealInstance();
		}
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
		return 	"service";
	}

	/**
	 * GLOBAL SERVICES PARTS
	 */

	/**
	 * @return \DigitalZombies\Center\Domain\Model\Records\GlobalService
	 */
	public function getGlobalService()
	{
		if ($this->globalService instanceof LazyLoadingProxy) {
			$this->globalService->_loadRealInstance();
		}

		return $this->globalService;
	}

	/**
	 * @param \DigitalZombies\Center\Domain\Model\Records\GlobalService $globalService
	 */
	public function setGlobalService(GlobalService $globalService)
	{
		$this->globalService = $globalService;
	}

	public function getContentShowglobalservicedata(): int
	{
		return $this->contentShowglobalservicedata;
	}

	public function setContentShowglobalservicedata(int $contentShowglobalservicedata)
	{
		$this->contentShowglobalservicedata = $contentShowglobalservicedata;
	}

	public function getContentAbstract(): string
	{
		$contentAbstract =  parent::getContentAbstract(); // TODO: Change the autogenerated stub

		if(!$contentAbstract && $this->getContentShowglobalservicedata() == 1) {
			return $this->getGlobalService()->getContentAbstract();
		} else {
			return $contentAbstract;
		}
	}

	public function getContentText(): string
	{
		$contentText = parent::getContentText(); // TODO: Change the autogenerated stub

		if(!$contentText && $this->getContentShowglobalservicedata() == 1) {
			return $this->getGlobalService()->getContentText();
		} else {
			return $contentText;
		}
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	public function getContentImage()
	{
		$contentImage = parent::getContentImage(); // TODO: Change the autogenerated stub

		if(!$contentImage && $this->getContentShowglobalservicedata() == 1) {
			return $this->getGlobalService()->getContentImage();
		} else {
			return $contentImage;
		}
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	public function getContentDownloadfile()
	{
		$downloadFile = parent::getContentDownloadfile(); // TODO: Change the autogenerated stub

		if(!$downloadFile && $this->getContentShowglobalservicedata() == 1) {
			return $this->getGlobalService()->getContentDownloadfile();
		} else {
			return $downloadFile;
		}
	}

	public function getContentDownloadfiletext(): string
	{
		$contentDownloadfiletext = $this->contentDownloadfiletext;

		if(!$contentDownloadfiletext && $this->getContentShowglobalservicedata() == 1) {
			return $this->getGlobalService()->getContentDownloadfiletext();
		} else {
			return $contentDownloadfiletext;
		}
	}

	public function getContentDownloadlink(): string
	{
		$contentDownloadlink =  $this->contentDownloadlink;

		if(!$contentDownloadlink && $this->getContentShowglobalservicedata() == 1) {
			return $this->getGlobalService()->getContentDownloadlink();
		} else {
			return $contentDownloadlink;
		}
	}

	public function getContentDownloadlinktext(): string
	{
		$contentDownloadlinktext = $this->contentDownloadlinktext;

		if(!$contentDownloadlinktext && $this->getContentShowglobalservicedata() == 1) {
			return $this->getGlobalService()->getContentDownloadlinktext();
		} else {
			return $contentDownloadlinktext;
		}
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	public function getContentVideo()
	{
		$contentVideo = $this->contentVideo;

		if(!$contentVideo && $this->getContentShowglobalservicedata() == 1) {
			return $this->getGlobalService()->getContentVideo();
		} else {
			return $contentVideo;
		}
	}

	public function getContentGallery()
	{
		$contentGallery = parent::getContentGallery();

		if(!$contentGallery && $this->getContentShowglobalservicedata() == 1) {
			return $this->getGlobalService()->getContentGallery();
		} else {
			return $contentGallery;
		}
	}

    /**
     * @return bool
     */
    public function isElevator()
    {
        return $this->elevator;
    }

    /**
     * @param bool $elevator
     */
    public function setElevator(bool $elevator)
    {
        $this->elevator = $elevator;
    }

	/**
	 * @return string
	 */
	public function getContentGoogleplay()
	{
		return $this->contentGoogleplay;
	}

	/**
	 * @param string $contentGoogleplay
	 */
	public function setContentGoogleplay($contentGoogleplay)
	{
		$this->contentGoogleplay = $contentGoogleplay;
	}

	/**
	 * @return string
	 */
	public function getContentApplestore()
	{
		return $this->contentApplestore;
	}

	/**
	 * @param string $contentApplestore
	 */
	public function setContentApplestore($contentApplestore)
	{
		$this->contentApplestore = $contentApplestore;
	}

    public function getTagIds()
    {
        if (count($this->tagIds) === 0) {
            $tags = $this->getServiceTags();
            if ($tags) {
                /** @var Tag $tag */
                foreach ($tags as $tag) {
                    $this->tagIds[] = $tag->getUid();
                }
            }
            $tags = $this->getTags();
            if ($tags) {
                /** @var Tag $tag */
                foreach ($tags as $tag) {
                    $this->tagIds[] = $tag->getUid();
                }
            }
        }
        return $this->tagIds;
    }

}
