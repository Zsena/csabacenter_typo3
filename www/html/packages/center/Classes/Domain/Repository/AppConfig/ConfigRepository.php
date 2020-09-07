<?php

namespace DigitalZombies\Center\Domain\Repository\AppConfig;

use DigitalZombies\Center\Domain\Model\AppConfig\Config;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;

/**
 * The repository for app config
 */
class ConfigRepository extends Repository
{
	/**
	 * @param $centerUid
	 * @return null|Config
	 */
	public function findByCenter($centerUid) {
		/** @var QueryInterface $query */
		$query = $this->createQuery();
		$query->getQuerySettings()->setRespectStoragePage(false);
		$query->matching($query->equals('center', (int)$centerUid));

		$result = $query->execute();

		$config = null;

		if($result->count() == 1) {
			/** @var Config $config */
			$config = $result->getFirst();
		}

		return $config;

	}
}