<?php

namespace DigitalZombies\Center\Domain\Model\Records;

use DigitalZombies\Center\Domain\Model\RecordBase;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;

use TYPO3\CMS\Core\Resource\FileReference as ResourceFileReference;
use TYPO3\CMS\Extbase\Domain\Model\FileReference as ModelFileReference;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Core\Resource\FileRepository;

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
class Coupon extends RecordBase
{

    /**
     * @var string
     */
    protected $partialName = 'Coupon';

    const TYPE = 'tx_center_domain_model_records_coupon';
    /**
     * Table name in the database
     */
    const TABLE_NAME = self::TYPE;

    /**
     *
     * @var string
     */
    protected $detailDate = "";

    /**
     *
     * @var int
     */
    protected $couponView = "";

    /**
     *
     * @var int
     */
    protected $couponsRedeemed = "";

    /**
     *
     * @var int
     */
    protected $fixedAmount = "";

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @lazy
     */
    protected $imageRedeem = null;

    /**
     *
     * @var string
     */
    protected $validCouponMessage = "";

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<DigitalZombies\Center\Domain\Model\Misc\Tag>
     * @lazy
     */
    protected $couponTags = null;

	/**
	 * @var string
	 */
	protected $inactiveClass = '';

    /**
     * Coupon constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->couponTags = new ObjectStorage();
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getCouponTags()
    {
        return $this->couponTags;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $couponTags
     */
    public function setCouponTags(ObjectStorage $couponTags)
    {
        $this->couponTags = $couponTags;
    }

    /**
     * @return int $couponView
     */
    public function getCouponView()
    {
        return $this->couponView;
    }

    /**
     * @param int $couponView
     */
    public function setCouponView(int $couponView)
    {
        $this->couponView = $couponView;
    }

    /**
     * @param int $validCouponMessage
     */
    public function setValidCouponMessage(int $validCouponMessage)
    {
        $this->validCouponMessage = $validCouponMessage;
    }

    /**
     * @return int $validCouponMessage
     */
    public function getValidCouponMessage()
    {
        return $this->validCouponMessage;
    }

    /**
     * @return string
     */
    public function getDetailDate(): string
    {
        return $this->detailDate;
    }

    /**
     * @param string $detailDate
     */
    public function setDetailDate(string $detailDate)
    {
        $this->detailDate = $detailDate;
    }

    /**
     * @return int
     */
    public function getFixedAmount(): int
    {
        return $this->fixedAmount;
    }

    /**
     * @param int $fixedAmount
     */
    public function setFixedAmount(int $fixedAmount)
    {
        $this->fixedAmount = $fixedAmount;
    }

    /**
     * @return int
     */
    public function getCouponsRedeemed(): int
    {
        return $this->couponsRedeemed;
    }

    /**
     * @param int $couponsRedeemed
     */
    public function setCouponsRedeemed(int $couponsRedeemed)
    {
        $this->couponsRedeemed = $couponsRedeemed;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getImageRedeem()
    {
        if ($this->imageRedeem instanceof LazyLoadingProxy) {
            $this->imageRedeem->_loadRealInstance();
        }
        return $this->imageRedeem;
    }

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     * @lazy
     */
    public function setImageRedeem(FileReference $imageRedeem)
    {
        $this->imageRedeem = $imageRedeem;
    }

	/**
	 * @return string
	 */
	public function getInactiveClass()
	{
		return $this->inactiveClass;
	}

	/**
	 * @param string $inactiveClass
	 */
	public function setInactiveClass($inactiveClass)
	{
		$this->inactiveClass = $inactiveClass;
	}

    /**
     * @return mixed|ModelFileReference
     * @throws \ReflectionException
     */
    public function getContentImage()
    {
        /** @var FileRepository $fileRepository */
        $fileRepository = GeneralUtility::makeInstance(FileRepository::class);
        $uid = $GLOBALS['TSFE']->sys_language_uid > 0 ? $this->_localizedUid : $this->uid;

        /** @var []ResourceFileReference $result */
        $result = $fileRepository->findByRelation('tx_center_domain_model_records_coupon', 'content_image', $uid);

        if (!$result[0] instanceof ResourceFileReference) {
            return;
        }

        $properties = $result[0]->getProperties();
        return $this->cast(ModelFileReference::class, $properties);

    }

    /**
     * @param $destination
     * @param $sourceArray
     * @return mixed
     * @throws \ReflectionException
     */
    public function cast($destination, $sourceArray)
    {
        if (is_string($destination)) {
            $objectManager = GeneralUtility::makeInstance(ObjectManager::class);
            $destination = $objectManager->get($destination);
        }
        $destinationReflection = new \ReflectionObject($destination);

        $sourceProperties = $sourceArray;

        foreach ($sourceProperties as $sourceKey => $sourceValue) {
            $name = $sourceKey;
            $value = $sourceValue;
            if ($destinationReflection->hasProperty($sourceKey)) {
                $propDest = $destinationReflection->getProperty($sourceKey);
                $propDest->setAccessible(true);
                $propDest->setValue($destination, $value);
            } else {
                $destination->$name = $value;
            }
        }
        return $destination;
    }
}
