<?php

namespace DigitalZombies\Center\Domain\Repository\Records;

use DigitalZombies\Center\Constants\HideInApp;
use DigitalZombies\Center\Mapper\RecordBaseDataMapper;
use TYPO3\CMS\Extbase\Persistence\Repository;
use DigitalZombies\Center\Domain\Model\Records\Service;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;


/**
 * The repository for service
 */
class ServiceRepository extends Repository
{

    /**
     * Find service that have openings that are different to center openings
     *
     * @param int $uid - id of a page record
     * @return array
     */
    public function findServiceWithExtraOpenings($uid)
    {

        /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_center_domain_model_records_service');

        $row = $queryBuilder->selectLiteral('DISTINCT tx_center_domain_model_records_service.*')
            ->from('tx_center_domain_model_records_service')
            ->where($queryBuilder->expr()->eq('center', $uid))
            ->andWhere($queryBuilder->expr()->gt('weekly_schedule', 0))
            ->andWhere($queryBuilder->expr()->eq('service_247', 0))
            ->execute()
            ->fetchAll();

        if (!is_array($row)) {
            throw new \RuntimeException('Could not find row with UID "' . $uid . '" in table "tx_center_domain_model_records_service"', 1314354065);
        }
        /** @var RecordBaseDataMapper $configurationBuilder */
        $dataMapper = $this->objectManager->get(RecordBaseDataMapper::class);
        $services = $dataMapper->map(Service::class, $row, Service::TABLE_NAME);
        return $services;

    }

    /**
     * Find service that have special openings
     *
     * @param int $uid - id of a page record
     * @return array
     */
    public function findServiceWithSpecialOpenings($uid)
    {

        /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_center_domain_model_records_service');

        $row = $queryBuilder
            ->selectLiteral('DISTINCT tx_center_domain_model_records_service.*')
            ->from('tx_center_domain_model_records_service')
            ->innerJoin(
                'tx_center_domain_model_records_service',
                'tx_center_domain_model_openinghours_yearlyschedule',
                'yearlyschedule',
					$queryBuilder->expr()->andX(
						$queryBuilder->expr()->eq('yearlyschedule.parent', $queryBuilder->quoteIdentifier('tx_center_domain_model_records_service.uid')),
						$queryBuilder->expr()->eq('yearlyschedule.parent_table', $queryBuilder->createNamedParameter('tx_center_domain_model_records_service'))
					)
            )
            ->where($queryBuilder->expr()->eq('center', $uid))
            ->andWhere($queryBuilder->expr()->gt('yearly_schedule', 0))
            ->andWhere($queryBuilder->expr()->eq('year', date("Y")))
            ->andWhere($queryBuilder->expr()->gt('special_closing_days', 0))
            ->execute()
            ->fetchAll();

        if (!is_array($row)) {
            throw new \RuntimeException('Could not find row with UID "' . $uid . '" in table "tx_center_domain_model_records_service"', 1314354065);
        }
        /** @var RecordBaseDataMapper $configurationBuilder */
        $dataMapper = $this->objectManager->get(RecordBaseDataMapper::class);
        $services = $dataMapper->map(Service::class, $row, Service::TABLE_NAME);
        return $services;
    }


    /**
     * Find service that have special openings
     *
     * @param int $uid - id of a page record
     * @return array
     */
    public function findServiceWith247($uid)
    {

        /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_center_domain_model_records_service');

        $row = $queryBuilder
            ->selectLiteral('DISTINCT tx_center_domain_model_records_service.*')
            ->from('tx_center_domain_model_records_service')
            ->where($queryBuilder->expr()->eq('center', $uid))
            ->andWhere($queryBuilder->expr()->eq('service_247', 1))
            ->andWhere($queryBuilder->expr()->in('sys_language_uid', [-1, $GLOBALS['TSFE']->sys_language_uid]))
            ->execute()
            ->fetchAll();

        if (!is_array($row)) {
            throw new \RuntimeException('Could not find row with UID "' . $uid . '" in table "tx_center_domain_model_records_service"', 1314354065);
        }
        /** @var RecordBaseDataMapper $configurationBuilder */
        $dataMapper = $this->objectManager->get(RecordBaseDataMapper::class);
        $services = $dataMapper->map(Service::class, $row, Service::TABLE_NAME);
        return $services;
    }

	/**
	 * @param $centerId
	 * @return array
	 */
	public function listAllForCenter($centerId)
	{
		$service = [];
		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('tx_center_domain_model_records_service');

		$records = $queryBuilder->select('service.*')
			->from('tx_center_domain_model_records_service', 'service')
			->leftJoin('service',
				'tx_center_domain_model_records_center_mm',
				'centers',
				"centers.uid_foreign = service.uid AND centers.tablenames = 'tx_center_domain_model_records_service'")
			->orWhere($queryBuilder->expr()->eq('centers.uid_local', $centerId),
				($queryBuilder->expr()->eq('service.center', $centerId)))
			->andWhere($queryBuilder->expr()->in('service.hide_in_app',
				[HideInApp::NO_RESTRICTION, HideInApp::ONLY_IN_APP]))
			->andWhere($queryBuilder->expr()->eq('sys_language_uid', 0))
			->groupBy('service.uid')
			->execute()
			->fetchAll();

		$resultCount = count($records);

		if ($resultCount > 0) {
			/** @var RecordBaseDataMapper $dataMapper */
			$dataMapper = $this->objectManager->get(RecordBaseDataMapper::class);

			$service = $dataMapper->map(Service::class, $records, Service::TABLE_NAME);
		}


		return $service;
	}
}
