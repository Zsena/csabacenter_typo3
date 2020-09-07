<?php

namespace DigitalZombies\Center\Domain\Repository\Bookmarks;

use Doctrine\DBAL\Query\QueryBuilder;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Repository;

use DigitalZombies\Center\Domain\Model\Bookmarks\Bookmarks;

class BookmarksRepository extends Repository
{
	/**
	 * @param $userId
	 * @param $itemId
	 * @param $centerId
	 * @param $tablename
	 */
	public function storeBookmark($userId, $itemId, $endtime, $centerId, $tablename)
	{
		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('tx_center_domain_model_bookmarks');

		$queryBuilder->insert('tx_center_domain_model_bookmarks')
			->values([
					'user_id' => $userId,
					'center_id' => $centerId,
					'item_id' => $itemId,
					'tablename' => $tablename,
					'bookmark_date' => time(),
					'endtime' => $endtime,
				]
			)->execute();
	}

	/**
	 * @param $userId
	 * @param $itemId
	 * @param $centerId
	 * @param $tablename
	 * @return int
	 */
	public function getBookmarkByUserItemIds($userId, $itemId, $centerId)
	{
		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('tx_center_domain_model_bookmarks');
		$bookmark = $queryBuilder->select('*')
			->from('tx_center_domain_model_bookmarks')
			->where('user_id = ' . $userId)
			->andWhere('item_id = ' . $itemId)
			->andWhere('center_id = ' . $centerId)
			->execute()
			->fetchAll();

		return (int)count($bookmark);
	}

	public function getBookmarkByUserIdAndCenterId($userId, $centerId)
	{
		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('tx_center_domain_model_bookmarks');
		$bookmark = $queryBuilder->select('*')
			->from('tx_center_domain_model_bookmarks')
			->where('user_id = ' . $userId)
			->andWhere('center_id = ' . $centerId)
			->execute()
			->fetchAll();

		return $bookmark;
	}

	public function deleteBookmark($userId, $itemId, $centerId)
	{
		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('tx_center_domain_model_bookmarks');

		$result = $queryBuilder->delete('tx_center_domain_model_bookmarks')
			->where('user_id = "' . $userId . '"')
			->andWhere('item_id = "' . $itemId . '"')
			->andWhere('center_id = "' . $centerId . '"')
			->execute();

		return $result;
	}

	public function deleteOldBookmarks($period)
	{
		$days = $period * 24 * 60 * 60;

		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('tx_center_domain_model_bookmarks');
		$queryBuilder->getRestrictions()->removeAll();

		$result = $queryBuilder->delete('tx_center_domain_model_bookmarks')
			->where('tx_center_domain_model_bookmarks.endtime +' . $days . '< UNIX_TIMESTAMP(NOW())')
			->andWhere('tx_center_domain_model_bookmarks.endtime !=0')
			->execute();

		return $result;
	}
}
