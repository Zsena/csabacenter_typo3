<?php
namespace DigitalZombies\Center\Domain\Repository\OpeningHours;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Repository;


/**
 * The repository for YearlySchedule
 */
class YearlyScheduleRepository extends Repository {

	/**
	 * Returns all center not respecting the storage pid settings
	 *
	 * @return int
	 */
	public function deleteYearlySchedulesInLastYear()
	{
		$lastYear = (int)date('Y') - 1;
		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('tx_center_domain_model_openinghours_yearlyschedule');

		$result = $queryBuilder->delete('tx_center_domain_model_openinghours_yearlyschedule')
			->from('tx_center_domain_model_openinghours_yearlyschedule')
			->where('year = ?')
			->setParameter(0, $lastYear)
			->execute();

		return $result;
	}
}