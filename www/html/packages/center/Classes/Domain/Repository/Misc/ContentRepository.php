<?php
/**
 * Created by PhpStorm.
 * User: miltzd
 * Date: 14.05.2018
 * Time: 10:26
 */

namespace DigitalZombies\Center\Domain\Repository\Misc;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Repository;

class ContentRepository extends Repository
{
	/**
	 * Finds tags with a specifid type in a specified center
	 * @param int $language
	 * @param int $uid
	 * @return array
	 */
	public function findTabLabel($language, $uid)
	{
		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('tt_content');
		$queryBuilder->getRestrictions()->removeAll();
		// If no translation available get original record
		if (!$language) {
			$result = $queryBuilder->select('pi_flexform')
				->from('tt_content')
				->where($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid)))
				->execute()
				->fetchAll();
		} else {
			// If translation is available get translated record
			$result = $queryBuilder->select('pi_flexform')
				->from('tt_content')
				->where($queryBuilder->expr()->eq('l18n_parent', $queryBuilder->createNamedParameter($uid)))
				->andWhere('sys_language_uid=' . $language)
				->execute()
				->fetchAll();
		}
		return $result;
	}

	public function findContentByPid($pid)
	{
		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('tt_content');
		$queryBuilder->getRestrictions()->removeAll();

		$result = $queryBuilder->select('bodytext')
			->from('tt_content')
			->where($queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($pid)))#
			->andWhere('deleted=0')
			->andWhere('hidden=0')
			->execute()
			->fetchAll();

		return $result[0];
	}

    /**
     * @param $pid
     * @return array
     */
    public function findByPid($pid)
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll();

        $results = $queryBuilder->select('*')
            ->from('tt_content')
            ->where($queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($pid)))
            ->andWhere('deleted=0')
            ->andWhere('hidden=0')
            ->andWhere('sys_language_uid IN (-1,0)')
            ->andWhere($queryBuilder->expr()->orX('starttime = 0', "starttime <= UNIX_TIMESTAMP()"))
            ->andWhere($queryBuilder->expr()->orX('endtime = 0', "endtime >= UNIX_TIMESTAMP()"))
            ->execute()
            ->fetchAll();

        return $results;
    }

    /**
     * @param int $uid
     * @return array
     */
    public function findByUid($uid)
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tt_content');
        $queryBuilder->getRestrictions()->removeAll();

        $result = $queryBuilder->select('*')
            ->from('tt_content')
            ->where($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid)))
            ->andWhere('deleted=0')
            ->andWhere('hidden=0')
            ->andWhere($queryBuilder->expr()->orX('starttime = 0', "starttime <= UNIX_TIMESTAMP()"))
            ->andWhere($queryBuilder->expr()->orX('endtime = 0', "endtime >= UNIX_TIMESTAMP()"))
            ->execute()
            ->fetchAll();

        return $result[0];
    }

	public function findPiFlexformByUid($uid)
	{
		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('tt_content');
		$queryBuilder->getRestrictions()->removeAll();
		// If no translation available get original record

		$result = $queryBuilder->select('pi_flexform')
			->from('tt_content')
			->where($queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($uid)))
			->execute()
			->fetchAll();

		return $result[0]['pi_flexform'];
	}

	public function findStageOverviewOnPage($pid)
	{
		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('tt_content');
		$queryBuilder->getRestrictions()->removeAll();
		// If no translation available get original record

		$result = $queryBuilder->select('uid', 'pi_flexform')
			->from('tt_content')
			->where($queryBuilder->expr()->eq('pid', $queryBuilder->createNamedParameter($pid)))
			->andWhere($queryBuilder->expr()->eq('colPos', 1))
			->andWhere($queryBuilder->expr()->eq('CType', $queryBuilder->createNamedParameter('providerece_stageoverview')))
			->andWhere($queryBuilder->expr()->eq('sys_language_uid', $GLOBALS['TSFE']->sys_language_uid))
			->execute()
			->fetchAll();


		if (count($result) > 0) {
			return $result[0];
		} else {
			return [];
		}
	}
}
