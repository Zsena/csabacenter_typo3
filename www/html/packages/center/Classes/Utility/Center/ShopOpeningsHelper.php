<?php

namespace DigitalZombies\Center\Utility;

use DigitalZombies\Center\Domain\Model\OpeningHours\DailyHours;
use DigitalZombies\Center\Domain\Model\OpeningHours\Holiday;use DigitalZombies\Center\Domain\Model\OpeningHours\SpecialClosingDay;use DigitalZombies\Center\Domain\Model\OpeningHours\YearlySchedule;
use DigitalZombies\Center\Configuration\ScopeConfiguration;
use \TYPO3\CMS\Extbase\Utility\LocalizationUtility;

/***************************************************************
 *  Copyright notice
 *
 *    Based on:
 *
 *  (c) 2017 David Miltz <david.miltz@plan-net.com>
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
class ShopOpeningsHelper
{

    /**
     * Returns the directions to the current center in scope
     *
     * @param \DigitalZombies\Center\Domain\Model\Shop\Shop $shops
     * @return array
     */
    public static function createShopOpenings($shops)
    {
        $shopOpenings = [];
        $i = 0;
        $iterator = 0;
        foreach ($shops as $shop) {
            // Make Array with DailyHours of Shops
            /** @var  \DigitalZombies\Center\Domain\Model\Shop\Shop $shop */
            $shopOpenings[$i]['shopName'] = $shop->getTitle();
            $shopOpenings[$i]['days'] = [];
            $prevDay = null;
            foreach ($shop->getWeeklySchedule() as $weeklySchedule) {
                $weekday = "openingsShort.day" . $weeklySchedule->getDayOfWeek();
                /** @var  \DigitalZombies\Center\Domain\Model\OpeningHours\DailyHours $currentDay */
                $currentDay = $weeklySchedule;
                /** @var  \DigitalZombies\Center\Domain\Model\OpeningHours\DailyHours $weeklySchedule */
                $isEqual = ShopOpeningsHelper::compare($prevDay, $weeklySchedule);
                if ($isEqual) {
                    $shopOpenings[$i]['days'][$iterator]['name']['till'] = LocalizationUtility::translate($weekday, 'providerece');
                } else {
                    $iterator = $weeklySchedule->getDayOfWeek();
                    $shopOpenings[$i]['days'][$iterator]['name']['from'] = LocalizationUtility::translate($weekday, 'providerece');
                    /** @var  \DigitalZombies\Center\Domain\Model\OpeningHours\DailyHours $currentDay */
                    $shopOpenings[$i]['days'][$iterator]['dailyHours'] = $currentDay;
                }
                $prevDay = $currentDay;

            }
            $i++;
        }

		return ShopOpeningsHelper::sortByShopName($shopOpenings);
    }

    /**
     * Returns the directions to the current center in scope
     *
     * @param \DigitalZombies\Center\Domain\Model\Shop\Shop $shop
     * @param string $dateFormat
     * @return array
     */
    public static function createOpeningsArrayForShop($shop, $dateFormat)
    {
        $openings = CenterOpeningHours::getHours($dateFormat, true);
        $openings["holidays"] = new \ArrayObject();
        $openings["specialDays"] = new \ArrayObject();
        /** @var DailyHours $dailyHours */
        foreach ($shop->getWeeklySchedule() as $dailyHours) {
            if (!$dailyHours->getClosed()) {
                $openings['weekly'][$dailyHours->getDayOfWeek()]["hours"]["from"] = $dailyHours->getFrom();
                $openings['weekly'][$dailyHours->getDayOfWeek()]["hours"]["till"] = $dailyHours->getTill();
                $openings['weekly'][$dailyHours->getDayOfWeek()]["hoursText"] = OpeningHoursHelper::formatTime(
                    $dailyHours->getFrom(),
                    $dailyHours->getTill()
                );
                if ($dailyHours->getFromExt()) {
                    $openings['weekly'][$dailyHours->getDayOfWeek()]["hours"]["fromExt"] = $dailyHours->getFrom();
                    $openings['weekly'][$dailyHours->getDayOfWeek()]["hours"]["tillExt"] = $dailyHours->getTill();
                    $openings['weekly'][$dailyHours->getDayOfWeek()]["hoursExtText"][] = OpeningHoursHelper::formatTime(
                        $dailyHours->getFromExt(),
                        $dailyHours->getTillExt()
                    );
                }
                $openings['weekly'][$dailyHours->getDayOfWeek()]['isClosed'] = false;
            } else {
                $openings['weekly'][$dailyHours->getDayOfWeek()]['isClosed'] = true;
            }
        }
        
        if ($shop->getYearlySchedule()->count() > 0) {
            $timeZoneName = ScopeConfiguration::getScope()->getTimeZone()->getName();

            $dateTimeInCenter = OpeningHoursHelper::getCurrentTimeInCenter($timeZoneName);

            $yearlySchedules = OpeningHoursHelper::getPrevCurNextYearlySchedule($shop->getYearlySchedule(), $dateTimeInCenter->getTimestamp());

            /** @var YearlySchedule $yearlySchedule */
            foreach ($yearlySchedules as $yearlySchedule) {

                //Step 3: Holidays + ClosingDays
                $holidays = $yearlySchedule->getHolidays();

                /** @var Holiday $holiday */
                foreach ($holidays as $holiday) {
                    if($holiday->getClosingDay()) {
                        $date = date('Y-m-d', $holiday->getClosingDay());
                        $closingDayDateTime = new \DateTime($date);
                        if ($closingDayDateTime > new \DateTime('now')) {
                            $openings["holidays"][$date] =
                                [
                                    "name" => $holiday->getName(),
                                    "date" => $date,
                                    "formattedDate" => (string)($dateFormat ? strftime($dateFormat, $holiday->getClosingDay()) : ''),
                                    "hours" => []
                                ];
                        }
                    }
                }

                $closingDays = $yearlySchedule->getSpecialClosingDays();

                /** @var SpecialClosingDay $closingDay */
                foreach ($closingDays as $closingDay) {
                    if($closingDay->getClosingDay()) {
                        $date = date('Y-m-d', $closingDay->getClosingDay());
                        $closingDayDateTime = new \DateTime($date);
                        if ($closingDayDateTime > new \DateTime('now')) {
                            $closingDayArray =
                                [
                                    "name" => $closingDay->getName(),
                                    "date" => $date,
                                    "formattedDate" => (string)($dateFormat ? strftime($dateFormat, $closingDay->getClosingDay()) : ''),
                                    "hours" => []
                                ];
                            //If there is a time set on the
                            if ($closingDay->hasHoursSet()) {
                                $closingDayArray["hours"][] = OpeningHoursHelper::formatTime(
                                    $closingDay->getFrom(),
                                    $closingDay->getTill()
                                );
                            }
                            $openings["specialDays"][$date] = $closingDayArray;
                        }
                    }
                }
                if(isset($openings["specialDays"]) && is_array($openings["specialDays"])) {
                    CenterOpeningHours::sortByDate($openings["specialDays"]);
                }
            }

        }
        
        return $openings;
    }

	public static function sortByShopName($array) {
		usort($array, function($a, $b) {
			return strtolower($a['shopName']) <=> strtolower ($b['shopName']);
		});

		return $array;
	}



    /**
     * Checks if two weeklyschedule objects are the same
     *
     * @param \DigitalZombies\Center\Domain\Model\OpeningHours\DailyHours $dayA
     * @param \DigitalZombies\Center\Domain\Model\OpeningHours\DailyHours $dayB
     * @return boolean
     */
    public static function compare($dayA, $dayB)
    {
        return $dayA && $dayB && $dayA->getFrom() === $dayB->getFrom() && $dayA->getTill() === $dayB->getTill() && $dayA->getFromExt() === $dayB->getFromExt() && $dayA->getTillExt() === $dayB->getTillExt();
    }
}


?>
