<?php
namespace DigitalZombies\Center\Domain\Repository\Shop;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;


/**
 * The repository for chain stores
 */
class ChainStoreRepository extends Repository {
	/**
	 *
	 */
	public function initializeObject() {
		/** @var $defaultQuerySettings \TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface */
		$defaultQuerySettings = $this->objectManager->get(QuerySettingsInterface::class);
		$defaultQuerySettings->setRespectStoragePage(false);

		$this->setDefaultQuerySettings($defaultQuerySettings);
	}


	public function getChainStoreTranslation($uid, $sysLanguageUid) {
		/** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
			->getQueryBuilderForTable('tx_center_domain_model_shop_chainstore');

		$queryBuilder->select('description')
			->from('tx_center_domain_model_shop_chainstore')
			->where($queryBuilder->expr()->eq('l10n_parent',
				$queryBuilder->createNamedParameter($uid, \PDO::PARAM_INT)))
			->andwhere($queryBuilder->expr()->eq('sys_language_uid',
				$queryBuilder->createNamedParameter($sysLanguageUid, \PDO::PARAM_INT)));

		return $queryBuilder->execute()->fetchColumn(0);
	}
}