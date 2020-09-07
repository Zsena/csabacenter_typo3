<?php
namespace DigitalZombies\Center\Domain\Repository\Misc;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * The repository for news
 */
class NewsRepository extends Repository
{
    /**
     * Updates old news and sets deleted to 1
     * @param int $period
     * @return int
     */
    public function deleteOldNews($period)
    {
        $days = $period * 24 * 60 * 60;
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_center_domain_model_records_news');
        $queryBuilder->getRestrictions()->removeAll();
        return $queryBuilder->update('tx_center_domain_model_records_news')
            ->where('tx_center_domain_model_records_news.endtime +' . $days . '< UNIX_TIMESTAMP(NOW())')
            ->andWhere('tx_center_domain_model_records_news.endtime !=0')
            ->set('deleted', '1')
            ->execute();
    }
}