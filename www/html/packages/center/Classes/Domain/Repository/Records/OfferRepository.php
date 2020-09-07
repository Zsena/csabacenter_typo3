<?php

namespace DigitalZombies\Center\Domain\Repository\Records;

use DigitalZombies\Center\Constants\HideInApp;
use DigitalZombies\Center\Domain\Model\Records\Offer;
use DigitalZombies\Center\Domain\Repository\RecordBaseRepository;
use DigitalZombies\Center\Mapper\RecordBaseDataMapper;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;


/**
 * The repository for job
 */
class OfferRepository extends RecordBaseRepository
{

    /**
     * @param $centerId
     * @return array
     */
    public function listAllForCenter($centerId)
    {
        $offer = [];
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_center_domain_model_records_offer');

        $records = $queryBuilder->select('offer.*')
            ->from('tx_center_domain_model_records_offer', 'offer')
            ->leftJoin('offer',
                'tx_center_domain_model_records_center_mm',
                'centers',
                "centers.uid_foreign = offer.uid AND centers.tablenames = 'tx_center_domain_model_records_offer'")
            ->orWhere($queryBuilder->expr()->eq('centers.uid_local', $centerId),
                ($queryBuilder->expr()->eq('offer.center', $centerId)))
            ->andWhere($queryBuilder->expr()->in('offer.hide_in_app',
                [HideInApp::NO_RESTRICTION, HideInApp::ONLY_IN_APP]))
            ->andWhere($queryBuilder->expr()->eq('sys_language_uid', 0))
            ->groupBy('offer.uid')
            ->execute()
            ->fetchAll();

        $resultCount = count($records);

        if ($resultCount > 0) {
            /** @var RecordBaseDataMapper $dataMapper */
            $dataMapper = $this->objectManager->get(RecordBaseDataMapper::class);

            $offer = $dataMapper->map(Offer::class, $records, Offer::TABLE_NAME);
        }


        return $offer;
    }

}