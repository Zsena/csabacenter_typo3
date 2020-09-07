<?php
namespace DigitalZombies\Center\Domain\Model\Misc;

use DigitalZombies\Center\Domain\Model\Center\Center;
use DigitalZombies\Center\Domain\Model\Shop\Shop;
use DigitalZombies\Center\Configuration\ScopeConfiguration;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
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
 * MetaTagEntity
 */
class MetaTagEntity extends AbstractEntity
{

    /**
     * @var string
     */
    protected $title = '';
    /**
     * @var string
     */
    protected $description = '';
    /**
     * @var string
     */
    protected $seoTitle = '';
    /**
     * @var string
     */
    protected $seoDescription = '';
    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
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
}
