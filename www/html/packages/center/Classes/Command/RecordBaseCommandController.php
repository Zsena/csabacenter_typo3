<?php
namespace DigitalZombies\Center\Command;

use DigitalZombies\Center\Domain\Repository\RecordBaseRepository;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Extbase\Mvc\Controller\CommandController;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class RecordBaseCommandController extends CommandController
{
	/**
	 * @var \TYPO3\CMS\Extbase\Object\ObjectManagerInterface
	 */
	protected $objectManager;

	/**
	 * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
	 */
	public function injectObjectManager(ObjectManagerInterface $objectManager)
	{
		$this->objectManager = $objectManager;
	}

	/**
	 * Recreates the tx_center_domain_model_recordbase table.
	 * Deletes cache for the records that changed recently
	 * @return boolean
	 */
	public function recreateRecordBaseAndClearCacheCommand()
	{
		/** @var CacheManager $cacheManager */
		$cacheManager = GeneralUtility::makeInstance(CacheManager::class);

		//Recreate the tx_center_domain_model_recordbase table
		/** @var \DigitalZombies\Center\Domain\Repository\RecordBaseRepository $recordBaseRepository */
		$recordBaseRepository = $this->objectManager->get(RecordBaseRepository::class);

		$recordBaseRepository->recreateTable();

		//Clear the cache
		$changeQueue = $cacheManager->getCache('center_changequeueitem');

		$changedItems = $changeQueue->getByTag('changed');
		$cacheManager->flushCachesByTags($changedItems);

		//reset change queue
		$changeQueue->flush();

		return true;
	}
}