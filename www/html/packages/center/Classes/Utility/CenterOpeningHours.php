<?php
namespace DigitalZombies\Center\Utility;

/***************************************************************
 *  Copyright notice
 *
 *    Based on:
 *
 *  (c) 2017 András Ottó <andras.otto@plan-net.com>
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

use DigitalZombies\Center\Domain\Model\Center\Center;
use DigitalZombies\Center\Domain\Model\OpeningHours\DailyHours;
use DigitalZombies\Center\Domain\Model\OpeningHours\Holiday;
use DigitalZombies\Center\Domain\Model\OpeningHours\SpecialClosingDay;
use DigitalZombies\Center\Domain\Model\OpeningHours\YearlySchedule;
use DigitalZombies\Center\Domain\Model\Shop\Shop;
use DigitalZombies\Center\Configuration\ScopeConfiguration;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class CenterOpeningHours implements SingletonInterface
{
    /** @var CenterOpeningHours */
    private static $centerOpeningHours = null;

    /** @var array */
    private static $openingHours = [];

    /** @var string */
    private static $dateFormat = '';

    /** @var string */
    private static $separateSpecialHours = '';
    /**
     * CenterOpeningHours constructor.
     * @param array $openingHours
     */
    private function __construct($openingHours, $dateFormat, $separateSpecialHours)
    {
        self::$openingHours = $openingHours;
        self::$dateFormat = $dateFormat;
        self::$separateSpecialHours = $separateSpecialHours;
    }

    /**
     * Hide clone function
     */
    private function __clone()
    {
    }

    protected static function getOpeningHours() {
        return self::$openingHours;
    }

    public static function getHours($dateFormat, $separateSpecialHours = false) {
        return self::getInstance($dateFormat, $separateSpecialHours)->getOpeningHours();
    }
    /**
     * Returns an intance of the CenterOpeningHours
     * This is a singleton object because we are not changing the scope in one request so we need
     * to initialize it only once
     *
     * @return CenterOpeningHours
     */
    protected static function getInstance($dateFormat, $separateSpecialHours) {

        if(self::$centerOpeningHours === null) {

            $openingHours = self::getCenterOpenings($dateFormat, $separateSpecialHours);

            self::$centerOpeningHours = new CenterOpeningHours($openingHours,$dateFormat, $separateSpecialHours);

        }
        return self::$centerOpeningHours;
    }

    /**
     * @param $dateFormat
     * @return mixed
     */
    private static function getCenterOpenings($dateFormat, $separateSpecialHours = false) {
        $openingHours = [];
        $timeZoneName = ScopeConfiguration::getScope()->getTimeZone()->getName();

        $dateTimeInCenter = OpeningHoursHelper::getCurrentTimeInCenter($timeZoneName);

        $yearlySchedule = OpeningHoursHelper::getPrevCurNextYearlySchedule(ScopeConfiguration::getScope()->getYearlySchedule(), $dateTimeInCenter->getTimestamp());
        /** @var ObjectStorage $weeklySchedule */
        $weeklySchedule = ScopeConfiguration::getScope()->getWeeklySchedule();

        if ($weeklySchedule) {
            /** @var DailyHours $dailyHours */
            foreach ($weeklySchedule as $dailyHours) {
                $dayOfWeek = $dailyHours->getDayOfWeek();
                $weeklyOpeningHours[$dayOfWeek] = [
                    "dayOfWeek" => $dayOfWeek,
                    "hours" => null,
                    "hoursText" => '',
                    "hoursExt" => null,
                    "hoursExtText" => '',
                    "isClosed" => false
                ];
                if (!$dailyHours->getClosed()) {
                    $weeklyOpeningHours[$dayOfWeek]["hours"]["from"] = $dailyHours->getFrom();
                    $weeklyOpeningHours[$dayOfWeek]["hours"]["till"] = $dailyHours->getTill();
                    $weeklyOpeningHours[$dayOfWeek]["hoursText"] = OpeningHoursHelper::formatTime(
                        $dailyHours->getFrom(),
                        $dailyHours->getTill()
                    );

                    if ($dailyHours->getFromExt()) {
                        $weeklyOpeningHours[$dayOfWeek]["hoursExt"]["from"] = $dailyHours->getFrom();
                        $weeklyOpeningHours[$dayOfWeek]["hoursExt"]["till"] = $dailyHours->getTill();
                        $weeklyOpeningHours[$dayOfWeek]["hoursExtText"] = OpeningHoursHelper::formatTime(
                            $dailyHours->getFromExt(),
                            $dailyHours->getTillExt()
                        );
                    }
                } else {
                    $weeklyOpeningHours[$dayOfWeek]['isClosed'] = true;
                }
            }
        }

        $openingHours['weekly'] = $weeklyOpeningHours;

        if (!empty($yearlySchedule)) {

            /** @var YearlySchedule $schedule */
            foreach ($yearlySchedule as $schedule){

                //Step 3: Holidays + ClosingDays
                $holidays = $schedule->getHolidays();

                /** @var Holiday $holiday */
                foreach ($holidays as $holiday) {
                    if($holiday->getClosingDay()) {
                        $date = date('Y-m-d', $holiday->getClosingDay());
                        $closingDayDateTime = new \DateTime($date);
                        if ($closingDayDateTime > new \DateTime('now')) {
                            $openingHours["holidays"][$date] =
                                [
                                    "name" => $holiday->getName(),
                                    "date" => $date,
                                    "formattedDate" => (string)($dateFormat ? strftime($dateFormat, $holiday->getClosingDay()) : ''),
                                    "hours" => null,
                                    "hoursText" => ""
                                ];
                        }
                    }
                }

                $closingDays = $schedule->getSpecialClosingDays();

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
                                    "hours" => null,
                                    "hoursText" => "",
                                    "isClosed" => true,
                                ];
                            //If there is a time set on the
                            if ($closingDay->hasHoursSet()) {
                                $closingDayArray["hours"] = [
                                    'from' => $closingDay->getFrom(),
                                    'till' => $closingDay->getTill()
                                ];
                                $closingDayArray["hoursText"] = OpeningHoursHelper::formatTime(
                                    $closingDay->getFrom(),
                                    $closingDay->getTill()
                                );
                                $closingDayArray["isClosed"] = false;
                            }

                            if ($separateSpecialHours) {
                                $openingHours["specialDays"][$date] = $closingDayArray;
                            } else {
                                $openingHours["holidays"][$date] = $closingDayArray;
                            }
                        }
                    }
                }
                if(isset($openingHours["holidays"]) && is_array($openingHours["holidays"])) {
                    self::sortByDate($openingHours["holidays"]);
                }
                if(isset($openingHours["specialDays"]) && is_array($openingHours["specialDays"])) {
                    self::sortByDate($openingHours["specialDays"]);
                }
            }
        }

        return $openingHours;
    }

    public static function sortByDate(&$array) {
        uksort($array, function($a, $b) {
            $aDate = new \DateTime($a);
            $bDate = new \DateTime($b);

            if($aDate > $bDate) {
                return 1;
            } else if($aDate < $bDate) {
                return -1;
            } else {
                return 0;
            }
        });
    }
}