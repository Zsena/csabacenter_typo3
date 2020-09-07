<?php
namespace DigitalZombies\Center\Domain\Repository\Misc;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * The repository for offers
 */
class OfferRepository extends Repository
{
    /**
     * Updates old offers and sets deleted to 1
     * @param int $period
     * @return int
     */
    public function deleteOldOffers($period)
    {
        $days = $period * 24 * 60 * 60;
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_center_domain_model_records_offer');
        $queryBuilder->getRestrictions()->removeAll();
        return $queryBuilder->update('tx_center_domain_model_records_offer')
            ->where('tx_center_domain_model_records_offer.endtime +' . $days . '< UNIX_TIMESTAMP(NOW())')
            ->andWhere('tx_center_domain_model_records_offer.endtime !=0')
            ->set('deleted', '1')
            ->execute();
    }
}