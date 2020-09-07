<?php

namespace DigitalZombies\Center\Domain\Repository\Records;

use DigitalZombies\Center\Constants\HideInApp;
use DigitalZombies\Center\Domain\Model\Records\Event;
use DigitalZombies\Center\Domain\Repository\RecordBaseRepository;
use DigitalZombies\Center\Mapper\RecordBaseDataMapper;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;


/**
 * The repository for event
 */
class EventRepository extends RecordBaseRepository
{

    /**
     * @param $centerId
     * @return array
     */
    public function listAllForCenter($centerId)
    {
        $events = [];
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_center_domain_model_records_event');

        $records = $queryBuilder->select('event.*')
            ->from('tx_center_domain_model_records_event', 'event')
            ->leftJoin('event',
                'tx_center_domain_model_records_center_mm',
                'centers',
                "centers.uid_foreign = event.uid AND centers.tablenames = 'tx_center_domain_model_records_event'")
            ->orWhere($queryBuilder->expr()->eq('centers.uid_local', $centerId),
                ($queryBuilder->expr()->eq('event.center', $centerId)))
            ->andWhere($queryBuilder->expr()->in('event.hide_in_app',
                [HideInApp::NO_RESTRICTION, HideInApp::ONLY_IN_APP]))
            ->andWhere($queryBuilder->expr()->eq('sys_language_uid', 0))
            ->groupBy('event.uid')
            ->execute()
            ->fetchAll();

        $resultCount = count($records);

        if ($resultCount > 0) {
            /** @var RecordBaseDataMapper $dataMapper */
            $dataMapper = $this->objectManager->get(RecordBaseDataMapper::class);

            $events = $dataMapper->map(Event::class, $records, Event::TABLE_NAME);
        }


        return $events;
    }

}