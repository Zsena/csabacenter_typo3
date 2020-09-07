<?php
namespace DigitalZombies\Center\Domain\Repository\Records;

use DigitalZombies\Center\Domain\Model\Records\ContentTeaser;
use DigitalZombies\Center\Domain\Repository\RecordBaseRepository;
use DigitalZombies\Center\Mapper\RecordBaseDataMapper;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;


/**
 * The repository for content teasers
 */
class ContentTeaserRepository extends RecordBaseRepository {

	/**
	 * @param $centerId
	 * @return array
	 */
	public function listAllForCenter($centerId) {
        $teasers = [];
		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('tx_center_domain_model_records_contentteaser');

		$records = $queryBuilder->select('records.*')
			->from('tx_center_domain_model_records_contentteaser', 'records')
			->where($queryBuilder->expr()->eq('records.center', $centerId))
            ->andWhere($queryBuilder->expr()->eq('sys_language_uid', 0))
			->execute()
			->fetchAll();

		$resultCount = count($records);

		if ($resultCount > 0) {
			/** @var RecordBaseDataMapper $dataMapper */
			$dataMapper = $this->objectManager->get(RecordBaseDataMapper::class);

			$teasers = $dataMapper->map(ContentTeaser::class, $records, ContentTeaser::TABLE_NAME);
		}


		return $teasers;
	}

}