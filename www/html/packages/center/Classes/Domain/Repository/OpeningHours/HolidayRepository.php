<?php
namespace DigitalZombies\Center\Domain\Repository\OpeningHours;
use DigitalZombies\Center\Domain\Model\OpeningHours\YearlySchedule;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\Generic\Mapper\DataMapper;


/**
 * The repository for Holidays
 */
class HolidayRepository extends Repository {

	/**
	 * Returns all center not respecting the storage pid settings
	 *
	 * @return int
	 */
	public function deleteHolidaysInLastYear()
	{
		$result = 0;
		$lastYear = (int)date('Y') - 1;
		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('tx_center_domain_model_openinghours_holiday');

		$holidays = $queryBuilder->select('uid')
			->from('tx_center_domain_model_openinghours_holiday', 'h')
			->where('FROM_UNIXTIME(h.closing_day, \'%Y\') = ?')
			->setParameter(0, $lastYear)
			->execute()
			->fetchAll(\PDO::FETCH_COLUMN);

		if(count($holidays) > 0) {
			$result = $queryBuilder->delete('tx_center_domain_model_openinghours_holiday')
				->where(
					$queryBuilder->expr()->in('uid', $holidays)
				)
				->execute();

			if($result) {

				/** @var QueryBuilder $queryBuilder */
				$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
					->getQueryBuilderForTable('tx_center_domain_model_openinghurs_shedule_holiday_mm');

				$result = $queryBuilder->delete('tx_center_domain_model_openinghurs_shedule_holiday_mm')
					->where(
						$queryBuilder->expr()->in('uid_foreign', $holidays)
					)
					->execute();
			}
		}

		return $result;
	}

}