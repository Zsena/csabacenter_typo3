<?php

namespace DigitalZombies\Center\Domain\Repository\EasterEgg;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * The repository for record base
 */
class EasterEggRepository extends Repository
{
	/**
	 * @param $centerUid
	 * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findByCenter($centerUid) {
		/** @var QueryInterface $query */
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(false);
		$query->matching($query->equals('center', (int)$centerUid));

		return $query->execute();

	}
}