<?php
namespace DigitalZombies\Center\Domain\Repository\Misc;

use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class TagRepository extends Repository
{
	/**
	 * Finds used tags for a specified table.
	 * @param int $pageUid
	 * @param string $fieldName
	 * @return array
	 */
	public function findTagsForTable($pageUid, $fieldName, $tableName = 'pages')
	{
		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('tx_center_domain_model_misc_tag_record_mm');
		$queryBuilder->getRestrictions()->removeAll();
		$results = $queryBuilder->select('uid_local')
			->from('tx_center_domain_model_misc_tag_record_mm')
			->where($queryBuilder->expr()->eq('tablenames', $queryBuilder->createNamedParameter($tableName)))
			->andWhere($queryBuilder->expr()->eq('fieldname', $queryBuilder->createNamedParameter($fieldName)))
			->andWhere($queryBuilder->expr()->eq('uid_foreign',$queryBuilder->createNamedParameter($pageUid)))
			->execute()
			->fetchAll(\PDO::FETCH_COLUMN);

		return $results;
	}

	/**
	 * Finds tags with a specifid type in a specified center
	 *
	 * @param string $type
	 * @return array
	 */
	public function findTagsByType($type)
	{
		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('tx_center_domain_model_misc_tag');
		$results = $queryBuilder->select('*')
			->from('tx_center_domain_model_misc_tag')
			->andWhere($queryBuilder->expr()->eq('type', $queryBuilder->createNamedParameter($type)))
			->execute()
			->fetchAll();

		return $results;
	}

	/**
	 * Finds tags by uids
	 *
	 * @param array $uids
	 * @return array
	 */
	public function findTagsByUids($uids)
	{
		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('tx_center_domain_model_misc_tag');
		$results = $queryBuilder->select('*')
			->from('tx_center_domain_model_misc_tag')
			->where($queryBuilder->expr()->in('uid', $queryBuilder->createNamedParameter($uids)))
			->execute()
			->fetchAll();

		return $results;
	}
}