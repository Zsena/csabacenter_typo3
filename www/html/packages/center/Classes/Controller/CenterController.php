<?php

namespace DigitalZombies\Center\Controller;

use DigitalZombies\Center\Domain\Model\Center\Center;
use DigitalZombies\Center\Domain\Model\OpeningHours\SpecialClosingDay;
use DigitalZombies\Center\Domain\Model\OpeningHours\YearlySchedule;
use DigitalZombies\Center\Domain\Repository\OpeningHours\HolidayRepository;
use DigitalZombies\Center\Domain\Repository\Center\CenterRepository;
use DigitalZombies\Center\Configuration\ScopeConfiguration;
use DigitalZombies\Center\Utility\CenterOpeningHours;
use DigitalZombies\Center\Utility\JSONHelper;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use DigitalZombies\Center\Domain\Repository\OpeningHours\SpecialClosingDaysRepository;
use DigitalZombies\Center\Domain\Repository\Shop\ShopRepository;
use DigitalZombies\Center\Domain\Repository\Records\ServiceRepository;
use DigitalZombies\Center\Utility\ShopOpeningsHelper;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * Class BackendController
 * @package DigitalZombies\Center\Controller
 */
class CenterController extends ActionController
{

	/**
	 * @var \DigitalZombies\Center\Domain\Repository\Center\CenterRepository
	 */
	protected $centerRepository;

	/**
	 * @var \DigitalZombies\Center\Domain\Repository\OpeningHours\SpecialClosingDaysRepository
	 */
	protected $specialClosingDaysRepository;

	/**
	 * @var \DigitalZombies\Center\Domain\Repository\OpeningHours\HolidayRepository
	 */
	protected $holidayRepository;

	/**
	 * @var \DigitalZombies\Center\Domain\Repository\Shop\ShopRepository
	 */
	protected $shopRepository;

	/**
	 * @var \DigitalZombies\Center\Domain\Repository\Records\ServiceRepository
	 */
	protected $serviceRepository;

	/**
	 * @param \DigitalZombies\Center\Domain\Repository\Center\CenterRepository $repository
	 *
	 * @return void
	 */
	public function injectCenterRepository(CenterRepository $repository)
	{
		$this->centerRepository = $repository;
	}

	/**
	 * @param \DigitalZombies\Center\Domain\Repository\OpeningHours\SpecialClosingDaysRepository $repository
	 *
	 * @return void
	 */
	public function injectSpecialClosingDaysRepository(SpecialClosingDaysRepository $repository)
	{
		$this->specialClosingDaysRepository = $repository;
	}

	/**
	 * @param \DigitalZombies\Center\Domain\Repository\OpeningHours\HolidayRepository $repository
	 *
	 * @return void
	 */
	public function injectHolidayRepository(HolidayRepository $repository)
	{
		$this->holidayRepository = $repository;
	}

	/**
	 * @param \DigitalZombies\Center\Domain\Repository\Shop\ShopRepository $repository
	 *
	 * @return void
	 */
	public function injectShopRepository(ShopRepository $repository)
	{
		$this->shopRepository = $repository;
	}

	/**
	 * @param \DigitalZombies\Center\Domain\Repository\Records\ServiceRepository $repository
	 *
	 * @return void
	 */
	public function injectServiceRepository(ServiceRepository $repository)
	{
		$this->serviceRepository = $repository;
	}

	public function listAction()
	{
		$centers = $this->centerRepository->findAll();
		$this->view->assign('centers', $centers);
	}

    /**
     * List used by the Backend Push Notifications Module
     */
    public function backendPushConfigurationListAction()
    {
        $this->view->assign('centers', $this->centerRepository->findAll());
    }

    /**
     * @param Center $updatedCenter
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\UnknownObjectException
     */
    public function updateAction(Center $updatedCenter)
    {
        $this->centerRepository->update($updatedCenter);
        $this->forward('backendPushConfigurationList');
    }

    /**
     *
     */
    public function showPlanAction()
    {
        $this->view->assign('center', ScopeConfiguration::getScope());

        if (GeneralUtility::_GET('location')) {

            $wayfinder = [
                'id' => (int)GeneralUtility::_GET('location')
            ];

            $this->view->assign('wayfinder', $wayfinder);
        }

        unset($center);
    }

	/**
	 * @return null|string
	 */
	public function renderPlanJSONAction()
	{

		return JSONHelper::createPlan();
	}

	/**
	 * @return null|string
	 */
	public function showOpeningAction()
	{
		$dateFormat = $this->settings['dateFormat']['base'];
		$json = JSONHelper::createOpeningHoursJSONResponse($dateFormat);

		return $json;
	}

	/**
	 *
	 */
	public function showOpeningAboutCenterAction()
	{
		if (ScopeConfiguration::hasCenter()) {
			if ($this->settings['days']) {
				$days = $this->settings['days'];
			} else {
				$days = 30;
			}
			/** @var  \DigitalZombies\Center\Domain\Model\Shop\Shop $shops */
			$shops = $this->shopRepository->findShopWithExtraOpenings(ScopeConfiguration::getScope()->getUid());
			$shopOpenings = ShopOpeningsHelper::createShopOpenings($shops);
			$shopsWithSpecialOpenings = $this->sanitizeOpeneings($this->shopRepository->findShopWithSpecialOpenings(ScopeConfiguration::getScope()->getUid()));

			/** @var  \DigitalZombies\Center\Domain\Model\Records\Service $service */
			$service = $this->serviceRepository->findServiceWithExtraOpenings(ScopeConfiguration::getScope()->getUid());
			$serviceOpenings = ShopOpeningsHelper::createShopOpenings($service);
			$serviceWithSpecialOpenings = $this->serviceRepository->findServiceWithSpecialOpenings(ScopeConfiguration::getScope()->getUid());
			/** @var  \DigitalZombies\Center\Domain\Model\Records\Service $service247 */
			$service247 = $this->serviceRepository->findServiceWith247(ScopeConfiguration::getScope()->getUid());

			$this->view->assignMultiple(array(
				'center' => ScopeConfiguration::getScope(),
				'dailyHours' => ScopeConfiguration::getScope()->getWeeklySchedule(),
				'holidays' => ScopeConfiguration::getScope()->getUpcomingHolidays(),
				'specialClosingDays' => ScopeConfiguration::getScope()->getUpcomingSpecialClosingDays($days),
				'shopOpenings' => $shopOpenings,
				'shopsWithSpecialOpenings' => $shopsWithSpecialOpenings,
				'serviceOpenings' => $serviceOpenings,
				'serviceWithSpecialOpenings' => $serviceWithSpecialOpenings,
				'service247' => $service247
			));
		}
	}

	/**
	 * unset special opening days that are in the past.
	 * @param $openings
	 * @return mixed
	 */
	public function sanitizeOpeneings($openings)
	{
		foreach ($openings as $shops) {
			/** @var YearlySchedule $schedule */
			foreach ($shops->getYearlySchedule() as $schedule) {
				foreach ($schedule->getSpecialClosingDays() as $key => $day) {
					if (!(time() <= $day->getClosingDay())) {
						$schedule->getSpecialClosingDays()->detach($day);
					}
				}
			}
		}

		return $openings;
	}

	/**
	 * @return string
	 */
	public function getOpeningsAction()
	{
		$dateFormat = '%d. %B %Y';

		if (isset($this->settings['dateFormat']['fullMonth'])) {
			$dateFormat = $this->settings['dateFormat']['fullMonth'];
		}

		return json_encode(CenterOpeningHours::getHours($dateFormat, true));
	}

	/**
	 * @param int $uid
	 * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException
	 */
	public function clearCacheAction($uid)
	{
		/** @var CacheManager $cacheManager */
		$cacheManager = GeneralUtility::makeInstance(CacheManager::class);
		$tags = [
			'css_' . intval($uid),
			'pageId_' . intval($uid)
		];
		$cacheManager->flushCachesByTags($tags);

		$this->forward('list');
	}
}
