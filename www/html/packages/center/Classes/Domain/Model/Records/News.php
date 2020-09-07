<?php

namespace DigitalZombies\Center\Domain\Model\Records;

use DigitalZombies\Center\Domain\Model\RecordBase;
use TYPO3\CMS\Core\Resource\FileRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;
use TYPO3\CMS\Core\Resource\FileReference as ResourceFileReference;
use TYPO3\CMS\Extbase\Domain\Model\FileReference as ModelFileReference;

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
 * News
 */
class News extends RecordBase
{
    const TYPE = 'tx_center_domain_model_records_news';

    /**
     * Table name in the database
     */
    const TABLE_NAME = self::TYPE;

    const NEWS = 1;
    const PRESS = 2;


    /**
     * @var string
     */
    protected $partialName = 'News';

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var string
     */
    protected $type = '0';

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<DigitalZombies\Center\Domain\Model\Misc\Tag>
     * @lazy
     */
    protected $newsTags = null;

    /**
     * @var string
     */
    protected $contentGoogleplay;

    /**
     * @var string
     */
    protected $contentApplestore;

    /**
     * @var string
     */
    protected $inactiveClass = '';

    /**
     * News constructor.
     */
    public function __construct()
    {
        parent::__construct();
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
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getNewsTags()
    {
        return $this->newsTags;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $newsTags
     */
    public function setNewsTags(ObjectStorage $newsTags)
    {
        $this->newsTags = $newsTags;
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
        $result = $fileRepository->findByRelation('tx_center_domain_model_records_news', 'content_image', $uid);

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
