<?php

namespace DigitalZombies\Center\Domain\Model\Shop;

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

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
 * ChainStore
 */
class ChainStore extends AbstractEntity
{
    /**
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $logo = null;

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var string
     */
    protected $metaTitle = '';

    /**
     * @var string
     */
    protected $metaDescription = '';

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
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\Misc\Tag>
     * @lazy
     */
    protected $tags = null;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<DigitalZombies\Center\Domain\Model\Misc\Tag>
     * @lazy
     */
    protected $gastroTags = null;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<DigitalZombies\Center\Domain\Model\Misc\Tag>
     * @lazy
     */
    protected $shopTags = null;

    /**
     * @var string
     */
    protected $keywords = '';

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
    public function setLogo($logo)
    {
        $this->logo = $logo;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
    public function getMetaTitle(): string
    {
        return $this->metaTitle;
    }

    /**
     * @param string $metaTitle
     */
    public function setMetaTitle(string $metaTitle)
    {
        $this->metaTitle = $metaTitle;
    }

    /**
     * @return string
     */
    public function getMetaDescription(): string
    {
        return $this->metaDescription;
    }

    /**
     * @param string $metaDescription
     */
    public function setMetaDescription(string $metaDescription)
    {
        $this->metaDescription = $metaDescription;
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
     * Returns the metaDescription if it is filled the description otherwise.
     *
     * @return string
     */
    public function fillMetaTagDescription()
    {
        if ($this->metaDescription) {
            return $this->metaDescription;
        } else {
            return $this->description;
        }
    }

    /**
     * Returns the metaTitle if it is filled the name otherwise.
     *
     * @return string
     */
    public function fillMetaTagTitle()
    {
        if ($this->metaTitle) {
            return $this->metaTitle;
        } else {
            return $this->name;
        }
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<DigitalZombies\Center\Domain\Model\Misc\Tag>
     */
    public function getGastroTags()
    {
        return $this->gastroTags;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<DigitalZombies\Center\Domain\Model\Misc\Tag> $gastroTags
     */
    public function setGastroTags($gastroTags)
    {
        $this->gastroTags = $gastroTags;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<DigitalZombies\Center\Domain\Model\Misc\Tag>
     */
    public function getShopTags()
    {
        return $this->shopTags;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<DigitalZombies\Center\Domain\Model\Misc\Tag> $shopTags
     */
    public function setShopTags($shopTags)
    {
        $this->shopTags = $shopTags;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<DigitalZombies\Center\Domain\Model\Misc\Tag>
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<DigitalZombies\Center\Domain\Model\Misc\Tag> $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
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
