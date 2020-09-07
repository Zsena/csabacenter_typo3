<?php
namespace DigitalZombies\Center\Domain\Model;

use DigitalZombies\Center\Domain\Model\Misc\Contactperson;
use DigitalZombies\Center\Domain\Model\Misc\MetaTagEntity;
use DigitalZombies\Center\Domain\Model\Misc\Sender;
use DigitalZombies\Center\Domain\Model\Shop\ChainStore;
use DigitalZombies\Center\Domain\Model\Shop\Gastro;
use DigitalZombies\Center\Domain\Model\Shop\Shop;
use DigitalZombies\Center\Domain\Repository\Shop\ShopRepository;
use DigitalZombies\Center\Configuration\ScopeConfiguration;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use DigitalZombies\Center\Domain\Model\Misc\Gallery;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;
use TYPO3\CMS\Extbase\Persistence\Generic\QueryResult;
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
 * RecordBase
 *
 *
 * This is the class where the big journey begins.
 * Only the well prepared souls can understand what lies under this mighty construct.
 *
 * This class implements some stuff needed by each end every record types.
 * They have three groups:
 * SEO
 * Teaser
 * Social Media
 *
 * The fields are defined in the TCAFieldHelper. This little class is very useful
 * if you inherit these fields in the TCA Configuration.
 *
 * To this class is a view provided, which collects and transform each end every "teaserable" types,
 * filters them and helps prepare a teaser view.
 *
 */
class RecordBase extends MetaTagEntity implements TeaserInterface
{
	/**
	 * @var string
	 */
	protected $type = '';

	/**
	 * @var string
	 */
	protected $partialName = 'Default';

	/**
	 * Type for tags
	 */
	const TYPE = 'recordbase_general';

	/**
	 * Table name in the database
	 */
	const TABLE_NAME = 'tx_center_domain_model_recordbase';

	/**
	 * @var string
	 */
	protected $title = '';

    /**
     * @var string
     */
	protected $alternative_title = '';

	/**
	 * @var string
	 */
	protected $description = '';

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 * @lazy
	 */
	protected $ogImage = null;

	/**
	 * @var string
	 */
	protected $ogTitle = '';

	/**
	 * @var string
	 */
	protected $ogDescription = '';

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @lazy
     */
    protected $teaserVideo = null;

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 * @lazy
	 */
	protected $teaserImage = null;

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 * @lazy
	 */
	protected $teaserImage2 = null;

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 * @lazy
	 */
	protected $teaserImage3 = null;

	/**
	 * @var int
	 */
	protected $teaserFormat = 0;

	/**
	 * @var string
	 */
	protected $teaserAbstract = '';

	/**
     *
     * @var string
     */
    protected $teaserDate = "";

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $pageIcon = null;

	/**
	 * @var \DigitalZombies\Center\Domain\Model\Misc\Gallery
	 * @lazy
	 */
	protected $contentGallery = null;

	/**
	 * @var string
	 */
	protected $contentText = '';

	/**
	 * @var string
	 */
	protected $contentAbstract = '';

	/**
	 * @var string
	 */
	protected $contentHeadline = '';

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 * @lazy
	 */
	protected $contentDownloadfile = null;

	/**
	 * @var string
	 */
	protected $contentDownloadfiletext = '';

	/**
	 * @var string
	 */
	protected $contentDownloadlink = '';

	/**
	 * @var string
	 */
	protected $contentDownloadlinktext = '';


	/**
	 * @var string
	 */
	protected $contentPrologue = '';

	/**
	 * @var string
	 */
	protected $contentEpilogue = '';

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 * @lazy
	 */
	protected $contentStagemedia = null;

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 * @lazy
	 */
	protected $contentImage = null;

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 * @lazy
	 */
	protected $contentVideo = null;

	/**
	 * @var string
	 */
	protected $teaserCategory = '';

	/**
	 * @var int
	 */
	protected $starttime = '';

	/**
	 * @var int
	 */
	protected $endtime = '';

	/**
	 * @var Sender
	 */
	protected $sender = '';

	/**
	 * @var string
	 */
	protected $seoTitle = '';

	/**
	 * @var string
	 */
	protected $seoDescription = '';


	/**
	 * @var \DigitalZombies\Center\Domain\Model\Misc\Contactperson
	 * @lazy
	 */
	protected $contact = null;

	/**
	 * @var string
	 */
	protected $contactPhone = '';

	/**
	 * @var string
	 */
	protected $contactWebsite = '';

	/**
	 * @var string
	 */
	protected $contactWebsiteName = '';

	/**
	 * @var string
	 */
	protected $contactEmail = '';

    /**
     *
     * @var int
     */
    protected $hideInApp = "";

    /**
     *
     * @var int
     */
    protected $topInApp = 0;

    /**
     * @var bool
     */
    protected $isPreview = false;

    /**
     * @var string
     */
    protected $tableName = '';

    /**
     * @var string
     */
    protected $typeUid = '';

    /**
     * @var \DigitalZombies\Center\Domain\Model\Shop\Shop
     */
    protected $shop = null;

    /**
     * @var \DigitalZombies\Center\Domain\Model\Shop\ChainStore
     */
    protected $chainStore = null;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\Misc\Tag>
	 * @lazy
	 */
	protected $tags = null;

	public function __construct()
	{
		$this->tags = new ObjectStorage();
	}

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
	 * @return string
	 */
	public function getDescription(): string
	{
		return $this->description;
	}

	/**
	 * @param string $description
	 */
	public function setDescription(string $description)
	{
		$this->description = $description;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	public function getOgImage()
	{
		if ($this->ogImage instanceof LazyLoadingProxy) {
			$this->ogImage->_loadRealInstance();
		}
		return $this->ogImage;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $ogImage
	 */
	public function setOgImage(FileReference $ogImage)
	{
		$this->ogImage = $ogImage;
	}

	/**
	 * @return string
	 */
	public function getOgTitle(): string
	{
		return $this->ogTitle;
	}

	/**
	 * @param string $ogTitle
	 */
	public function setOgTitle(string $ogTitle)
	{
		$this->ogTitle = $ogTitle;
	}

	/**
	 * @return string
	 */
	public function getOgDescription(): string
	{
		return $this->ogDescription;
	}

	/**
	 * @param string $ogDescription
	 */
	public function setOgDescription(string $ogDescription)
	{
		$this->ogDescription = $ogDescription;
	}

	/**
	* @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	*/
	public function getTeaserVideo()
	{
		if ($this->teaserVideo instanceof LazyLoadingProxy) {
			$this->teaserVideo->_loadRealInstance();
		}
		return $this->teaserVideo;
	}

	/**
	* @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $teaserVideo
	*/
	public function setTeaserVideo(FileReference $teaserVideo)
	{
		$this->teaserVideo = $teaserVideo;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	public function getTeaserImage()
	{
		if ($this->teaserImage instanceof LazyLoadingProxy) {
			$this->teaserImage->_loadRealInstance();
		}
		return $this->teaserImage;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $teaserImage
	 */
	public function setTeaserImage(FileReference $teaserImage)
	{
		$this->teaserImage = $teaserImage;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	public function getTeaserImage2()
	{
		if ($this->teaserImage2 instanceof LazyLoadingProxy) {
			$this->teaserImage2->_loadRealInstance();
		}
		return $this->teaserImage2;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $teaserImage2
	 */
	public function setTeaserImage2(FileReference $teaserImage2)
	{
		$this->teaserImage2 = $teaserImage2;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	public function getTeaserImage3()
	{
		if ($this->teaserImage3 instanceof LazyLoadingProxy) {
			$this->teaserImage3->_loadRealInstance();
		}
		return $this->teaserImage3;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $teaserImage3
	 */
	public function setTeaserImage3(FileReference $teaserImage3)
	{
		$this->teaserImage3 = $teaserImage3;
	}

	/**
	 * @return int
	 */
	public function getTeaserFormat(): int
	{
		return $this->teaserFormat;
	}

	/**
	 * @param int $teaserFormat
	 */
	public function setTeaserFormat(int $teaserFormat)
	{
		$this->teaserFormat = $teaserFormat;
	}

	/**
	 * @return string
	 */
	public function getTeaserAbstract(): string
	{
		return $this->teaserAbstract;
	}

	/**
	 * @param string $teaserAbstract
	 */
	public function setTeaserAbstract(string $teaserAbstract)
	{
		$this->teaserAbstract = $teaserAbstract;
	}

	/**
     * @return string
     */
    public function getTeaserDate(): string
    {
        return $this->teaserDate;
    }

    /**
     * @param string $teaserDate
     */
    public function setTeaserDate(string $teaserDate)
    {
        $this->teaserDate = $teaserDate;
    }

	/**
	 * @return string
	 */
	public function getType(): string
	{
		return $this->type;
	}

	/**
	 * @param string $type
	 */
	public function setType(string $type)
	{
		$this->type = $type;
	}

	/**
	 * @return \DigitalZombies\Center\Domain\Model\Misc\Gallery
	 */
	public function getContentGallery()
	{
		if ($this->contentGallery instanceof LazyLoadingProxy) {
			$this->contentGallery->_loadRealInstance();
		}
		return $this->contentGallery;
	}

	/**
	 * @param \DigitalZombies\Center\Domain\Model\Misc\Gallery $contentGallery
	 */
	public function setContentGallery(Gallery $contentGallery)
	{
		$this->contentGallery = $contentGallery;
	}

	/**
	 * @return string
	 */
	public function getContentText(): string
	{
		return $this->contentText;
	}

	/**
	 * @param string $contentText
	 */
	public function setContentText(string $contentText)
	{
		$this->contentText = $contentText;
	}

	/**
	 * @return string
	 */
	public function getContentHeadline(): string
	{
		return $this->contentHeadline;
	}

	/**
	 * @param string $contentHeadline
	 */
	public function setContentHeadline(string $contentHeadline)
	{
		$this->contentHeadline = $contentHeadline;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	public function getContentDownloadfile()
	{
		if ($this->contentDownloadfile instanceof LazyLoadingProxy) {
			$this->contentDownloadfile->_loadRealInstance();
		}
		return $this->contentDownloadfile;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $contentDownloadfile
	 */
	public function setContentDownloadfile(FileReference $contentDownloadfile)
	{
		$this->contentDownloadfile = $contentDownloadfile;
	}

	/**
	 * @return string
	 */
	public function getContentDownloadfiletext(): string
	{
		return $this->contentDownloadfiletext;
	}

	/**
	 * @param string $contentDownloadfiletext
	 */
	public function setContentDownloadfiletext(string $contentDownloadfiletext)
	{
		$this->contentDownloadfiletext = $contentDownloadfiletext;
	}

	/**
	 * @return string
	 */
	public function getContentDownloadlink(): string
	{
		return $this->contentDownloadlink;
	}

	/**
	 * @param string $contentDownloadlink
	 */
	public function setContentDownloadlink(string $contentDownloadlink)
	{
		$this->contentDownloadlink = $contentDownloadlink;
	}

	/**
	 * @return string
	 */
	public function getContentDownloadlinktext(): string
	{
		return $this->contentDownloadlinktext;
	}

	/**
	 * @param string $contentDownloadlinktext
	 */
	public function setContentDownloadlinktext(string $contentDownloadlinktext)
	{
		$this->contentDownloadlinktext = $contentDownloadlinktext;
	}

	/**
	 * @return string
	 */
	public function getContentAbstract(): string
	{
		return $this->contentAbstract;
	}

	/**
	 * @param string $contentAbstract
	 */
	public function setContentAbstract(string $contentAbstract)
	{
		$this->contentAbstract = $contentAbstract;
	}

	/**
	 * @return mixed
	 */
	public function getContentPrologue()
	{
		return $this->contentPrologue;
	}

	/**
	 * @param mixed $contentPrologue
	 */
	public function setContentPrologue($contentPrologue)
	{
		$this->contentPrologue = $contentPrologue;
	}

	/**
	 * @return string
	 */
	public function getContentEpilogue(): string
	{
		return $this->contentEpilogue;
	}

	/**
	 * @param string $contentEpilogue
	 */
	public function setContentEpilogue(string $contentEpilogue)
	{
		$this->contentEpilogue = $contentEpilogue;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference|null
	 */
	public function getContentStagemedia()
	{
		if ($this->contentStagemedia instanceof LazyLoadingProxy) {
			$this->contentStagemedia->_loadRealInstance();
		}
		return $this->contentStagemedia;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $contentStagemedia
	 */
	public function setContentStagemedia(FileReference $contentStagemedia)
	{
		$this->contentStagemedia = $contentStagemedia;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	public function getContentImage()
	{
		if ($this->contentImage instanceof LazyLoadingProxy) {
			$this->contentImage->_loadRealInstance();
		}
		return $this->contentImage;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $contentImage
	 */
	public function setContentImage(FileReference $contentImage)
	{
		$this->contentImage = $contentImage;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	public function getContentVideo()
	{
		if ($this->contentVideo instanceof LazyLoadingProxy) {
			$this->contentVideo->_loadRealInstance();
		}
		return $this->contentVideo;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $contentVideo
	 */
	public function setContentVideo(FileReference $contentVideo)
	{
		$this->contentVideo = $contentVideo;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getTags()
	{
		return $this->tags;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $tags
	 */
	public function setTags(ObjectStorage $tags)
	{
		$this->tags = $tags;
	}

	public function getColumnClassName(){
		$className = '';

		if($this->getTeaserFormat() === 2) {
			$className = '--columns-2';
		} else if ($this->getTeaserFormat() === 3)  {
			$className = '--columns-3';
		}

		return $className;
	}

	/**
	 * @return string
	 */
	public function getTeaserCategory(): string
	{
		return $this->teaserCategory;
	}

	/**
	 * @param string $teaserCategory
	 */
	public function setTeaserCategory(string $teaserCategory)
	{
		$this->teaserCategory = $teaserCategory;
	}

	/**
	 * @return string
	 */
	public function getPartialName(): string
	{
		return $this->partialName;
	}

	/**
	 * @param string $partialName
	 */
	public function setPartialName(string $partialName)
	{
		$this->partialName = $partialName;
	}

	/**
	 * @return int
	 */
	public function getStarttime(): int
	{
		return $this->starttime;
	}

	/**
	 * @param int $starttime
	 */
	public function setStarttime(int $starttime)
	{
		$this->starttime = $starttime;
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
	 * @return \DigitalZombies\Center\Domain\Model\Misc\Sender
	 */
	public function getSender()
	{
		if (!$this->sender) {
			$this->sender = new Sender();
			if($this->getChainStore()) {

                /** @var ObjectManager $objectManager */
                $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

                /** @var ShopRepository $shopRepository */
                $shopRepository = $objectManager->get(ShopRepository::class);

                $result = $shopRepository->findByCenterAndChainStore(ScopeConfiguration::getCenterUid(),
                    $this->getChainStore()->getUid());

                $this->shop = $result->getFirst();
            }
            else if($this instanceof Shop || $this instanceof Gastro) {
                $this->shop = $this;
            }
            if($this->shop) {
                $this->sender->setShop($this->shop);
            }
		}
		return $this->sender;
	}

	/**
	 * @param \DigitalZombies\Center\Domain\Model\Misc\Sender $sender
	 */
	public function setSender(Sender $sender)
	{
		$this->sender = $sender;
	}

	/**
	 * @return string
	 */
	public function getSeoTitle(): string
	{
		return $this->seoTitle;
	}

	/**
	 * @param string $seoTitle
	 */
	public function setSeoTitle(string $seoTitle)
	{
		$this->seoTitle = $seoTitle;
	}

	/**
	 * @return string
	 */
	public function getSeoDescription(): string
	{
		return $this->seoDescription;
	}

	/**
	 * @param string $seoDescription
	 */
	public function setSeoDescription(string $seoDescription)
	{
		$this->seoDescription = $seoDescription;
	}

	/**
	 * @return Contactperson
	 */
	public function getContact()
	{
		if ($this->contact instanceof LazyLoadingProxy) {
			$this->contact->_loadRealInstance();
		}
		return $this->contact;
	}

	/**
	 * @param Contactperson $contact
	 */
	public function setContact(Contactperson $contact)
	{
		$this->contact = $contact;
	}


	/**
	 * Returns the phone number of the contact
	 *
	 * @return string
	 */
	public function getContactPhone() {
		if(!$this->contactPhone) {
			if ($this->getContact()) {
				$this->contactPhone = $this->getContact()->getPhone();
			} else if ($this->getSender()) {
				$this->contactPhone = $this->getSender()->getContactPhone();
			}
		}

		return $this->contactPhone;
	}

	/**
	 * Returns the website of the contact
	 *
	 * @return string
	 */
	public function getContactWebsite() {
		if(!$this->contactWebsite) {
			if ($this->getContact()) {
				$this->contactWebsite = $this->getContact()->getWebsite();
			} else if ($this->getSender()) {
				$this->contactWebsite = $this->getSender()->getContactWebsite();
			}
		}

		return $this->contactWebsite;
	}

	/**
	 * Returns the website of the contact
	 *
	 * @return string
	 */
	public function getContactWebsiteName() {
		if(!$this->contactWebsiteName) {
			$this->contactWebsiteName = preg_replace(
				'/(http|https):\/\//',
				'',
				$this->getContactWebsite());
		}

		return $this->contactWebsiteName;
	}

	/**
	 * Returns the email of the contact
	 *
	 * @return string
	 */
	public function getContactEmail() {
		if(!$this->contactEmail) {
			if ($this->getContact()) {
				$this->contactEmail = $this->getContact()->getEmail();
			} else if ($this->getSender()) {
				$this->contactEmail = $this->getSender()->getContactEmail();
			}
		}

		return $this->contactEmail;
	}

    /**
     * @return FileReference
     */
    public function getPageIcon()
    {
        return $this->pageIcon;
    }

    /**
     * @param FileReference $pageIcon
     */
    public function setPageIcon(FileReference $pageIcon)
    {
        $this->pageIcon = $pageIcon;
    }

    /**
     * @return int
     */
    public function getHideInApp()
    {
        return $this->hideInApp;
    }

    /**
     * @param int $hideInApp
     */
    public function setHideInApp(int $hideInApp)
    {
        $this->hideInApp = $hideInApp;
    }

    /**
     * @return bool
     */
    public function isPreview(): bool
    {
        return $this->isPreview;
    }

    /**
     * @return bool
     */
    public function getIsPreview(): bool
    {
        return $this->isPreview;
    }

    /**
     * @param bool $isPreview
     */
    public function setIsPreview(bool $isPreview)
    {
        $this->isPreview = $isPreview;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @param string $tableName
     */
    public function setTableName(string $tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * @return int
     */
    public function getTopInApp()
    {
        return $this->topInApp;
    }

    /**
     * @param int $topInApp
     */
    public function setTopInApp($topInApp)
    {
        $this->topInApp = $topInApp;
    }

    /**
     * @return string
     */
    public function getTypeUid(): string
    {
        return $this->typeUid;
    }

    /**
     * @param string $typeUid
     */
    public function setTypeUid(string $typeUid)
    {
        $this->typeUid = $typeUid;
    }

    /**
     * @return Shop
     */
    public function getShop()
    {
        return $this->shop;
    }

    /**
     * @param Shop $shop
     */
    public function setShop(Shop $shop)
    {
        $this->shop = $shop;
    }

    /**
     * @return ChainStore
     */
    public function getChainStore()
    {
        return $this->chainStore;
    }

    /**
     * @param ChainStore $chainStore
     */
    public function setChainStore(ChainStore $chainStore)
    {
        $this->chainStore = $chainStore;
    }

    /**
     * @return string
     */
    public function getAlternativeTitle(): string
    {
        return $this->alternative_title;
    }

    /**
     * @param string $alternative_title
     */
    public function setAlternativeTitle(string $alternative_title)
    {
        $this->alternative_title = $alternative_title;
    }
}
