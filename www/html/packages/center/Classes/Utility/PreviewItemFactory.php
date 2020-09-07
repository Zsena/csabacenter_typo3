<?php

namespace DigitalZombies\Center\Utility;

use DigitalZombies\Center\Domain\Model\RecordBase;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;

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
 * Class PreviewItemFactory
 * @package DigitalZombies\Center\Utility
 */
class PreviewItemFactory
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var DataMapper
     */
    private $dataMapper;

    /**
     * PreviewItemFactory constructor.
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
        $this->dataMapper = $this->objectManager->get(DataMapper::class);
    }

    /**
     * @param PreviewRequest $previewRequest
     * @return RecordBase | null
     */
    public function getPreviewItem(PreviewRequest $previewRequest)
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $this->objectManager->get(ConnectionPool::class)
            ->getQueryBuilderForTable($previewRequest->getPreviewItemTableName());

        $queryBuilder->getRestrictions()->removeAll();
        $rawResult = $queryBuilder->select('*')
            ->from($previewRequest->getPreviewItemTableName())
            ->where(
                $queryBuilder->expr()->eq(
                    'uid',
                    $queryBuilder->createNamedParameter($previewRequest->getPreviewItemUid(), \PDO::PARAM_INT)
                ))->execute()->fetchAll();

        if ($rawResult > 0) {
            /** @var RecordBase $mappedRecord */
            $mappedRecordArray = $this->dataMapper->map($previewRequest->getPreviewItemObjectType(), $rawResult);
            if ($mappedRecordArray && $mappedRecordArray[0] instanceof RecordBase) {
                $previewItem = $this->preparePreviewItem($previewRequest, $mappedRecordArray[0]);
                return $previewItem;
            }
        }
    }

    /**
     * @param PreviewRequest $previewRequest
     * @param RecordBase $previewItem
     * @return RecordBase
     */
    private function preparePreviewItem(PreviewRequest $previewRequest, RecordBase $previewItem)
    {
        $previewItem->setIsPreview(true);
        $previewItem->setTableName($previewRequest->getPreviewItemTableName());
        $previewItem->setTeaserFormat($previewRequest->getTeaserFormat());
        return $previewItem;
    }
}
