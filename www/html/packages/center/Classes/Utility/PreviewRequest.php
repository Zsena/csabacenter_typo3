<?php

namespace DigitalZombies\Center\Utility;

use DigitalZombies\Center\Domain\Model\Records\Coupon;
use DigitalZombies\Center\Domain\Model\Records\Event;
use DigitalZombies\Center\Domain\Model\Records\Job;
use DigitalZombies\Center\Domain\Model\Records\News;
use DigitalZombies\Center\Domain\Model\Records\Offer;
use DigitalZombies\Center\Exception\InvalidPreviewRequestException;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2018 Fabian Gehrlicher <f.gehrlicher@plan-net.com>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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
 * Class PreviewRequest
 * @package DigitalZombies\Center\Utility
 */
class PreviewRequest
{
    const PREVIEW_KEY = 'tx_center_preview';
    const PREVIEW_TYPE_KEY = 'table';
    const PREVIEW_UID_KEY = 'uid';
    const PREVIEW_TEASER_FORMAT_KEY = 'teaser_format';
    /**
     * Maps the allowed types to their corresponding Models
     */
    const MAPPING = [
        'tx_center_domain_model_records_offer' => Offer::class,
        'tx_center_domain_model_records_job' => Job::class,
        'tx_center_domain_model_records_news' => News::class,
        'tx_center_domain_model_records_event' => Event::class,
        'tx_center_domain_model_records_coupon' => Coupon::class
    ];

    /**
     * The storage table name of the requested preview item
     * @var string
     */
    private $type;

    /**
     * The uid of the requested preview item
     * @var int
     */
    private $uid;

    /**
     * The teaser Format of the requested preview item
     * @var int
     */
    private $teaserFormat = 0;

    /**
     * PreviewRequest constructor.
     * @param array $getParameter
     * @throws InvalidPreviewRequestException
     */
    public function __construct(array $getParameter)
    {
        if (!isset($getParameter[self::PREVIEW_KEY][self::PREVIEW_TYPE_KEY])) {
            throw new InvalidPreviewRequestException("Invalid Preview Request: preview item type missing");
        }
        if (!isset($getParameter[self::PREVIEW_KEY][self::PREVIEW_UID_KEY])) {
            throw new InvalidPreviewRequestException("Invalid Preview Request: preview item uid missing");
        }
        $this->type = $getParameter[self::PREVIEW_KEY][self::PREVIEW_TYPE_KEY];
        $this->uid = $getParameter[self::PREVIEW_KEY][self::PREVIEW_UID_KEY];
        if (isset($getParameter[self::PREVIEW_KEY][self::PREVIEW_TEASER_FORMAT_KEY])) {
            $this->teaserFormat = $getParameter[self::PREVIEW_KEY][self::PREVIEW_TEASER_FORMAT_KEY];
        }
        if (!in_array($this->type, array_keys(self::MAPPING))) {
            throw new InvalidPreviewRequestException("Invalid Preview Request: Item type invalid");
        }
    }

    /**
     * Checks if the request includes a preview parameter
     * @param array $getParameter
     * @return bool
     */
    public static function isPreviewRequest(array $getParameter) {
        return isset($getParameter[self::PREVIEW_KEY]);
    }

    /**
     * Returns the object type of the requested preview item
     * @return string
     */
    public function getPreviewItemObjectType(): string
    {
        return self::MAPPING[$this->type];
    }

    /**
     * Returns the storage table name of the requested preview item
     * @return string
     */
    public function getPreviewItemTableName(): string
    {
        return $this->type;
    }

    /**
     * Returns the uid of the requested preview item
     * @return int
     */
    public function getPreviewItemUid(): int
    {
        return $this->uid;
    }

    /**
     * Returns the teaser format of the requested preview item
     * @return int
     */
    public function getTeaserFormat(): int
    {
        return $this->teaserFormat;
    }

}