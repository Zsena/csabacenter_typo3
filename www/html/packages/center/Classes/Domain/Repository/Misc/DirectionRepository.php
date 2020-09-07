<?php
namespace DigitalZombies\Center\Domain\Repository\Misc;

use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

class DirectionRepository extends Repository
{
	/**
	 * @param int $centerId
	 * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findByCenter($centerId){
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(false);

		$query->matching(
			$query->equals('center', $centerId)
		);

		$query->setOrderings([
			'sorting' => QueryInterface::ORDER_ASCENDING
		]);

		return $query->execute();
	}
}