<?php

namespace DigitalZombies\Center\Domain\Model\PushNotification;

use DigitalZombies\Center\PushNotification\Api\IllegalObjectLinkException;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2018- Fabian Gehrlicher <f.gehrlicher@plan-net.com>
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Class AbstractPushNotification
 * @package DigitalZombies\Center\Domain\Model\PushNotification
 */
abstract class PushNotification extends AbstractEntity
{
    const STANDARD_DELIVERY = 0;
    const TIME_BASED_DELIVERY = 1;

    const API_EVENT_LINK_TYPES = "events";
    const API_NEWS_LINK_TYPES = "news";
    const API_OFFER_LINK_TYPES = "offers";

    const TYPO3_EVENT_LINK_TYPES = "event";
    const TYPO3_NEWS_LINK_TYPES = "news";
    const TYPO3_OFFER_LINK_TYPES = "offer";

    const DELIVERY_TYPES = [
        self::STANDARD_DELIVERY,
        self::TIME_BASED_DELIVERY
    ];

    const LINK_TYPES_MAPPING = [
        self::TYPO3_EVENT_LINK_TYPES => self::API_EVENT_LINK_TYPES,
        self::TYPO3_NEWS_LINK_TYPES => self::API_NEWS_LINK_TYPES,
        self::TYPO3_OFFER_LINK_TYPES => self::API_OFFER_LINK_TYPES
    ];

    /**
     * @var \DateTime
     */
    protected $actualDeliveryDate;

    /**
     * @var bool
     */
    protected $markedForDelivery;

    /**
     * @var int
     */
    protected $deliveryType;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var \DateTime
     */
    protected $pushDate;

    /**
     * @var int
     */
    protected $pushTime;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\Center\Center>
     */
    protected $center;

    /**
     * @var string
     */
    protected $linkedElement;

    /**
     * @var int
     */
    protected $isTest;

    /**
     * @return mixed
     * @throws IllegalObjectLinkException
     */
    public function getObjectUid()
    {
        $matches = [];
        preg_match('/uid=(.*)/', $this->linkedElement, $matches);
        if (!isset($matches[1]) || !($matches[1] > 0)) {
            throw new IllegalObjectLinkException("Illegal Object Link");
        }
        return $matches[1];
    }

    /**
     * @return mixed
     * @throws IllegalObjectLinkException
     */
    public function getObjectType()
    {
        $matches = [];
        preg_match('/identifier=(.*)\&/', $this->linkedElement, $matches);
        if (!isset($matches[1]) || !isset(self::LINK_TYPES_MAPPING[$matches[1]])) {
            throw new IllegalObjectLinkException("Illegal Object Link");
        }
        return self::LINK_TYPES_MAPPING[$matches[1]];
    }

    /**
     * @return string
     */
    public function getLinkedElement(): string
    {
        return $this->linkedElement;
    }

    /**
     * @param string $linkedElement
     */
    public function setLinkedElement(string $linkedElement): void
    {
        $this->linkedElement = $linkedElement;
    }

    /**
     * @return \DateTime $pushDate
     */
    public function getPushDate()
    {
        return $this->pushDate;
    }

    /**
     * @param \DateTime $pushDate
     */
    public function setPushDate(\DateTime $pushDate)
    {
        $this->pushDate = $pushDate;
    }

    /**
     * @return int $pushTime
     */
    public function getPushTime()
    {
        return $this->pushTime;
    }

    /**
     * @param int $pushTime
     */
    public function setPushTime(int $pushTime)
    {
        $this->pushTime = $pushTime;
    }

    /**
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string $text
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return int $type
     */
    public function getDeliveryType(): int
    {
        return $this->deliveryType;
    }

    /**
     * @param int $deliveryType
     */
    public function setDeliveryType($deliveryType)
    {
        $this->deliveryType = $deliveryType;
    }

    /**
     * @return \DateTime
     */
    public function getActualDeliveryDate(): \DateTime
    {
        return $this->actualDeliveryDate;
    }

    /**
     * @param \DateTime $actualDeliveryDate
     */
    public function setActualDeliveryDate(\DateTime $actualDeliveryDate)
    {
        $this->actualDeliveryDate = $actualDeliveryDate;
    }

    /**
     * @return int
     */
    public function get_LanguageUid(): int
    {
        return $this->_languageUid;
    }

    /**
     * @return bool
     */
    public function getMarkedForDelivery(): bool
    {
        return $this->markedForDelivery;
    }

    /**
     * @param bool $markedForDelivery
     */
    public function setMarkedForDelivery(bool $markedForDelivery)
    {
        $this->markedForDelivery = $markedForDelivery;
    }

    /**
     * @return ObjectStorage
     */
    public function getCenter()
    {
        return $this->center;
    }

    /**
     * @param ObjectStorage $center
     */
    public function setCenter($center)
    {
        $this->center = $center;
    }

    /**
     * @param $center
     */
    public function attachCenter($center)
    {
        $this->center->attach($center);
    }

    /**
     * @return int
     */
    public function isTest(): int
    {
        return $this->isTest;
    }

    /**
     * @param int $isTest
     */
    public function setIsTest(int $isTest)
    {
        $this->isTest = $isTest;
    }
}
