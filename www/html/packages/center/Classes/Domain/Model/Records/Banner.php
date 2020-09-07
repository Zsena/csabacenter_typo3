<?php

namespace DigitalZombies\Center\Domain\Model\Records;

use DigitalZombies\Center\Domain\Model\RecordBase;

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
class Banner extends RecordBase
{

    /**
     * @var string
     */
    protected $partialName = 'Banner';

    const TYPE = 'tx_center_domain_model_records_banner';

    /**
     * Table name in the database
     */
    const TABLE_NAME = self::TYPE;

    /**
     * link
     *
     * @var string
     */
    protected $link = '';

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
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link)
    {
        $this->link = $link;
    }
}
