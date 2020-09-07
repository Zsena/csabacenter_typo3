<?php

namespace DigitalZombies\Center\Domain\Repository;

use DigitalZombies\Center\Constants\HideInApp;
use DigitalZombies\Center\Domain\Model\Center\Center;
use DigitalZombies\Center\Domain\Model\RecordBase;
use DigitalZombies\Center\Domain\Model\Records\ContentTeaser;
use DigitalZombies\Center\Domain\Model\Shop\Shop;
use DigitalZombies\Center\Domain\Repository\Interest\InterestRepository;
use DigitalZombies\Center\Mapper\RecordBaseDataMapper;
use DigitalZombies\Center\Utility\TeaserBuilder;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\EndTimeRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\StartTimeRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;
use TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;


/**
 * The repository for record base
 */
class RecordBaseRepository extends Repository
{


	const SORTING_STARTTIME = 0;
	const SORTING_TITLE = 1;
	const SORTING_TIMEDIFF = 2;
	const SORTING_BOOKMARKS = 3;

	/**
	 *
	 */
	public function initializeObject()
	{
		/** @var $defaultQuerySettings \TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface */
		$defaultQuerySettings = $this->objectManager->get(QuerySettingsInterface::class);
		$defaultQuerySettings->setRespectStoragePage(false);

		$this->setDefaultQuerySettings($defaultQuerySettings);
	}

	/**
	 * Prepares a QueryBuilder object for the recordbase view with all the filters set
	 *
	 * @param Center $center
	 * @param array $settings
	 * @param boolean $returnCount
	 *
	 * @return QueryBuilder
	 */
	protected function prepareSelectStatement($center, $settings, $returnCount = false)
	{

		$centerInScope = $center->getUid();


		$currentDateTime = new \DateTime();
		$currentTimeStamp = $currentDateTime->getTimeStamp();

		$types = isset($settings['types']) && $settings['types'] ? explode(',', $settings['types']) : [];
		$tags = isset($settings['tags']) && $settings['tags'] ? $settings['tags'] : '';
		$specialTags = isset($settings['specTags']) && $settings['specTags'] ? $settings['specTags'] : '';
		$interestsNeeded = isset($settings['interestsOnly']) && $settings['interestsOnly'] ? $settings['interestsOnly'] : '';
		$bookmarksNeeded = isset($settings['bookmarksOnly']) && $settings['bookmarksOnly'] ? $settings['bookmarksOnly'] : '';
		$teaserFormat = isset($settings['teaserFormat']) && $settings['teaserFormat'] ? explode(',', $settings['teaserFormat']) : '';

		$tagsNeeded = $tags !== '';
		$specialTagsNeeded = $specialTags !== '';
		$typesWhereClauseNeeded = count($types) > 0;

		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('tx_center_domain_model_recordbase');

		if ($returnCount) {
			$queryBuilder = $queryBuilder->addSelectLiteral('COUNT(DISTINCT recordbase.uid)');
		} else {
			if ($bookmarksNeeded) {
				$queryBuilder = $queryBuilder->addSelectLiteral(
					'DISTINCT bookmarks_mm.bookmark_date, recordbase.*, bookmark_date'
				);
			}else{
				$queryBuilder = $queryBuilder->addSelectLiteral('DISTINCT recordbase.*');
			}
		}

		$queryBuilder = $queryBuilder->from('tx_center_domain_model_recordbase', 'recordbase')
			->leftJoin('recordbase',
				'tx_center_domain_model_records_center_mm',
				'centers',
				'centers.uid_local = ' . (int)$centerInScope . ' AND centers.uid_foreign= recordbase.uid AND centers.tablenames = recordbase.type');

		//General Tags JOIN
		//SPECIAL CASE: shops have a fallback to chain_stores if it is set
		if ($tagsNeeded) {
			$queryBuilder = $queryBuilder->innerJoin(
				'recordbase',
				'tx_center_domain_model_misc_tag_record_mm',
				'tag_mm',
				"(tag_mm.uid_foreign = CASE WHEN recordbase.chain_store_tags
							THEN recordbase.chain_store WHEN recordbase.content_showglobalservicedata THEN recordbase.global_service
							ELSE recordbase.uid END)
						AND (tag_mm.tablenames = CASE WHEN recordbase.chain_store_tags
							THEN 'tx_center_domain_model_shop_chainstore'
							WHEN recordbase.content_showglobalservicedata
							THEN 'tx_center_domain_model_records_globalservice'
							ELSE recordbase.table_name END)
						AND tag_mm.fieldname = 'tags'"

			);
		}

		//Special Tags JOIN
		//SPECIAL CASE: shops have a fallback to chain_stores if it is set
		if ($specialTagsNeeded) {
			$queryBuilder = $queryBuilder->innerJoin(
				'recordbase',
				'tx_center_domain_model_misc_tag_record_mm',
				'spec_tag_mm',
				"(spec_tag_mm.uid_foreign = CASE WHEN recordbase.chain_store_tags
							THEN recordbase.chain_store WHEN recordbase.content_showglobalservicedata THEN recordbase.global_service
							ELSE recordbase.uid END)
						AND (spec_tag_mm.tablenames = CASE WHEN recordbase.chain_store_tags
							THEN 'tx_center_domain_model_shop_chainstore'
							WHEN recordbase.content_showglobalservicedata
							THEN 'tx_center_domain_model_records_globalservice'
							ELSE recordbase.table_name END)
						AND spec_tag_mm.fieldname != 'tags'"
			);
		}

		//Interests JOIN
		if ($interestsNeeded) {
			$queryBuilder = $queryBuilder->innerJoin(
				'recordbase',
				'tx_center_domain_model_interest_interest_record_mm',
				'interest_mm',
				"(interest_mm.uid_foreign = recordbase.uid)
						AND (interest_mm.tablenames = recordbase.table_name)
						AND interest_mm.fieldname = 'interests'"
			);
		}

		//Bookmarks JOIN
		if ($bookmarksNeeded) {
			$queryBuilder = $queryBuilder->innerJoin(
				'recordbase',
				'tx_center_domain_model_bookmarks',
				'bookmarks_mm',
				'(bookmarks_mm.item_id = recordbase.uid)
					AND (bookmarks_mm.tablename = recordbase.table_name)
					AND (bookmarks_mm.user_id = ' . $GLOBALS['TSFE']->fe_user->user['uid'] . ')'
			);
		}

		$queryBuilder = $queryBuilder->where($queryBuilder->expr()->orX(
			$queryBuilder->expr()->eq('centers.uid_local',
				$queryBuilder->createNamedParameter($centerInScope)),
			$queryBuilder->expr()->eq('recordbase.center',
				$queryBuilder->createNamedParameter($centerInScope))
		)
		);

		//Remove all builtin restrictions, we handle them manually
		$queryBuilder->getRestrictions()
			->removeAll();

		//Protect recordbase - based on the time settings (starttime / endtime)


		if (!$bookmarksNeeded) {
			$queryBuilder = $queryBuilder->andWhere(
				$queryBuilder->expr()->andX(
					$queryBuilder->expr()->orX(
						$queryBuilder->expr()->eq('recordbase.starttime',
							$queryBuilder->createNamedParameter(0)),
						$queryBuilder->expr()->lte('recordbase.starttime',
							$queryBuilder->createNamedParameter($currentTimeStamp))
					),
					$queryBuilder->expr()->orX(
						$queryBuilder->expr()->eq('recordbase.endtime',
							$queryBuilder->createNamedParameter(0)),
						$queryBuilder->expr()->gte('recordbase.endtime',
							$queryBuilder->createNamedParameter($currentTimeStamp))
					)
				)
			);
		}


		//Protect recordbase - it could be deleted and/or hidden
		$queryBuilder = $queryBuilder->andWhere(
			$queryBuilder->expr()->andX(
				$queryBuilder->expr()->eq('recordbase.deleted',
					$queryBuilder->createNamedParameter(0)),
				$queryBuilder->expr()->eq('recordbase.hidden',
					$queryBuilder->createNamedParameter(0))
			)
		);

		//Types WHERE (array)
		if ($typesWhereClauseNeeded) {

			$typeString = '';
			foreach ($types as $type) {
				$typeString .= "'" . $type . "',";
			}
			$typeString = rtrim($typeString, ",");

			$queryBuilder = $queryBuilder->andWhere($queryBuilder->expr()->in('recordbase.type', $typeString));
		}

		//General Tags WHERE (array)
		if ($tagsNeeded) {
			$queryBuilder = $queryBuilder->andWhere($queryBuilder->expr()->in('tag_mm.uid_local',
				$tags));
		}

		//Special Tags WHERE (array)
		if ($specialTagsNeeded) {
			$queryBuilder = $queryBuilder->andWhere($queryBuilder->expr()->in('spec_tag_mm.uid_local',
				$specialTags));
		}

		//Teaser Format WHERE (array)
		if ($teaserFormat) {
			$queryBuilder = $queryBuilder->andWhere($queryBuilder->expr()->in('recordbase.teaser_format',
				$teaserFormat));
		}

		if ($interestsNeeded) {
			/** @var InterestRepository $interestRespository */
			$interestRespository = $this->objectManager->get(InterestRepository::class);
			$userId = $GLOBALS['TSFE']->fe_user->user['uid'] ?? 0;
			$userInterests = $interestRespository->findUserInterests($userId);
			if (empty($userInterests)) {
				$userInterests = "-1";
			}
			$queryBuilder = $queryBuilder->andWhere($queryBuilder->expr()->in('interest_mm.uid_local',
				$userInterests));
		}

		//Language WHERE
		$sys_language_uid = 0;

		if ($GLOBALS['TSFE']->sys_language_uid > 0) {
			//Special Tags JOIN
			//SPECIAL CASE: shops have a fallback to chain_stores if it is set
			$queryBuilder = $queryBuilder->leftJoin(
				'recordbase',
				'tx_center_domain_model_recordbase',
				'translated',
				"translated.l10n_parent = recordbase.uid
						AND translated.deleted = 0 AND translated.hidden = 0
						AND translated.sys_language_uid = " . (int)$GLOBALS['TSFE']->sys_language_uid
				. " AND recordbase.type = translated.type"
			);

			//Handling of the hideNoneTranslated config
			if ($GLOBALS['TSFE']->sys_language_contentOL === 'hideNonTranslated') {
				$queryBuilder->andWhere($queryBuilder->expr()->isNotNull(
					'translated.uid'));
			}
		}

		$queryBuilder = $queryBuilder
			->andWhere($queryBuilder->expr()->eq(
				'recordbase.sys_language_uid', $sys_language_uid));

		$queryBuilder = $queryBuilder
            ->andWhere($queryBuilder->expr()->notIn('recordbase.hide_in_app', [HideInApp::ONLY_IN_APP]));

		return $queryBuilder;
	}

	public function findFallBackTeasrs($center, $limit)
	{

		$settings = [];
		$settings['types'] = ContentTeaser::TYPE;


		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = $this->prepareSelectStatement($center, $settings);

		$queryBuilder = $queryBuilder->andWhere(
			$queryBuilder->expr()->eq('recordbase.is_fallback_teaser',
				$queryBuilder->createNamedParameter(1)
			)
		);

		$queryBuilder = $queryBuilder
			->addOrderBy('recordbase.title', 'ASC')
			->addOrderBy('recordbase.uid', 'DESC')
			->addOrderBy('recordbase.type', 'ASC');

		$records = $queryBuilder
			->execute()
			->fetchAll();
		$queryBuilder = $queryBuilder->setFirstResult(0);
		$queryBuilder->setMaxResults($limit);

		//We map the actual DB rows to objects. At this point we create different subclasses of the RecordBase class.

		/** @var \DigitalZombies\Center\Mapper\RecordBaseDataMapper $dataMapper */
		$dataMapper = $this->objectManager->get(RecordBaseDataMapper::class);

		//We generate the final record array based on the place what the records in reality occupy.
		// We have at least $row teasers and max $row * $col.
		$teaserItems = TeaserBuilder::buildWall(
			$dataMapper->map(RecordBase::class, $records),
			$limit,
			1
		);

		return $teaserItems;
	}

	/**
	 * @param Center $center
	 * @param array $settings
	 * @param int $offset
	 * @param int $customLimit
	 * @param int $fetchAutomaticContent
	 * @return array
	 */
	public function findRecords($center, $settings, $offset = 0, $customLimit = 0, $fetchAutomaticContent = '')
	{

		$rows = isset($settings['rows']) ? (int)$settings['rows'] : 3;
		$cols = isset($settings['cols']) ? (int)$settings['cols'] : 3;

		$sortingOption = isset($settings['sorting']) ? (int)$settings['sorting'] : self::SORTING_STARTTIME;

		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = $this->prepareSelectStatement($center, $settings);

		$queryBuilder = $queryBuilder->setFirstResult($offset);

		if ($rows > -1) {
			if ($customLimit) {
				$queryBuilder->setMaxResults($customLimit);
			} else {
				$queryBuilder->setMaxResults($rows * $cols);
			}
		}

		switch ($sortingOption) {
			case self::SORTING_TITLE:
				$queryBuilder = $queryBuilder
					->addOrderBy('recordbase.title', 'ASC')
					->addOrderBy('recordbase.uid', 'DESC')
					->addOrderBy('recordbase.type', 'ASC');
				break;
			case self::SORTING_TIMEDIFF:
				$queryBuilder = $queryBuilder
					->addOrderBy('recordbase.time_diff', 'ASC')
					->addOrderBy('recordbase.type_sorting', 'ASC');
				break;
			case self::SORTING_BOOKMARKS:
				$queryBuilder = $queryBuilder
					->addOrderBy('bookmarks_mm.bookmark_date', 'DESC');
				break;
			default:
				$queryBuilder = $queryBuilder
					->addOrderBy('recordbase.starttime', 'DESC')
					->addOrderBy('recordbase.uid', 'DESC')
					->addOrderBy('recordbase.type', 'ASC');
				break;
		}

		$records = $queryBuilder
			->execute()
			->fetchAll();

		//We map the actual DB rows to objects. At this point we create different subclasses of the RecordBase class.

		/** @var \DigitalZombies\Center\Mapper\RecordBaseDataMapper $dataMapper */
		$dataMapper = $this->objectManager->get(RecordBaseDataMapper::class);

		//We generate the final record array based on the place what the records in reality occupy.
		// We have at least $row teasers and max $row * $col.
		$teaserItems = TeaserBuilder::buildWall(
			$dataMapper->map(RecordBase::class, $records),
			$cols,
			$rows,
			$fetchAutomaticContent);

		return $teaserItems;
	}

	/**
	 * Prepares a select based on the settings
	 *
	 * @param Center $center
	 * @param array $settings
	 * @param string $sort
	 * @return array
	 */
	public function findAllRecordsBySpecificSetting($center, $settings, $sort = "recordbase.title")
	{

		$records = [];
		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = $this->prepareSelectStatement($center, $settings);

		if ($queryBuilder) {
			$queryBuilder = $queryBuilder->selectLiteral("DISTINCT recordbase.title, recordbase.type, recordbase.type_uid, recordbase.starttime");
			$queryBuilder = $queryBuilder->orderBy($sort, 'ASC');

			$records = $queryBuilder->execute()
				->fetchAll();

		}
		return $records;
	}

	/**
	 * @param Center $center
	 * @param array $settings
	 * @return array
	 */
	public function findAllRecordsByTeaserFormat($center, $settings)
	{

		$records = [];
		if ($settings['types']) {

			/** @var QueryBuilder $queryBuilder */
			$queryBuilder = $this->prepareSelectStatement($center, $settings);

			if ($queryBuilder) {
				$queryBuilder = $queryBuilder->select("recordbase.title", "recordbase.type", "recordbase.type_uid");

				$queryBuilder = $queryBuilder->orderBy('recordbase.title', 'ASC');

				$records = $queryBuilder->execute()
					->fetchAll();

			}
		}
		return $records;
	}


	/**
	 * @param Center $center
	 * @param array $typesWithUids
	 * @param array $sortedUids
	 * @param boolean $forceTeaserFormatToOne
	 * @param string $tableName
	 * @return array
	 */
	public function findRecordsByUid($center, $typesWithUids, $sortedUids, $forceTeaserFormatToOne = true, $tableName = '')
	{

		$recordBaseItems = [];
		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = $this->prepareSelectStatement($center, []);

		if ($queryBuilder) {
			$expressions = [];
			foreach ($typesWithUids as $type => $uids) {
				if ($uids) {
					$expressions[] = $queryBuilder->expr()->andX(
						$queryBuilder->expr()->eq('recordbase.type', $queryBuilder->createNamedParameter($type)),
						$queryBuilder->expr()->in('recordbase.uid', $uids)
					);
				}
			}


			if (count($expressions)) {
				$orExpression = null;
				foreach ($expressions as $expression) {
					$orExpression = $queryBuilder->expr()->orX($orExpression, $expression);
				}
				$queryBuilder->andWhere($orExpression);
			}

			if ($tableName) {
				$queryBuilder->andWhere($queryBuilder->expr()->eq('recordbase.table_name', $queryBuilder->createNamedParameter($tableName)));
			}

			$records = $queryBuilder->execute()
				->fetchAll();

			/** @var \DigitalZombies\Center\Mapper\RecordBaseDataMapper $dataMapper */
			$dataMapper = $this->objectManager->get(RecordBaseDataMapper::class);

			foreach ($sortedUids as $item) {
				foreach ($records as $record) {
					if ($item === $record['type_uid']) {
						$recordBaseItemArray = $dataMapper->map(RecordBase::class, [$record]);
						if (count($recordBaseItemArray) === 1) {
							/** @var RecordBase $recordBaseItem */
							$recordBaseItem = $recordBaseItemArray[0];
							$recordBaseItem->setTypeUid($record['type_uid']);
							//Set teaserFormat to 1
							if ($forceTeaserFormatToOne
								&& $recordBaseItem->getTeaserFormat() != 1) {
								$clonedRecordBaseItem = clone $recordBaseItem;
								$clonedRecordBaseItem->setTeaserFormat(1);
								$recordBaseItems[] = $clonedRecordBaseItem;
							} else {
								$recordBaseItems[] = $recordBaseItem;
							}
						}
						break;
					}
				}
			}


		}
		return $recordBaseItems;
	}

	/**
	 * Counts all the records that found by the settings from
	 *
	 * @param Center $center
	 * @param array $settings
	 * @return int
	 */
	public function countRecords($center, $settings)
	{

		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = $this->prepareSelectStatement($center, $settings, true);

		$count = $queryBuilder->execute()
			->fetchColumn(0);

		return $count;
	}

	/**
	 * @param integer $recordBaseUid
	 * @param string $type
	 * @return string
	 */
	public function getRelatedRootPageIds($recordBaseUid, $type)
	{
		$uids = '';
		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable($type);

		$records = $queryBuilder->select('center.page_id')
			->from('tx_center_domain_model_recordbase', 'recordbase')
			->innerJoin('recordbase',
				'tx_center_domain_model_records_center_mm',
				'centers',
				'centers.uid_foreign = recordbase.uid AND centers.tablenames = recordbase.type')
			->innerJoin('centers',
				'tx_center_domain_model_center_center',
				'center',
				'centers.uid_local = center.uid')
			->where($queryBuilder->expr()->eq('recordbase.uid',
				$queryBuilder->createNamedParameter($recordBaseUid)))
			->andWhere($queryBuilder->expr()->eq('recordbase.type',
				$queryBuilder->createNamedParameter($type)))
			->execute()
			->fetchAll();

		foreach ($records as $record) {
			$uids .= $record['page_id'] . ',';
		}

		return rtrim($uids, ',');
	}

	/**
	 * @param integer $intervalInSeconds
	 * @return array
	 */
	public function getRecentlyEnabledOrDisabledRecords($intervalInSeconds)
	{
		$tags = [];
		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('tx_center_domain_model_recordbase');

		$queryBuilder->getRestrictions()
			->removeByType(EndTimeRestriction::class)
			->removeByType(StartTimeRestriction::class)
			->removeByType(DeletedRestriction::class)
			->removeByType(HiddenRestriction::class);

		$records = $queryBuilder->selectLiteral('DISTINCT CASE WHEN
		(recordbase.starttime > (UNIX_TIMESTAMP() - ' . $queryBuilder->createNamedParameter($intervalInSeconds, \PDO::PARAM_INT)
			. ') AND recordbase.starttime < UNIX_TIMESTAMP())
		THEN CONCAT(recordbase.table_name, \'_\', center.page_id)
		ELSE CONCAT(recordbase.table_name, \'_\', recordbase.uid)
		END AS tag_to_flush')
			->from('tx_center_domain_model_recordbase', 'recordbase')
			->leftJoin('recordbase',
				'tx_center_domain_model_records_center_mm',
				'centers',
				'centers.uid_foreign = recordbase.uid AND centers.tablenames = recordbase.type')
			->innerJoin('centers',
				'tx_center_domain_model_center_center',
				'center',
				'centers.uid_local = center.uid OR recordbase.center = center.uid')
			->where($queryBuilder->expr()->eq('recordbase.sys_language_uid', 0))
			->andWhere($queryBuilder->expr()->orX(
				$queryBuilder->expr()->andX(
					$queryBuilder->expr()->gte('recordbase.endtime', '(UNIX_TIMESTAMP() - ' .
						$queryBuilder->createNamedParameter($intervalInSeconds, \PDO::PARAM_INT) . ')'),
					$queryBuilder->expr()->lt('recordbase.endtime', 'UNIX_TIMESTAMP()')
				),
				$queryBuilder->expr()->andX(
					$queryBuilder->expr()->gte('recordbase.starttime', '(UNIX_TIMESTAMP() - ' .
						$queryBuilder->createNamedParameter($intervalInSeconds, \PDO::PARAM_INT) . ')'),
					$queryBuilder->expr()->lt('recordbase.starttime', 'UNIX_TIMESTAMP()')
				)
			))
			->andWhere($queryBuilder->expr()->andX(
				$queryBuilder->expr()->andX(
					$queryBuilder->expr()->eq('recordbase.deleted', 0),
					$queryBuilder->expr()->eq('recordbase.hidden', 0)
				),
				$queryBuilder->expr()->andX(
					$queryBuilder->expr()->eq('center.deleted', 0),
					$queryBuilder->expr()->eq('center.hidden', 0)
				)
			))
			->execute()
			->fetchAll();

		foreach ($records as $record) {
			$tags[] = $record['tag_to_flush'];
		}

		return $tags;
	}

	/**
	 * Tuncates the tx_center_domain_model_recordbase table and recreates it with an actual snapshot
	 * This function wipes out everything in the table, please pay attention when you use it.
	 */
	public function recreateTable()
	{
		$createTableFilePath = GeneralUtility::getFileAbsFileName('EXT:center/Resources/Private/SQL/create_table.sql');
		if (file_exists($createTableFilePath)) {
			$sqlStatement = $this->getFileContent($createTableFilePath);
			if ($sqlStatement) {
				/** @var ConnectionPool $connectionPool */
				$connectionPool = GeneralUtility::makeInstance(ConnectionPool::class);
				$connection = $connectionPool->getConnectionForTable('tx_center_domain_model_recordbase');

				$commandParts = preg_split('/;/', $sqlStatement);

				foreach ($commandParts as $commandPart) {
					if($commandPart && strlen($commandPart) > 1) {
						$connection->exec($commandPart);
					}
				}
			}
		}
	}

	/**
	 * @param $sqlFilePath
	 * @return bool|string
	 */
	protected function getFileContent($sqlFilePath) {
		$sqlStatement = "";
		$fileHandle = fopen($sqlFilePath, "r");
		if($fileHandle) {
			$sqlStatement = fread($fileHandle, filesize($sqlFilePath));
		}
		fclose($fileHandle);
		return $sqlStatement;
	}

	public function clearRecordSettings($id, $table) {
	    if(is_numeric($id)) {
            /** @var QueryBuilder $queryBuilder */
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable($table);

            $queryBuilder->update($table)
                ->set('shop', 0)
                ->set('chain_store', 0)
                ->set('reference_type', 0)
                ->set('centers', 0)
                ->where($queryBuilder->expr()->eq('uid', $id))
                ->execute();
        }
    }

}
