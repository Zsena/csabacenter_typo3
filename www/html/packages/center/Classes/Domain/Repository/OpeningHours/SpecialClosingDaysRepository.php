<?php

namespace DigitalZombies\Center\Domain\Repository\OpeningHours;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Repository;


/**
 * The repository for Special closing days
 */
class SpecialClosingDaysRepository extends Repository
{

    /**
     * Returns all center not respecting the storage pid settings
     *
     * @return int
     */
    public function deleteClosingDaysInLastYear()
    {
        $lastYear = (int)date('Y') - 1;
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_center_domain_model_openinghours_specialclosingday');

        $result = $queryBuilder->delete('tx_center_domain_model_openinghours_specialclosingday')
            ->from('tx_center_domain_model_openinghours_specialclosingday')
            ->where('FROM_UNIXTIME(closing_day, \'%Y\') = ?')
            ->setParameter(0, $lastYear)
            ->execute();

        return $result;
    }

    /**
     * @param int $days
     * @return array
     */
    public function findOpenings($days = 7)
    {
        $year = date("Y");
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_center_domain_model_center_center');

        $result = $queryBuilder->select('*')
            ->from('tx_center_domain_model_center_center')
            ->leftJoin(
                'tx_center_domain_model_center_center',
                'tx_center_domain_model_openinghours_yearlyschedule',
                'opening',
				$queryBuilder->expr()->andX(
					$queryBuilder->expr()->eq('opening.parent', $queryBuilder->quoteIdentifier('tx_center_domain_model_center_center.uid')),
					$queryBuilder->expr()->eq('opening.parent_table', $queryBuilder->createNamedParameter('tx_center_domain_model_center_center'))
				)
            )
            ->leftJoin(
                'opening',
                'tx_center_domain_model_openinghours_specialclosingday',
                'final',
                $queryBuilder->expr()->eq('final.schedule', $queryBuilder->quoteIdentifier('opening.uid'))
            )
            ->where('final.closing_day <' . (time() + $days * 86400))
            ->andWhere(
                'final.closing_day >' . time()
            )
            ->andWhere(
                'opening.year = ' . $year
            )
            ->orderBy('center_name', 'DESC')
            ->execute()
            ->fetchAll();

        return $result;
    }


    /**
     * @param int $uid
     * @return array
     */
    public function findShopSpecialClosingDays($uid)
    {
		$result = [];
    	if($uid) {
			$year = date("Y");
			/** @var QueryBuilder $queryBuilder */
			$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
				->getQueryBuilderForTable('pages');

			$result = $queryBuilder->select('*')
				->from('pages')
				->leftJoin(
					'pages',
					'tx_center_domain_model_openinghours_yearlyschedule',
					'opening',
					$queryBuilder->expr()->andX(
						$queryBuilder->expr()->eq('opening.parent', $queryBuilder->quoteIdentifier('pages.uid'))
					)
				)
				->leftJoin(
					'opening',
					'tx_center_domain_model_openinghours_specialclosingday',
					'final',
					$queryBuilder->expr()->eq('final.schedule', $queryBuilder->quoteIdentifier('opening.uid'))
				)
				->where('final.closing_day <' . (time() + 364 * 86400))
				->andWhere(
					'(final.closing_day + 86400) >' . time()
				)
				->andWhere(
					'opening.pid =' . $uid
				)
				->andWhere(
					'opening.year = ' . $year
				)
				->orderBy('final.closing_day', 'DESC')
				->execute()
				->fetchAll();
		}
        return $result;
    }



}