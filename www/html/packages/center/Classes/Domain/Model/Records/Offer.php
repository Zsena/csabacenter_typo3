<?php

namespace DigitalZombies\Center\Domain\Model\Records;

use DigitalZombies\Center\Domain\Model\RecordBase;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

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
class Offer extends RecordBase
{

	/**
	 * @var string
	 */
	protected $partialName = 'Offer';

	const TYPE = 'tx_center_domain_model_records_offer';
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
     * @var string
     */
    protected $offerContentLinkToAllOffers = '';

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<DigitalZombies\Center\Domain\Model\Misc\Tag>
	 * @lazy
	 */
	protected $offerTags = null;

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<DigitalZombies\Center\Domain\Model\Interest\Interest>
	 * @lazy
	 */
	protected $interests = null;

	/**
	 * @var string
	 */
	protected $inactiveClass = '';

	/**
	 * Offer constructor.
	 */
	public function __construct()
	{
		parent::__construct();
		$this->offerTags = new ObjectStorage();
	}

    /**
     * @return string
     */
    public function getOfferContentLinkToAllOffers(): string
    {
        return $this->offerContentLinkToAllOffers;
    }

    /**
     * @param string $offerContentLinkToAllOffers
     */
    public function setOfferContentLinkToAllOffers(string $offerContentLinkToAllOffers)
    {
        $this->offerContentLinkToAllOffers = $offerContentLinkToAllOffers;
    }


	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getOfferTags()
	{
		return $this->offerTags;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $offerTags
	 */
	public function setOfferTags(ObjectStorage $offerTags)
	{
		$this->offerTags = $offerTags;
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
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getInterests()
	{
		return $this->interests;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $interests
	 */
	public function setInterests(ObjectStorage $interests)
	{
		$this->interests = $interests;
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
        $result = $fileRepository->findByRelation('tx_center_domain_model_records_offer', 'content_image', $uid);

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
