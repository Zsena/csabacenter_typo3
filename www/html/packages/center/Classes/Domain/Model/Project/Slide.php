<?php

namespace DigitalZombies\Center\Domain\Model\Project;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
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
class Slide extends AbstractEntity
{

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var string
     */
    protected $subtitle = '';

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $media = null;

    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $mediaPoster = null;

    /**
     * @var bool
     */
    protected $invertColor = false;

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
    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    /**
     * @param string $subtitle
     */
    public function setSubtitle(string $subtitle)
    {
        $this->subtitle = $subtitle;
    }


    /**
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getMedia()
    {
        return $this->media;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $media
     */
    public function setMedia(\TYPO3\CMS\Extbase\Domain\Model\FileReference $media)
    {
        $this->media = $media;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    public function getMediaPoster()
    {
        return $this->mediaPoster;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $mediaPoster
     */
    public function setMediaPoster(\TYPO3\CMS\Extbase\Domain\Model\FileReference $mediaPoster)
    {
        $this->mediaPoster = $mediaPoster;
    }

    /**
     * @return bool
     */
    public function isInvertColor(): bool
    {
        return $this->invertColor;
    }

    /**
     * @param bool $invertColor
     */
    public function setInvertColor(bool $invertColor)
    {
        $this->invertColor = $invertColor;
    }
}
