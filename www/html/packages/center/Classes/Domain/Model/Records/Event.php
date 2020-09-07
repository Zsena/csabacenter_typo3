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
class Event extends RecordBase
{

	/**
	 * @var string
	 */
	protected $partialName = 'Event';

	const TYPE = 'tx_center_domain_model_records_event';

	/**
	 * Table name in the database
	 */
	const TABLE_NAME = self::TYPE;

	// Tab Allgemein

	/**
	 * location
	 * @var string
	 */
	protected $location = "";

	/**
	 *
	 * @var string
	 */
	protected $detailDate = "";

	/**
	 *
	 * @var string
	 */
	protected $detailTime = "";

	/**
	 *
	 * @var int
	 */
	protected $eventShowical;

	/**
	 *
	 * @var int
	 */
	protected $eventStarttime;

	/**
	 *
	 * @var int
	 */
	protected $eventEndtime;

	// teaserDate resides in RecordBase because almost all teasers feature a date display

	/**
	 *
	 * @var string
	 */
	protected $teaserTime = "";

	/**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<DigitalZombies\Center\Domain\Model\Misc\Tag>
	 * @lazy
	 */
	protected $eventTags = null;

	/**
	 * @var string
	 */
	protected $inactiveClass = '';

	/**
	 * Event constructor.
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * @return string
	 */
	public function getLocation(): string
	{
		return $this->location;
	}

	/**
	 * @param string $location
	 */
	public function setLocation(string $location)
	{
		$this->location = $location;
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
	 * @return string
	 */
	public function getDetailTime(): string
	{
		return $this->detailTime;
	}

	/**
	 * @param string $detailTime
	 */
	public function setDetailTime(string $detailTime)
	{
		$this->detailTime = $detailTime;
	}

	/**
	 * @return string
	 */
	public function getTeaserTime()
	{
		return $this->teaserTime;
	}

	/**
	 * @param string $teaserTime
	 */
	public function setTeaserTime(string $teaserTime)
	{
		$this->teaserTime = $teaserTime;
	}

	/**
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
	 */
	public function getEventTags()
	{
		return $this->eventTags;
	}

	/**
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $eventTags
	 */
	public function setEventTags(ObjectStorage $eventTags)
	{
		$this->eventTags = $eventTags;
	}

	/**
	 * @return int
	 */
	public function getEventShowical()
	{
		return $this->eventShowical;
	}

	/**
	 * @param int $eventShowical
	 */
	public function setEventShowical(int $eventShowical)
	{
		$this->eventShowical = $eventShowical;
	}

	/**
	 * @return int
	 */
	public function getEventStarttime(): int
	{
		return $this->eventStarttime;
	}

	/**
	 * @param int $eventStarttime
	 */
	public function setEventStarttime(int $eventStarttime)
	{
		$this->eventStarttime = $eventStarttime;
	}

	/**
	 * @return int
	 */
	public function getEventEndtime(): int
	{
		return $this->eventEndtime;
	}

	/**
	 * @param int $eventEndtime
	 */
	public function setEventEndtime(int $eventEndtime)
	{
		$this->eventEndtime = $eventEndtime;
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
        $result = $fileRepository->findByRelation('tx_center_domain_model_records_event', 'content_image', $uid);

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
