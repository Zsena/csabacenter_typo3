<?php

namespace DigitalZombies\Center\Domain\Repository\PushNotification;

use Doctrine\DBAL\Query\Expression\CompositeExpression;
use DigitalZombies\Center\Domain\Model\PushNotification\CenterPushNotification;
use DigitalZombies\Center\Domain\Model\PushNotification\GlobalPushNotification;
use DigitalZombies\Center\Domain\Model\PushNotification\MultiCenterPushNotification;
use DigitalZombies\Center\Domain\Model\PushNotification\PushNotification;
use DigitalZombies\Center\Exception\InvalidPushNotificationSchema;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Extbase\Persistence\Generic\Typo3QuerySettings;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use SplObjectStorage;

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
 * Class AbstractPushNotificationRepository
 * @package DigitalZombies\Center\Domain\Repository\PushNotification
 */
class PushNotificationRepository extends Repository
{
    const TABLE_NAME = 'tx_center_domain_model_pushnotification';
    const TYPE_COLUMN_NAME = 'type';
    const TYPE_OBJECT_MAPPING = [
        CenterPushNotification::TYPE => CenterPushNotification::class,
        MultiCenterPushNotification::TYPE => MultiCenterPushNotification::class,
        GlobalPushNotification::TYPE => GlobalPushNotification::class
    ];

    /**
     * @var DataMapper
     */
    private $dataMapper;

    /**
     * initializes the object and sets some basic query stuff
     */
    public function initializeObject()
    {
        /** @var DataMapper dataMapper */
        $this->dataMapper = $this->objectManager->get(DataMapper::class);

        /** @var Typo3QuerySettings $querySettings */
        $querySettings = $this->objectManager->get(Typo3QuerySettings::class);

        $querySettings->setRespectSysLanguage(false);
        $querySettings->setStoragePageIds([GeneralUtility::_GP('id') ? (int)GeneralUtility::_GP('id') : 0]);
        $this->setDefaultQuerySettings($querySettings);
        $this->setDefaultOrderings(
            [
                'delivery_type' => QueryInterface::ORDER_ASCENDING,
                'actual_delivery_date' => QueryInterface::ORDER_ASCENDING,
                'push_date' => QueryInterface::ORDER_ASCENDING,
                'push_time' => QueryInterface::ORDER_ASCENDING,
            ]
        );
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getOne(int $id)
    {
        $query = $this->createQuery();
        $query->matching(
            $query->equals('uid', $id)
        );
        $query->setLimit(1);
        $result = $query->execute();
        if ($result instanceof QueryResultInterface) {
            return $result->getFirst();
        }
    }

    /**
     * @return array
     */
    public function getAllUnprocessed(): array
    {
        $query = $this->createQuery();
        return $query->matching(
            $query->equals('marked_for_delivery', 0)
        )->execute()->toArray();
    }

    /**
     * @return array
     */
    public function getAllPending(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalAnd(
                $query->equals('marked_for_delivery', 1),
                $query->equals('actual_delivery_date', null)
            )
        );
        return $query->execute()->toArray();
    }

    /**
     * @return array
     */
    public function getAllDelivered(): array
    {
        $query = $this->createQuery();
        $query->matching(
            $query->logicalNot(
                $query->equals('actual_delivery_date', null)
            )
        );
        return $query->execute()->toArray();
    }

    /**
     * @param QueryBuilder $queryBuilder
     * @return array
     */
    private function getIterationPayloadBaseWhereClause(QueryBuilder $queryBuilder): array
    {
        return [
            $queryBuilder->expr()->isNull('actual_delivery_date'),
            $queryBuilder->expr()->eq('marked_for_delivery', 1),
            $queryBuilder->expr()->eq('deleted', 0),
            $queryBuilder->expr()->eq('hidden', 0),
            $queryBuilder->expr()->orX(
                $queryBuilder->expr()->eq('delivery_type', PushNotification::STANDARD_DELIVERY),
                $queryBuilder->expr()->andX(
                    $queryBuilder->expr()->eq('delivery_type', PushNotification::TIME_BASED_DELIVERY),
                    $this->objectManager->get(
                        CompositeExpression::class,
                        CompositeExpression::TYPE_AND,
                        [
                            'NOW() >= DATE_ADD(DATE(push_date), INTERVAL push_time SECOND)'
                        ]
                    )
                )
            )
        ];
    }

    /**
     * @return int
     * @throws InvalidQueryException
     */
    public function getIterationPayloadCountForAllTypes(): int
    {
        /** @var QueryBuilder $query */
        $query = $this->objectManager
            ->get(ConnectionPool::class)
            ->getConnectionForTable(self::TABLE_NAME)
            ->createQueryBuilder();

        $countSelect = 'COUNT(uid)';
        $count = call_user_func_array(
            [
                $query->selectLiteral($countSelect)->from(self::TABLE_NAME),
                'where'
            ],
            $this->getIterationPayloadBaseWhereClause($query)
        )
            ->execute()
            ->fetchAll();

        if (!isset($count[0][$countSelect])) {
            throw new InvalidQueryException("count not set");
        }

        return $count[0][$countSelect];
    }

    /**
     * @param SplObjectStorage $payload
     * @return SplObjectStorage
     * @throws InvalidPushNotificationSchema
     */
    public function getIterationPayloadForAllTypes(SplObjectStorage $payload): SplObjectStorage
    {
        /** @var QueryBuilder $query */
        $query = $this->objectManager
            ->get(ConnectionPool::class)
            ->getConnectionForTable(self::TABLE_NAME)
            ->createQueryBuilder();

        $result = call_user_func_array(
            [
                $query->select('*')->from(self::TABLE_NAME),
                'where'
            ],
            $this->getIterationPayloadBaseWhereClause($query)
        )
            ->execute()
            ->fetchAll();

        foreach ($result as $row) {
            if (!isset($row[self::TYPE_COLUMN_NAME])
                || !isset(self::TYPE_OBJECT_MAPPING[$row[self::TYPE_COLUMN_NAME]])
            ) {
                throw new InvalidPushNotificationSchema(self::TYPE_COLUMN_NAME . " is not set or not mapped");
            }
            $targetObjectType = self::TYPE_OBJECT_MAPPING[$row[self::TYPE_COLUMN_NAME]];
            $resultObjectArray = $this->dataMapper->map($targetObjectType, [$row]);
            if (isset($resultObjectArray[0])) {
                $payload->attach($resultObjectArray[0]);
            }
        }
        return $payload;
    }
}
