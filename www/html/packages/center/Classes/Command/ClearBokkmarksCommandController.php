<?php

namespace DigitalZombies\Center\Command;


use DigitalZombies\Center\Domain\Repository\Bookmarks\BookmarksRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\CommandController;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ClearBookmarksCommandController extends CommandController
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
	 * Deletes bookmarks that are older than a certain period
	 *
	 * @param int $period Alle Bookmarks mit Anzahl der Tage vom Enddatum werden gelöscht. Bookmarks deren Enddatum vor dem aktuellen Datum liegen werden nicht gelöscht.
	 *
	 * @return void
	 */
	public function deleteBookmarksCommand($period = 0)
	{
		//Delete Bookmarks records
		/** @var \DigitalZombies\Center\Domain\Repository\Bookmarks\BookmarksRepository $bookmarksRepository */
		$bookmarksRepository = $this->objectManager->get(BookmarksRepository::class);
		$result = $bookmarksRepository->deleteOldBookmarks($period);

		// Display flash message in scheduler modul
		/** @var FlashMessage $message */
		$message = GeneralUtility::makeInstance(FlashMessage::class,
			$result . ' Bookmarks deleted',
			'', // [optional] the header
			FlashMessage::INFO,
			true
		);
		$flashMessageService = $this->objectManager->get(FlashMessageService::class);
		/** @var \TYPO3\CMS\Core\Messaging\FlashMessageQueue $messageQueue */
		$messageQueue = $flashMessageService->getMessageQueueByIdentifier();
		$messageQueue->addMessage($message);
	}


}
