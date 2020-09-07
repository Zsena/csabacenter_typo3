<?php

namespace DigitalZombies\Center\Command;

use DigitalZombies\Center\Domain\Repository\OpeningHours\HolidayRepository;
use DigitalZombies\Center\Domain\Repository\OpeningHours\SpecialClosingDaysRepository;
use DigitalZombies\Center\Domain\Repository\OpeningHours\YearlyScheduleRepository;
use DigitalZombies\Center\Domain\Repository\Misc\JobRepository;
use DigitalZombies\Center\Domain\Repository\Misc\CouponRepository;
use DigitalZombies\Center\Domain\Repository\Misc\EventRepository;
use DigitalZombies\Center\Domain\Repository\Misc\NewsRepository;
use DigitalZombies\Center\Domain\Repository\Misc\OfferRepository;
use DigitalZombies\Center\Domain\Repository\RecordBaseRepository;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Extbase\Mvc\Controller\CommandController;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ClearDatabaseCommandController extends CommandController
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
     * Deletes the closing days and holidays from the last year
     *
     * @return void
     */
    public function deleteOpeningHoursCommand()
    {
        //Delete Holiday records
        /** @var \DigitalZombies\Center\Domain\Repository\OpeningHours\HolidayRepository $holidayRepository */
        $holidayRepository = $this->objectManager->get(HolidayRepository::class);
        $holidayRepository->deleteHolidaysInLastYear();

        //Delete SpecialClosingDay records
        /** @var \DigitalZombies\Center\Domain\Repository\OpeningHours\SpecialClosingDaysRepository $specialClosingDayRepository */
        $specialClosingDayRepository = $this->objectManager->get(SpecialClosingDaysRepository::class);
        $specialClosingDayRepository->deleteClosingDaysInLastYear();

        //Delete YearlySchedule records
        /** @var \DigitalZombies\Center\Domain\Repository\OpeningHours\YearlyScheduleRepository $yearlyScheduleRepository */
        $yearlyScheduleRepository = $this->objectManager->get(YearlyScheduleRepository::class);
        $yearlyScheduleRepository->deleteYearlySchedulesInLastYear();

    }

    /**
     * Deletes jobs that are older than a certain period
     *
     * @param int $period Alle Jobs mit Anzahl der Tage vom Enddatum werden gelöscht. Jobs deren Enddatum vor dem aktuellen Datum liegen werden nicht gelöscht.
     *
     * @return void
     */
    public function deleteJobsCommand($period = 0)
    {
        //Delete Job records
        /** @var \DigitalZombies\Center\Domain\Repository\Misc\JobRepository $jobRepository */
        $jobRepository = $this->objectManager->get(JobRepository::class);
        $result = $jobRepository->deleteOldJobs($period);

        // Display flash message in scheduler modul
        /** @var FlashMessage $message */
        $message = GeneralUtility::makeInstance(FlashMessage::class,
            $result . ' jobs deleted',
            '', // [optional] the header
            FlashMessage::INFO,
            true
        );
        $flashMessageService = $this->objectManager->get(FlashMessageService::class);
        /** @var \TYPO3\CMS\Core\Messaging\FlashMessageQueue $messageQueue */
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
        $messageQueue->addMessage($message);
    }

    /**
     * Deletes old events
     * @param integer $period Interval
     * @return boolean
     */
    public function deleteEventsCommand($period = 0)
    {
        //Delete Event records
        /** @var \DigitalZombies\Center\Domain\Repository\Misc\EventRepository $eventRepository */
        $eventRepository = $this->objectManager->get(EventRepository::class);
        $result = $eventRepository->deleteOldEvents($period);
        // flash message
        /** @var FlashMessage $message */
        $message = GeneralUtility::makeInstance(FlashMessage::class,
            $result . ' events deleted',
            '', // [optional] the header
            FlashMessage::INFO,
            true
        );
        /** @var FlashMessageService $flashMessageService */
        $flashMessageService = $this->objectManager->get(FlashMessageService::class);

        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
        $messageQueue->addMessage($message);
        return true;
    }

    /**
     * Deletes old news
     * @param integer $period Interval
     * @return boolean
     */
    public function deleteNewsCommand($period = 0)
    {
        //Delete Event records
        /** @var \DigitalZombies\Center\Domain\Repository\Misc\NewsRepository $newsRepository */
        $newsRepository = $this->objectManager->get(NewsRepository::class);
        $result = $newsRepository->deleteOldNews($period);
        // flash message
        /** @var FlashMessage $message */
        $message = GeneralUtility::makeInstance(FlashMessage::class,
            $result . ' events deleted',
            '', // [optional] the header
            FlashMessage::INFO,
            true
        );
        /** @var FlashMessageService $flashMessageService */
        $flashMessageService = $this->objectManager->get(FlashMessageService::class);

        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
        $messageQueue->addMessage($message);
        return true;
    }

    /**
     * Deletes old offers
     * @param integer $period Interval
     * @return boolean
     */
    public function deleteOffersCommand($period = 0)
    {
        //Delete Offer records
        /** @var \DigitalZombies\Center\Domain\Repository\Misc\OfferRepository $offerRepository */
        $offerRepository = $this->objectManager->get(OfferRepository::class);
        $result = $offerRepository->deleteOldOffers($period);
        // flash message
        /** @var FlashMessage $message */
        $message = GeneralUtility::makeInstance(FlashMessage::class,
            $result . ' offers deleted',
            '', // [optional] the header
            FlashMessage::INFO,
            true
        );
        /** @var FlashMessageService $flashMessageService */
        $flashMessageService = $this->objectManager->get(FlashMessageService::class);

        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
        $messageQueue->addMessage($message);
        return true;
    }

    /**
     * Deletes cache if the access of a record has changed recently.
     * @param integer $period Interval
     * @return boolean
     */
    public function clearCacheAutomaticallyCommand($period = 0)
    {
        //Delete Offer records
        /** @var \DigitalZombies\Center\Domain\Repository\RecordBaseRepository $recordBaseRepository */
        $recordBaseRepository = $this->objectManager->get(RecordBaseRepository::class);
        $tagsToFlush = $recordBaseRepository->getRecentlyEnabledOrDisabledRecords($period);

        /** @var CacheManager $cacheManager */
        $cacheManager = $this->objectManager->get(CacheManager::class);
        $cacheManager->flushCachesByTags($tagsToFlush);

        return true;
    }

    /**
     * Deletes coupons that are older than a certain period
     *
     * @param int $period Alle Coupons mit Anzahl der Tage vom Enddatum werden gelöscht. Jobs deren Enddatum vor dem aktuellen Datum liegen werden nicht gelöscht.
     *
     * @return void
     */
    public function deleteCouponsCommand($period = 0)
    {
        //Delete Coupon records
        /** @var \DigitalZombies\Center\Domain\Repository\Misc\CouponRepository $couponRepository */
        $couponRepository = $this->objectManager->get(CouponRepository::class);
        $result = $couponRepository->deleteOldCoupons($period);

        // Display flash message in scheduler modul
        /** @var FlashMessage $message */
        $message = GeneralUtility::makeInstance(FlashMessage::class,
            $result . ' coupons deleted',
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