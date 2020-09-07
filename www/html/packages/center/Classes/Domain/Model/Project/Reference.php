<?php

namespace DigitalZombies\Center\Domain\Model\Project;

use DigitalZombies\Center\Domain\Model\Misc\MetaTagEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 *
 * This file is part of the "center" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2019 András Ottó <an.otto@plan-net.com>, Plan.Net Technology
 *
 */
class Reference extends MetaTagEntity
{

    const TYPE = 'tx_center_domain_model_project_reference';

    /**
     * Properties inherited:
     *
     * title
     * ogImage
     * ogTitle
     * ogDescription
     * seoTitle
     * seoDescription
     */

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\Project\Slide>
     * @lazy
     */
    protected $slides = null;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @lazy
     */
    protected $images = null;

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $heroImage = null;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\Project\DownloadButton>
     */
    protected $downloadButtons = null;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\Project\Reference>
     * @lazy
     */
    protected $relatedReferences = null;

    /**
     * @var string
     */
    protected $implementationCopy = '';

    /**
     * @var string
     */
    protected $tableHeadline = '';

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\Project\Table>
     */
    protected $tables = null;

    /**
     * @var string
     */
    protected $teaserTitle = '';

    /**
     * @var string
     */
    protected $teaserAbstract = '';

    /**
     * @var string
     */
    protected $teaserCustomer = '';

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $teaserImage = null;

    /**
     * @var string
     */
    protected $missionCopy = '';

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $missionLogo = null;

    /**
     * @var string
     */
    protected $missionText = '';

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<DigitalZombies\Center\Domain\Model\Misc\Tag>
     * @lazy
     */
    protected $referenceTags = null;


    public function __construct()
    {
        $this->images = new ObjectStorage();
        $this->downloadButtons = new ObjectStorage();
        $this->slides = new ObjectStorage();
        $this->tables = new ObjectStorage();
        $this->referenceTags = new ObjectStorage();
        $this->relatedReference = new ObjectStorage();
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getSlides()
    {
        return $this->slides;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $slides
     */
    public function setSlides(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $slides)
    {
        $this->slides = $slides;
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
    public function setImages(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $images)
    {
        $this->images = $images;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getHeroImage(): \TYPO3\CMS\Extbase\Domain\Model\FileReference
    {
        return $this->heroImage;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $heroImage
     */
    public function setHeroImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $heroImage)
    {
        $this->heroImage = $heroImage;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getDownloadButtons()
    {
        return $this->downloadButtons;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $downloadButtons
     */
    public function setDownloadButtons(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $downloadButtons)
    {
        $this->downloadButtons = $downloadButtons;
    }

    /**
     * @return string
     */
    public function getImplementationCopy(): string
    {
        return $this->implementationCopy;
    }

    /**
     * @param string $implementationCopy
     */
    public function setImplementationCopy(string $implementationCopy)
    {
        $this->implementationCopy = $implementationCopy;
    }

    /**
     * @return string
     */
    public function getTableHeadline(): string
    {
        return $this->tableHeadline;
    }

    /**
     * @param string $tableHeadline
     */
    public function setTableHeadline(string $tableHeadline)
    {
        $this->tableHeadline = $tableHeadline;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage
     */
    public function getTables()
    {
        return $this->tables;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $tables
     */
    public function setTables(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $tables)
    {
        $this->tables = $tables;
    }

    /**
     * @return string
     */
    public function getTeaserTitle(): string
    {
        return $this->teaserTitle;
    }

    /**
     * @param string $teaserTitle
     */
    public function setTeaserTitle(string $teaserTitle)
    {
        $this->teaserTitle = $teaserTitle;
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
    public function getTeaserCustomer(): string
    {
        return $this->teaserCustomer;
    }

    /**
     * @param string $teaserCustomer
     */
    public function setTeaserCustomer(string $teaserCustomer)
    {
        $this->teaserCustomer = $teaserCustomer;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getTeaserImage()
    {
        return $this->teaserImage;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $teaserImage
     */
    public function setTeaserImage(\TYPO3\CMS\Extbase\Domain\Model\FileReference $teaserImage)
    {
        $this->teaserImage = $teaserImage;
    }

    /**
     * @return string
     */
    public function getMissionCopy(): string
    {
        return $this->missionCopy;
    }

    /**
     * @param string $missionCopy
     */
    public function setMissionCopy(string $missionCopy)
    {
        $this->missionCopy = $missionCopy;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getMissionLogo()
    {
        return $this->missionLogo;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $missionLogo
     */
    public function setMissionLogo(\TYPO3\CMS\Extbase\Domain\Model\FileReference $missionLogo)
    {
        $this->missionLogo = $missionLogo;
    }

    /**
     * @return string
     */
    public function getMissionText(): string
    {
        return $this->missionText;
    }

    /**
     * @param string $missionText
     */
    public function setMissionText(string $missionText)
    {
        $this->missionText = $missionText;
    }

    /**
     * @return ObjectStorage
     */
    public function getReferenceTags()
    {
        return $this->referenceTags;
    }

    /**
     * @param ObjectStorage $referenceTags
     */
    public function setReferenceTags(ObjectStorage $referenceTags)
    {
        $this->referenceTags = $referenceTags;
    }

    /**
     * @return ObjectStorage
     */
    public function getRelatedReferences()
    {
        return $this->relatedReferences;
    }

    /**
     * @param ObjectStorage $relatedReferences
     */
    public function setRelatedReferences(ObjectStorage $relatedReferences)
    {
        $this->relatedReferences = $relatedReferences;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return '';
    }
}
