<?php
namespace DigitalZombies\Center\Domain\Repository\Center;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Repository;


/**
 * The repository for CenterLevelPosition
 */
class CenterLevelPositionRepository extends Repository {

	/**
	 * Returns all center not respecting the storage pid settings
	 *
	 * @param $uids array
	 * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findByUids($uids)
	{
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(false);
		$query->matching($query->in('uid', $uids));

		return $query->execute();
	}

	/**
	 * Returns all center not respecting the storage pid settings
	 *
	 * @param int $levelUid
	 * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findByCenterLevel($levelUid)
	{
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(false);
		$query->matching($query->equals('center_level', $levelUid));

		return $query->execute();
	}

	/**
	 * Returns all center not respecting the storage pid settings
	 *
	 * @param int $sysFileUid
	 * @return int
	 */
	public function svgProcessed($sysFileUid)
	{
		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('sys_file');
		$queryBuilder->getRestrictions()->removeAll();
		$result = $queryBuilder->update('sys_file')
			->where($queryBuilder->expr()->eq('uid', $sysFileUid))
			->set('tx_center_svg_processed', 1)
			->execute();

		return $result;
	}
}