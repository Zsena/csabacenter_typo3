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
class Table extends AbstractEntity
{

    /**
     * @var string
     */
    protected $title = '';

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\DigitalZombies\Center\Domain\Model\Project\TableRow>
     */
    protected $tableRows = null;

    public function __construct()
    {
        $this->tableRows = new ObjectStorage();
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
     * @return ObjectStorage
     */
    public function getTableRows()
    {
        return $this->tableRows;
    }

    /**
     * @param ObjectStorage $tableRows
     */
    public function setTableRows(ObjectStorage $tableRows)
    {
        $this->tableRows = $tableRows;
    }
}
