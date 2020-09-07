<?php
namespace DigitalZombies\Center\Domain\Repository\Center;

use TYPO3\CMS\Extbase\Persistence\Repository;


/**
 * The repository for center level
 */
class CenterLevelRepository extends Repository {

	/**
	 * Returns all center not respecting the storage pid settings
	 *
	 * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
	 */
	public function findAll()
	{
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(false);

		return $query->execute();
	}

}