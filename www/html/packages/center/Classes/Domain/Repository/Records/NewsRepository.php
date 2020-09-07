<?php

namespace DigitalZombies\Center\Domain\Repository\Records;

use DigitalZombies\Center\Constants\HideInApp;
use DigitalZombies\Center\Domain\Model\Records\News;
use DigitalZombies\Center\Domain\Repository\RecordBaseRepository;
use DigitalZombies\Center\Mapper\RecordBaseDataMapper;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;


/**
 * The repository for job
 */
class NewsRepository extends RecordBaseRepository
{

    /**
     * @param $centerId
     * @return array
     */
    public function listAllForCenter($centerId)
    {
        $news = [];
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_center_domain_model_records_news');

        $records = $queryBuilder->select('news.*')
            ->from('tx_center_domain_model_records_news', 'news')
            ->leftJoin('news',
                'tx_center_domain_model_records_center_mm',
                'centers',
                "centers.uid_foreign = news.uid AND centers.tablenames = 'tx_center_domain_model_records_news'")
            ->orWhere($queryBuilder->expr()->eq('centers.uid_local', $centerId),
                ($queryBuilder->expr()->eq('news.center', $centerId)))
            ->andWhere($queryBuilder->expr()->in('news.hide_in_app',
                [HideInApp::NO_RESTRICTION, HideInApp::ONLY_IN_APP]))
            ->andWhere($queryBuilder->expr()->eq('sys_language_uid', 0))
            ->groupBy('news.uid')
            ->execute()
            ->fetchAll();

        $resultCount = count($records);

        if ($resultCount > 0) {
            /** @var RecordBaseDataMapper $dataMapper */
            $dataMapper = $this->objectManager->get(RecordBaseDataMapper::class);

            $news = $dataMapper->map(News::class, $records, News::TABLE_NAME);
        }


        return $news;
    }

}