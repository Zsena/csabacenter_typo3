<?php
namespace DigitalZombies\Center\Domain\Repository\Center;

use Doctrine\DBAL\Query\QueryBuilder;
use DigitalZombies\Center\Domain\Model\Center\Center;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * The repository for center
 */
class CenterRepository extends Repository {

	/**
	 * Finds a center based on a page ID.
	 *
	 * @param int $uid - id of a page record
	 * @return \DigitalZombies\Center\Domain\Model\Center\Center
	 */
	public function findByPageId($uid)
	{
		$center = null;

		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(false);
		$query->matching($query->equals('page_id', $uid));

		/** @var \DigitalZombies\Center\Domain\Model\Center\Center $center */
		$center = $query->execute()->getFirst();

		return $center;
	}

	/**
	 * Finds a center based on a domain name.
	 *
	 * @return array
	 */
	public function findByDomainName()
	{
		$center = null;
		$serverName = $_SERVER['SERVER_NAME'];
		$serverNameWithPort = $serverName . ($_SERVER['SERVER_PORT'] ? ":" . $_SERVER['SERVER_PORT'] : '');

		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('tx_center_domain_model_center_center');

		$result = $queryBuilder->select('tx_center_domain_model_center_center.*')
			->from('tx_center_domain_model_center_center')
			->leftJoin(
				'tx_center_domain_model_center_center',
				'pages',
				'pages',
				$queryBuilder->expr()->andX(
					$queryBuilder->expr()->eq('pages.uid', $queryBuilder->quoteIdentifier('tx_center_domain_model_center_center.page_id'))
				)

			)
			->leftJoin(
				'pages',
				'sys_domain',
				'domain',
				$queryBuilder->expr()->andX(
					$queryBuilder->expr()->eq('domain.pid', $queryBuilder->quoteIdentifier('pages.uid'))
				)

			)
			->where($queryBuilder->expr()->orX(
				$queryBuilder->expr()->eq('domain.domainName', $queryBuilder->createNamedParameter($serverName)),
				$queryBuilder->expr()->eq('domain.domainName', $queryBuilder->createNamedParameter($serverNameWithPort))))
			->andWhere($queryBuilder->expr()->eq('tx_center_domain_model_center_center.sys_language_uid', 0))
			->execute()
			->fetchAll();

		$resultCount = count($result);

		if ($resultCount === 1) {
			$center = $result[0];
		}

		return $center;
	}

	/**
	 * Returns all center not respecting the storage pid settings
	 *
	 * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findAll()
	{
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(false);
        $query->setOrderings([
            'center_name' => QueryInterface::ORDER_ASCENDING
        ]);
		return $query->execute();
	}

    /**
     * @return array
     */
    public function getAllWithApp() {
        $query = $this->createQuery();

        $query->getQuerySettings()->setRespectStoragePage(false);
        $query->matching(
            $query->logicalOr(
                $query->logicalAnd(
                    $query->logicalNot(
                        $query->equals('pushServerIosTopic', '')
                    ),
                    $query->logicalNot(
                        $query->equals('pushServerIosAuthorizationKey', '')
                    )
                ),
                $query->logicalAnd(
                    $query->logicalNot(
                        $query->equals('pushServerAndroidTopic', '')
                    ),
                    $query->logicalNot(
                        $query->equals('pushServerAndroidAuthorizationKey', '')
                    )
                )
            )
        );

        $query->setOrderings([
            'center_name' => QueryInterface::ORDER_ASCENDING
        ]);
        return $query->execute()->toArray();
    }

    /**
     * Returns all center not respecting the storage pid settings
     *
     * @param int $uid - id of a page record
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findCenterDailyHours($uid)
    {
    	/** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_center_domain_model_center_center');

        $result = $queryBuilder->select('opening.day_of_week', 'opening.from', 'opening.till', 'opening.closed', 'opening.from_ext', 'opening.till_ext')
            ->from('tx_center_domain_model_center_center')
            ->leftJoin(
                'tx_center_domain_model_center_center',
                'tx_center_domain_model_openinghours_dailyhours',
                'opening',
                $queryBuilder->expr()->andX(
					$queryBuilder->expr()->eq('opening.parent', $queryBuilder->quoteIdentifier('tx_center_domain_model_center_center.uid')),
					$queryBuilder->expr()->eq('opening.parent_table', $queryBuilder->createNamedParameter('tx_center_domain_model_center_center'))
				)

            )
            ->where('tx_center_domain_model_center_center.uid =' . (int)$uid)
			->orderBy('opening.sorting', 'ASC')
            ->execute()
            ->fetchAll();
        return $result;
    }


}