<?php

namespace DigitalZombies\Center\Domain\Repository\Interest;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * The repository for record base
 */
class InterestRepository extends Repository
{
	/**
	 * @param array $interests
	 * @param int $userId
	 * @return int
	 */
	public function removeInterestsForUser($interests, $userId) {
		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('tx_center_domain_model_interest_interest_record_mm');
		$queryBuilder->getRestrictions()->removeAll();
		return $queryBuilder->delete('tx_center_domain_model_interest_interest_record_mm')
			->where($queryBuilder->expr()->eq('tablenames', $queryBuilder->quote('fe_users')))
			->andWhere($queryBuilder->expr()->eq('fieldname', $queryBuilder->quote('interests')))
			->andWhere($queryBuilder->expr()->eq('uid_foreign', (int)$userId))
			->andWhere($queryBuilder->expr()->in('uid_local', $interests))
			->execute();

	}


	/**
	 * @param array $interests
	 * @param int $userId
	 * @return int
	 */
	public function addInterestsForUser($interests, $userId) {
		$result = 0;
		foreach ($interests as $interest) {
			/** @var QueryBuilder $queryBuilder */
			$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
				->getQueryBuilderForTable('tx_center_domain_model_interest_interest_record_mm');
			$queryBuilder->getRestrictions()->removeAll();

			$results = $queryBuilder->select('tx_center_domain_model_interest_interest_record_mm.uid_local')
				->from('tx_center_domain_model_interest_interest_record_mm')
				->where($queryBuilder->expr()->eq('tablenames', $queryBuilder->quote('fe_users')))
				->andWhere($queryBuilder->expr()->eq('fieldname', $queryBuilder->quote('interests')))
				->andWhere($queryBuilder->expr()->eq('uid_foreign', (int)$userId))
				->andWhere($queryBuilder->expr()->eq('uid_local', (int)$interest))
				->execute()
				->fetchAll();

			if(count($results) == 0) {
				$values = [
					'tablenames' => 'fe_users',
					'fieldname' => 'interests',
					'uid_foreign' => $userId,
					'uid_local' => $interest
				];

				$result += $queryBuilder->insert('tx_center_domain_model_interest_interest_record_mm')
					->values($values)
					->execute();
			}
		}

		return $result;
	}

	/**
	 * @param int $userId
	 */
	public function updateUserInterestCount($userId) {
		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('tx_center_domain_model_interest_interest_record_mm');
		$queryBuilder->getRestrictions()->removeAll();

		$results = $queryBuilder->select('tx_center_domain_model_interest_interest_record_mm.uid_local')
			->from('tx_center_domain_model_interest_interest_record_mm')
			->where($queryBuilder->expr()->eq('tablenames', $queryBuilder->quote('fe_users')))
			->andWhere($queryBuilder->expr()->eq('fieldname', $queryBuilder->quote('interests')))
			->andWhere($queryBuilder->expr()->eq('uid_foreign', (int)$userId))
			->execute()
			->fetchAll();

		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('fe_users');
		$queryBuilder->getRestrictions()->removeAll();

		 $queryBuilder->update('fe_users')
			 ->from('fe_users')
			->where($queryBuilder->expr()->eq('uid', (int)$userId))
			->set('interests', count($results))
			->execute();
	}


	/**
	 * @param int $userId
	 * @return array
	 */
	public function findUserInterests($userId) {
		$interests = [];
		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('tx_center_domain_model_interest_interest_record_mm');
		$queryBuilder->getRestrictions()->removeAll();

		$results = $queryBuilder->select('tx_center_domain_model_interest_interest_record_mm.uid_local AS uid')
			->from('tx_center_domain_model_interest_interest_record_mm')
			->where($queryBuilder->expr()->eq('tablenames', $queryBuilder->quote('fe_users')))
			->andWhere($queryBuilder->expr()->eq('fieldname', $queryBuilder->quote('interests')))
			->andWhere($queryBuilder->expr()->eq('uid_foreign', (int)$userId))
			->execute()
			->fetchAll();

		foreach ($results as $result) {
			$interests[] = $result['uid'];
		}

		return $interests;
	}
}