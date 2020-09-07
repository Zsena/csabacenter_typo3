<?php
namespace DigitalZombies\Center\Domain\Repository\Shop;

use DigitalZombies\Center\Domain\Model\Shop\Gastro;
use DigitalZombies\Center\Domain\Model\Shop\Shop;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Extbase\Persistence\Repository;


/**
 * The repository for shop
 */
class ShopRepository extends Repository
{

    /**
     * Finds a center based on a page ID.
     *
     * @param int $uid - id of a page record
     * @return \DigitalZombies\Center\Domain\Model\Shop\Shop
     */
    public function findByUid($uid)
    {

        /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('pages');

        $row = $queryBuilder->select('*')
            ->from('pages')
            ->where($queryBuilder->expr()->in('doktype', [Shop::DOKTYPE, Gastro::DOKTYPE]))
            ->andWhere($queryBuilder->expr()->eq('uid', $uid))
            ->execute()
            ->fetchAll();

        if (!is_array($row)) {
            throw new \RuntimeException('Could not find row with UID "' . $uid . '" in table "pages"', 1314354065);
        }

        /** @var DataMapper $configurationBuilder */
        $dataMapper = $this->objectManager->get(DataMapper::class);

        $shop = $dataMapper->map(Shop::class, $row);

        if (is_array($shop)
            && count($shop) > 0
        ) {
            return $shop[0];
        } else {
            return null;
        }
    }

    /**
     * Finds a center based on a page ID.
     *
     * @param array $uids - ids of multiple page records
     * @return array|null
     */
    public function findByUids($uids)
    {

        /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('pages');

        $rows = $queryBuilder->select('*')
            ->from('pages')
            ->where($queryBuilder->expr()->in('doktype', [Shop::DOKTYPE, Gastro::DOKTYPE]))
            ->andWhere($queryBuilder->expr()->in('uid', $uids))
            ->execute()
            ->fetchAll();

        if (!is_array($rows)) {
            throw new \RuntimeException('Could not find row with UIDs "' . implode(',', $uids) . '" in table "pages"', 1314354065);
        }

        /** @var DataMapper $configurationBuilder */
        $dataMapper = $this->objectManager->get(DataMapper::class);

        $shops = $dataMapper->maps(Shop::class, $rows);

        if (is_array($shops)
            && count($shops) > 0
        ) {
            return $shops;
        } else {
            return null;
        }
    }

    public function getShopTranslation($uid, $sysLanguageUid) {
        /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('pages_language_overlay');

        $queryBuilder->select('content_text')
            ->from('pages_language_overlay')
            ->where($queryBuilder->expr()->eq('pid',
                $queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT)))
            ->andwhere($queryBuilder->expr()->eq('sys_language_uid',
                $queryBuilder->createNamedParameter($sysLanguageUid, \PDO::PARAM_INT)));

        return $queryBuilder->execute()->fetchColumn(0);
    }

	/**
	 * Gets content elements for a shop record
	 *
	 * @param $uid
	 * @param int $sys_language_uid
	 * @return string
	 */
	public function getContentsForShop($uid, $sys_language_uid = -2) {
		$content = '';
		if($sys_language_uid < -1) {
			$sys_language_uid = $GLOBALS['TSFE']->sys_language_uid;
		}
		/** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('tt_content');

		$records = $queryBuilder->select('bodytext')
			->from('tt_content')
			->where($queryBuilder->expr()->in('sys_language_uid', [-1, $sys_language_uid]))
			->andWhere($queryBuilder->expr()->eq('pid', $uid))
			->orderBy('sorting')
			->execute()
			->fetchAll();

		if (!is_array($records)) {
			throw new \RuntimeException('Could not find row with UID "' . $uid . '" in table "pages"', 1314354065);
		}

		foreach ($records as $record) {
			$content .= $record['bodytext'];
		}

		return $content;
	}

    /**
     * Find shops that have openings that are different to center openings
     *
     * @param int $uid - id of a page record
     * @return array
     */
    public function findShopWithExtraOpenings($uid)
    {

        /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('pages');

        $row = $queryBuilder->selectLiteral('DISTINCT pages.*')
            ->from('pages')
            ->innerJoin(
                'pages',
                'tx_center_domain_model_openinghours_dailyhours',
                'opening',
				$queryBuilder->expr()->andX(
					$queryBuilder->expr()->eq('opening.parent', $queryBuilder->quoteIdentifier('pages.uid')),
					$queryBuilder->expr()->eq('opening.parent_table', $queryBuilder->createNamedParameter('pages'))
				)
            )
            ->where($queryBuilder->expr()->in('doktype', [Shop::DOKTYPE, Gastro::DOKTYPE]))
            ->andWhere($queryBuilder->expr()->eq('center', $uid))
            ->andWhere($queryBuilder->expr()->gt('weekly_schedule', 0))
            ->andWhere($queryBuilder->expr()->andX(
                $queryBuilder->expr()->orX(
                    $queryBuilder->expr()->gt('opening.from', 0),
                    $queryBuilder->expr()->gt('opening.till', 0),
                    $queryBuilder->expr()->gt('opening.from_ext', 0),
                    $queryBuilder->expr()->gt('opening.till_ext', 0)))
            )
            ->addOrderBy('pages.doktype', 'ASC')
            ->execute()
            ->fetchAll();

        if (!is_array($row)) {
            throw new \RuntimeException('Could not find row with UID "' . $uid . '" in table "pages"', 1314354065);
        }
        /** @var DataMapper $configurationBuilder */
        $dataMapper = $this->objectManager->get(DataMapper::class);
        $shops = $dataMapper->map(Shop::class, $row);
        return $shops;

    }

    /**
     * Find shops that have special openings
     *
     * @param int $uid - id of a page record
     * @return array
     */
    public function findShopWithSpecialOpenings($uid)
    {

        /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('pages');

        $row = $queryBuilder
            ->selectLiteral('DISTINCT pages.*')
            ->from('pages')
            ->innerJoin(
                'pages',
                'tx_center_domain_model_openinghours_yearlyschedule',
                'yearlyschedule',
				$queryBuilder->expr()->andX(
					$queryBuilder->expr()->eq('yearlyschedule.parent', $queryBuilder->quoteIdentifier('pages.uid')),
					$queryBuilder->expr()->eq('yearlyschedule.parent_table', $queryBuilder->createNamedParameter('pages'))
				)
            )
            ->where($queryBuilder->expr()->in('doktype', [Shop::DOKTYPE, Gastro::DOKTYPE]))
            ->andWhere($queryBuilder->expr()->eq('center', $uid))
            ->andWhere($queryBuilder->expr()->gt('yearly_schedule', 0))
            ->andWhere($queryBuilder->expr()->eq('year', date("Y")))
            ->andWhere($queryBuilder->expr()->gt('special_closing_days', 0))
            ->addOrderBy('pages.doktype', 'ASC')
            ->execute()
            ->fetchAll();

        if (!is_array($row)) {
            throw new \RuntimeException('Could not find row with UID "' . $uid . '" in table "pages"', 1314354065);
        }
        /** @var DataMapper $configurationBuilder */
        $dataMapper = $this->objectManager->get(DataMapper::class);
        $shops = $dataMapper->map(Shop::class, $row);
        return $shops;

    }

	/**
	 * Updates the specified fields in the pages table (shops)
	 *
	 * @param int $uid
	 * @param array $fields
	 * @param int $sysLanguageUid
	 * @return \Doctrine\DBAL\Driver\Statement|int
	 */
    public function updateShopInfos($uid, $fields, $sysLanguageUid = 0) {
		/** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */

		$tableName = 'pages';

		if($sysLanguageUid > 0) {
			$tableName = 'pages_language_overlay';
		}

		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable($tableName);

		$queryBuilder->update($tableName);

		foreach ($fields as $fieldName => $value) {
			$queryBuilder->set($fieldName, $value, true);
		}

		$queryBuilder->where($queryBuilder->expr()->eq('uid',
			$queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT)));
		$queryBuilder->andwhere($queryBuilder->expr()->in('doktype', [Shop::TYPE, Gastro::TYPE]));

		return $queryBuilder->execute();
	}

	/**
	 * Finds a center based on a page ID.
	 *
	 * @param int $centerUid - id of a center
	 * @return array
	 */
	public function findByCenter($centerUid)
	{
		/** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('pages');

		$rows = $queryBuilder->select('*')
			->from('pages')
			->where($queryBuilder->expr()->in('doktype', [Shop::DOKTYPE, Gastro::DOKTYPE]))
			->andWhere($queryBuilder->expr()->eq('center', $centerUid))
			->execute()
			->fetchAll();

		/** @var DataMapper $configurationBuilder */
		$dataMapper = $this->objectManager->get(DataMapper::class);

		$shops = $dataMapper->map(Shop::class, $rows);

		return $shops;
	}

    /**
     * @param int $centerUid
     * @param int $chainStore
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     */
    public function findByCenterAndChainStore($centerUid, $chainStore)
    {
        $query = $this->createQuery();

        $query->getQuerySettings()->setRespectStoragePage(false);

        $shop = $query->matching($query->logicalAnd([
            $query->equals('chainStore', $chainStore),
            $query->equals('center', $centerUid)]
        ))->execute();

        return $shop;
    }

	/**
	 * Finds a center based on a page ID.
	 *
	 * @param int $pageUid - id of a center
	 * @return array
	 */
	public function findShopTags($pageUid)
	{
		/** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('pages');

		$uids = [];
		$rows = $queryBuilder->select('pages.uid','uid_local')
			->from('pages')
			->innerJoin(
				'pages',
				'tx_center_domain_model_misc_tag_record_mm',
				'spec_tag_mm',
				"(spec_tag_mm.uid_foreign = pages.uid ) 
						AND (spec_tag_mm.tablenames = 'pages') 
						AND spec_tag_mm.fieldname != 'tags'"
			)
			->andwhere($queryBuilder->expr()->eq('pages.uid', $pageUid))
			->execute()
			->fetchAll();
		
		foreach ($rows as $row) {
			$uids[] = ['uid' => $row['uid_local']];
		}

		return $uids;
	}

    /**
     * Updates the specified fields in the pages table (shops)
     *
     * @param int $uid
     * @return void
     */
    public function UpdateShopAfterResetChainStore($uid)
    {
        /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */

        $tableName = 'pages';

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable($tableName);

        $queryBuilder->update($tableName);

        $queryBuilder->set('Chain_store_tags', 0, true);


        $queryBuilder->where($queryBuilder->expr()->eq('uid',
            $queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT)));
        $queryBuilder->andwhere($queryBuilder->expr()->in('doktype', [Shop::TYPE, Gastro::TYPE]));

        $queryBuilder->execute();

        return;
    }


}