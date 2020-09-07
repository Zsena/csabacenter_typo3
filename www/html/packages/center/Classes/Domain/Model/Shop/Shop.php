<?php
namespace DigitalZombies\Center\Domain\Model\Shop;
use DigitalZombies\Center\Domain\Model\Center\Center;
use DigitalZombies\Center\Domain\Model\Center\CenterLevelPosition;
use DigitalZombies\Center\Domain\Model\Misc\Sender;
use DigitalZombies\Center\Domain\Model\Misc\Tag;
use DigitalZombies\Center\Domain\Model\PositionableInterface;
use DigitalZombies\Center\Domain\Model\RecordBase;
use DigitalZombies\Center\Utility\OpeningHoursHelper;
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
 *  (c) 2017 András Ottó <andras.otto@plan-net.com>, Plan.Net Pulse
 *
 */



/**
 * Shop
 *
 * Shop is a class to map properties from pages with doktype = 133.
 * !!!!This is a page !!!!
 * The record stored in the pages table.
 *
 */
class Shop extends RecordBase implements PositionableInterface
{
	/**
	 * Dok type for the page
	 */
	const DOKTYPE = 133;

	/**
	 * Dok type for the page
	 */
	const LIST_DOKTYPE = 151;

	/**
	 * Type for tags
	 */
	const TYPE = 133;

	/**
	 * Table name in the database
	 */
	const TABLE_NAME = 'pages';

	/**
	 * @var string
	 */
	protected $partialName = 'Shop';

	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	protected $logo = null;

	/**
	 * @var \DigitalZombies\Center\Domain\Model\Center\Center
	 * @lazy
	 */
	protected $center = null;

	/**
	 * @var \DigitalZombies\Center\Domain\Model\Shop\ChainStore
	 */
	protected $chainStore = null;

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
	 * weekly schedule
	 *
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\OpeningHours\YearlySchedule>
	 * @lazy
	 */
	protected $yearlySchedule = null;

	/**
	 * @var int
	 */
    protected $chainStoreContact = 0;

	/**
	 * @var int
	 */
	protected $chainStoreTags = 0;

	/**
	 * @var int
	 */
	protected $chainStoreText = 0;

	/**
	 * @var string
	 */
	protected $website = '';

	/**
	 * @var string
	 */
	protected $phone = '';

	/**
	 * @var string
	 */
	protected $email = '';

	/**
	 * @var string
	 */
	protected $shopName = '';

	/**
	 * @var CenterLevelPosition
	 */
	protected $firstPosition = null;

	/**
	 * @var array
	 */
	protected $tagIds = [];

    /**
     * @var string
     */
    protected $keywords = '';

    /**
     * @var string
     */
    protected $company = '';

    /**
     * @var string
     */
    protected $address = '';

    /**
     * @var string
     */
    protected $zipCity = '';


	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<DigitalZombies\Center\Domain\Model\Misc\Tag>
	 * @lazy
	 */
	protected $shopTags = null;

	public function __construct()
	{
		parent::__construct();
		$this->positions = new ObjectStorage();
		$this->shopTags = new ObjectStorage();
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
	 */
	public function getLogo()
	{
		return $this->logo;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $logo
	 */
	public function setLogo(FileReference $logo)
	{
		$this->logo = $logo;
	}

	/**
	 * @return Center
	 */
	public function getCenter()
	{
		if ($this->center instanceof LazyLoadingProxy) {
			$this->center->_loadRealInstance();
		}
		return $this->center;
	}

    /**
     * @return \DigitalZombies\Center\Domain\Model\Misc\Sender
     */
    public function getSender()
    {
        if (!$this->sender) {
            $this->sender = new Sender();
            $this->sender->setShop($this);
        }
        return $this->sender;
    }

    /**
     * @param Center $center
     */
    public function setCenter(Center $center)
    {
        $this->center = $center;
    }

	/**
	 * @return \DigitalZombies\Center\Domain\Model\Shop\ChainStore
	 */
	public function getChainStore()
	{
		return $this->chainStore;
	}

	/**
	 * @param \DigitalZombies\Center\Domain\Model\Shop\ChainStore $chainStore
	 */
	public function setChainStore(ChainStore $chainStore)
	{
		$this->chainStore = $chainStore;
	}


	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\Center\CenterLevelPosition>
	 */
	public function getPositions()
	{
		return $this->positions;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\Center\CenterLevelPosition> $positions
	 */
	public function setPositions($positions)
	{
		$this->positions = $positions;
	}

	/**
	 * @return string
	 */
	public function getShopName(): string
	{
		return $this->shopName;
	}

	/**
	 * @param string $shopName
	 */
	public function setShopName(string $shopName)
	{
		$this->shopName = $shopName;
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
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getShopTags()
	{
		return $this->shopTags;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $shopTags
	 */
	public function setShopTags(ObjectStorage $shopTags)
	{
		$this->shopTags = $shopTags;
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
	public function getChainStoreContact(): int
	{
		return $this->chainStoreContact;
	}

	/**
	 * @param int $chainStoreContact
	 */
	public function setChainStoreContact(int $chainStoreContact)
	{
		$this->chainStoreContact = $chainStoreContact;
	}

	/**
	 * @return int
	 */
	public function getChainStoreTags(): int
	{
		return $this->chainStoreTags;
	}

	/**
	 * @param int $chainStoreTags
	 */
	public function setChainStoreTags(int $chainStoreTags)
	{
		$this->chainStoreTags = $chainStoreTags;
	}

	/**
	 * @return int
	 */
	public function getChainStoreText(): int
	{
		return $this->chainStoreText;
	}

	/**
	 * @param int $chainStoreText
	 */
	public function setChainStoreText(int $chainStoreText)
	{
		$this->chainStoreText = $chainStoreText;
	}

	/**
	 * @return string
	 */
	public function getWebsite(): string
	{
		return $this->website;
	}

	/**
	 * @param string $website
	 */
	public function setWebsite(string $website)
	{
		$this->website = $website;
	}

	/**
	 * @return string
	 */
	public function getPhone(): string
	{
		return $this->phone;
	}

	/**
	 * @param string $phone
	 */
	public function setPhone(string $phone)
	{
		$this->phone = $phone;
	}

	/**
	 * @return string
	 */
	public function getEmail(): string
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 */
	public function setEmail(string $email)
	{
		$this->email = $email;
	}

    /**
     * @return string
     */
    public function getKeywords(): string
    {
        return $this->keywords;
    }

    /**
     * @param string $keywords
     */
    public function setKeywords(string $keywords)
    {
        $this->keywords = $keywords;
    }

	/**
	 * @return string
	 */
	public function getCategory()
	{
		return 	"shop";
	}

	/**
	 * !!! USE THE FOLLOWING PROPERTIES ON FE INSTEAD OF THE NATIVE ONES. !!!
	 */


	/**
	 * Returns the phone number of the contact
	 *
	 * @return string
	 */
	public function getContactPhone() {
		$phone = $this->getPhone();
		if(!$phone
			&& $this->getChainStoreContact()
			&& $this->getChainStore()) {
			return $this->getChainStore()->getPhone();
		} else {
			return $phone;
		}
	}

	/**
	 * Returns the website of the contact
	 *
	 * @return string
	 */
	public function getContactWebsite() {
		$website = $this->getWebsite();

		if(!$website
			&& $this->getChainStoreContact()
			&& $this->getChainStore()) {
			return $this->getChainStore()->getWebsite();
		} else {
			return $website;
		}
	}

	/**
	 * Returns the email of the contact
	 *
	 * @return string
	 */
	public function getContactEmail() {
		$email = $this->getEmail();

		if(!$email
			&& $this->getChainStoreContact()
			&& $this->getChainStore()) {
			return $this->getChainStore()->getEmail();
		} else {
			return $email;
		}
	}

	/**
	 * Returns the logo that needs to be used in FE
	 *
	 * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference|null
	 */
	public function getThumbnail() {
		if($this->getChainStore() && $this->getChainStore()->getLogo()) {
			return $this->getChainStore()->getLogo();
		} else {
			return $this->getLogo();
		}
	}

	/**
	 * Returns the logo that needs to be used in FE
	 *
	 * @return string
	 */
	public function getName(): string {
		if($this->getChainStore() && $this->getChainStore()->getName()) {
			return $this->getChainStore()->getName();
		} else {
			return $this->getShopName() ? $this->getShopName() : $this->getTitle();
		}
	}

	/**
	 * Returns an array with opening hours
	 *
	 * @return array
	 */
	public function getOpeningHours() {
		return OpeningHoursHelper::createOpeningHoursForShop($this);
	}

	/**
	 * Return the first center level position
	 *
	 * @return CenterLevelPosition|null
	 */
	public function getFirstPosition() {
		if(is_null($this->firstPosition)
			&& $this->getPositions()->count() > 0) {
			$this->firstPosition = $this->getPositions()->current();
		}

		return $this->firstPosition;
	}


	/**
	 * Returns the phone number of the contact
	 *
	 * @return string
	 */
	public function getText() {
		if($this->getChainStoreText()
			&& $this->getChainStore()) {
			return $this->getChainStore()->getDescription();
		} else {
			return $this->getContentText();
		}
	}

	/**
	 * Return the tagIds of the shop
	 *
	 * @return array
	 */
	public function getTagIds() {
		if(count($this->tagIds) === 0) {
			$tags = $this->getShopTags();
			if($this->getChainStoreTags()
				&& $this->getChainStore()) {
				$tags = $this->getChainStore()->getShopTags();
			}
			if($tags) {
                /** @var Tag $tag */
                foreach ($tags as $tag) {
                    $this->tagIds[] = $tag->getUid();
                }
            }

			//General Tags
			$tags = $this->getTags();
			if($this->getChainStoreTags()
				&& $this->getChainStore()) {
				$tags = $this->getChainStore()->getTags();
			}
			if($tags) {
				/** @var Tag $tag */
				foreach ($tags as $tag) {
					$this->tagIds[] = $tag->getUid();
				}
			}
		}

		return $this->tagIds;
	}

    /**
     * Return the tagIds of the shop
     *
     * @return string
     */
    public function getSearchKeywords() {
        if(!$this->keywords) {
            $this->keywords = $this->getKeywords();
            if ($this->getChainStoreText()
                && $this->getChainStore()) {
                $this->keywords = $this->getChainStore()->getKeywords();
            }
        }

        return $this->keywords;
    }

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param string $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $adress
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getZipCity()
    {
        return $this->zipCity;
    }

    /**
     * @param string $zipCity
     */
    public function setZipCity($zipCity)
    {
        $this->zipCity = $zipCity;
    }

}
