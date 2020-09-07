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
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class OpeningHoursHelper
{
    const CENTER = 1;
    const SHOP = 1;

    /**
     * Calculates the current time based on a timeZone
     *
     * @param string $timeZoneName
     * @return \DateTime|null
     */
    public static function getCurrentTimeInCenter($timeZoneName) {
        $dateTimeInCenter = null;
        try {
            $dateTimeInCenter = new \DateTime("now", new \DateTimeZone($timeZoneName) );
        }
            //Falls timezone is invalid
        catch (\Exception $e) {
            $dateTimeInCenter = new \DateTime("now", new \DateTimeZone('Europe/Berlin') );
        }
        return $dateTimeInCenter;
    }

    /**
     * Creates an array with the opening hours for an object (center|shop|gastro|service)
     *
     * @param \DateTime $dateTimeInCenter
     * @param array $yearlySchedule
     * @param ObjectStorage $weeklySchedule
     * @param int $type
     * @param string $dateFormat
     * @return array
     */
    protected static function createOpeningHoursBase($dateTimeInCenter, $yearlySchedule, $weeklySchedule,  $type = self::CENTER, $dateFormat = '')
    {
        $openingHours = [
            "tz_offset" => 0,
            "opening" => [],
            "holidays" => [],
        ];

        //Step1: Set the timezone offset based on the timezone of the center

        $openingHours["tz_offset"] = $dateTimeInCenter->getOffset() / 3600;

        //Step2: Weekly Schedule

        $weeklyOpeningHours = [];
        if ($weeklySchedule) {
            /** @var DailyHours $dailyHours */
            foreach ($weeklySchedule as $dailyHours) {
                $dayOfWeek = $dailyHours->getDayOfWeek();
                $weeklyOpeningHours[$dayOfWeek] = [
                    "dayOfWeek" => $dayOfWeek,
                    "hours" => []
                ];
                if (!$dailyHours->getClosed()) {
                    $weeklyOpeningHours[$dayOfWeek]["hours"] = [
                        HoursHelper::extractTimeFromTimestamp($dailyHours->getFrom()),
                        HoursHelper::extractTimeFromTimestamp($dailyHours->getTill())
                    ];
                    if ($dailyHours->getFromExt()) {
                        $weeklyOpeningHours[$dayOfWeek]["hours"][] = HoursHelper::extractTimeFromTimestamp($dailyHours->getFromExt());
                        $weeklyOpeningHours[$dayOfWeek]["hours"][] = HoursHelper::extractTimeFromTimestamp($dailyHours->getTillExt());
                    }
                }
            }
        }
        //To handle such cases when the sorting differs from the normal 1,2,3,4,5,6,7
        ksort($weeklyOpeningHours);

        $openingHours["opening"] = $weeklyOpeningHours;

        if (!empty($yearlySchedule)) {

            foreach ($yearlySchedule as $schedule){

                //Step 3: Holidays + ClosingDays
                $holidays = $schedule->getHolidays();

                /** @var Holiday $holiday */
                foreach ($holidays as $holiday) {
                    $openingHours["holidays"][] =
                        [
                            "name" => $holiday->getName(),
                            "date" => date('Y-m-d', $holiday->getClosingDay()),
                            "formattedDate" => $dateFormat ? date($dateFormat, $holiday->getClosingDay()) : '',
                            "hours" => []
                        ];
                }

                $closingDays = $schedule->getSpecialClosingDays();

                /** @var SpecialClosingDay $closingDay */
                foreach ($closingDays as $closingDay) {
                    $closingDayArray =
                        [
                            "name" =>  $closingDay->getName(),
                            "date" =>  date('Y-m-d', $closingDay->getClosingDay()),
                            "formattedDate" => $dateFormat ? date($dateFormat, $closingDay->getClosingDay()) : '',
                            "hours" => [],
                            "hoursText" => ""
                        ];
                    //If there is a time set on the
                    if($closingDay->hasHoursSet()) {
                        $closingDayArray["hours"][] = HoursHelper::extractTimeFromTimestamp($closingDay->getFrom());
                        $closingDayArray["hours"][] = HoursHelper::extractTimeFromTimestamp($closingDay->getTill());
                        $closingDayArray["hoursText"] = OpeningHoursHelper::formatTime(
                            $closingDay->getFrom(),
                            $closingDay->getTill()
                        );
                    }

                    $openingHours["holidays"][] = $closingDayArray;
                }
            }
        }
        return $openingHours;
    }

	/**
	 * Creates a valid json for the 3rd party mapplic plugin.
	 *
	 * @param string $dateFormat
	 * @return mixed|array
	 */
	public static function createOpeningHoursForCenter($dateFormat)
	{
		$result = [];
		if(ScopeConfiguration::hasCenter()) {
			$timeZoneName = ScopeConfiguration::getScope()->getTimeZone()->getName();

			$dateTimeInCenter = self::getCurrentTimeInCenter($timeZoneName);

			$yearlySchedule = self::getPrevCurNextYearlySchedule(ScopeConfiguration::getScope()->getYearlySchedule(), $dateTimeInCenter->getTimestamp());
			/** @var ObjectStorage $weeklySchedule */
			$weeklySchedule = ScopeConfiguration::getScope()->getWeeklySchedule();

			$result = self::createOpeningHoursBase($dateTimeInCenter, $yearlySchedule, $weeklySchedule, self::CENTER, $dateFormat);
		}

		return $result;
	}


    /**
     * Creates a valid json for the 3rd party mapplic plugin.
     *
     * @param Shop $shop
     * @return mixed|array
     */
    public static function createOpeningHoursForShop($shop)
    {
        $timeZoneName = $shop->getCenter()->getTimeZone()->getName();

        $dateTimeInCenter = self::getCurrentTimeInCenter($timeZoneName);

        $yearlySchedule[] = self::getCurrentYearlySchedule($shop->getYearlySchedule(), $dateTimeInCenter->getTimestamp());
        /** @var ObjectStorage $weeklySchedule */
        $weeklySchedule = $shop->getWeeklySchedule();


        return self::createOpeningHoursBase($dateTimeInCenter, $yearlySchedule,NULL, $weeklySchedule, self::SHOP);
    }

    /**
     * @param ObjectStorage $yearlySchedule
     * @param int $day
     * @return null|YearlySchedule
     */
    protected static function getCurrentYearlySchedule($yearlySchedule, $day)
    {
        $selectedYear = null;
        $currentYear = date('Y', $day);

        if ($yearlySchedule) {
            /** @var YearlySchedule $year */
            foreach ($yearlySchedule as $year) {
                if ($year->getYear() == $currentYear) {
                    $selectedYear = $year;
                    break;
                }
            }
        }
        return $selectedYear;
    }

    /**
     * @param ObjectStorage $yearlySchedule
     * @param int $day
     * @return array
     */
    public static function getPrevCurNextYearlySchedule($yearlySchedule, $day)
    {
        $selectedYear = [];
        $currentYear = date('Y', $day);
        if ($yearlySchedule) {
            /** @var YearlySchedule $year */
            foreach ($yearlySchedule as $year) {
                if ($year->getYear() == $currentYear-1 || $year->getYear() == $currentYear || $year->getYear() == $currentYear+1) {
                    $selectedYear[$year->getYear()] = $year;
                }
            }
            ksort($selectedYear);
        }
        return $selectedYear;
    }

	/**
	 * The resulting array is written to a template variable named 'consolidatedOpeningHours'
	 * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $openingHours
	 * @return array
	 */
	public static function consolidateDailyHours($openingHours)
	{
		$consolidatedOpeningHours = [];
		$lastFromTime = -1;
		$lastTillTime = -1;
		$lastFromExtTime = -1;
		$lastTillExtTime = -1;
		$lastClosed = -1;

		if ($openingHours) {
			// make sure openingHours are sorted by day until we can rely on typo3 to do the sorting here
			if (!is_array($openingHours)) {
				$openingHours = $openingHours->toArray();
			}

			usort($openingHours, function (DailyHours $a, DailyHours $b) {
				$dayOfWeekA = $a->getDayOfWeek();
				$dayOfWeekB = $b->getDayOfWeek();
				if ($dayOfWeekA == $dayOfWeekB) {
					return 0;
				}
				return ($dayOfWeekA < $dayOfWeekB) ? -1 : 1;
			});
			/** @var DailyHours $dailyHours */
			foreach ($openingHours as $dailyHours) {
				$fromTime = HoursHelper::extractTimeFromTimestamp($dailyHours->getFrom());
				$tillTime = HoursHelper::extractTimeFromTimestamp($dailyHours->getTill());
				$fromExtTime = HoursHelper::extractTimeFromTimestamp($dailyHours->getFromExt());
				$tillExtTime = HoursHelper::extractTimeFromTimestamp($dailyHours->getTillExt());

				if (($fromTime == $lastFromTime && $tillTime == $lastTillTime &&
						$fromExtTime == $lastFromExtTime && $tillExtTime == $lastTillExtTime) ||
					($dailyHours->getClosed() == 1 && $lastClosed == 1)
				) {
					// opening hours identical with last found opening hours
					// or closed and last was closed too
					// -> modify last consolidated entry
					$consolidatedOpeningHours[count($consolidatedOpeningHours) - 1]['days'][] = $dailyHours->getDayOfWeek();
				} else {
					// opening hours different from last entry or first entry
					// -> create new consolidated entry
					$consolidatedOpeningHours[] = array(
						'days' => array($dailyHours->getDayOfWeek()),
						'from' => $dailyHours->getFrom(),
						'till' => $dailyHours->getTill(),
						'fromExt' => $dailyHours->getFromExt(),
						'tillExt' => $dailyHours->getTillExt(),
						'closed' => $dailyHours->getClosed()
					);
					// clean up
					$lastFromTime = $fromTime;
					$lastTillTime = $tillTime;
					$lastFromExtTime = $fromExtTime;
					$lastTillExtTime = $tillExtTime;
					$lastClosed = $dailyHours->getClosed();
				}
			}

			// because we can't access last item of array directly in fluid
			foreach ($consolidatedOpeningHours as &$consolidatedDailyHours) {
				if (count($consolidatedDailyHours['days']) > 2) {
					$consolidatedDailyHours['firstDay'] = $consolidatedDailyHours['days'][0];
					$consolidatedDailyHours['lastDay'] = $consolidatedDailyHours['days'][count($consolidatedDailyHours['days']) - 1];
				}
			}
		}
		return $consolidatedOpeningHours;
	}

	/**
	 * @param int $from
	 * @param int $till
	 * @return string
	 */
	public static function formatTime($from, $till) {
		$formattedText = "";

		if ($from > 0 || $till > 0) {

			$fromTime = new \DateTime('now');
			$tillTime = new \DateTime('now');

			$fromTime = $fromTime->setTime($from / 3600, $from % 3600 / 60, 0);
			$tillTime = $tillTime->setTime($till / 3600, $till % 3600 / 60, 0);

			switch ($GLOBALS['TSFE']->sys_language_uid) {
				case 0:
					$formattedText = $fromTime->format('H:i') . " - " . $tillTime->format('H:i') . " Uhr";
					break;
				case 2:
					$formattedText = $fromTime->format('h:i a') . " - " . $tillTime->format('h:i a');
					break;
				default:
					$formattedText = $fromTime->format('H:i') . " - " . $tillTime->format('H:i');
			}
		}
		//ECQS-72 client wants 24:00 instead of 23:59 - 12am instead of 11:59pm
		$formattedText = str_replace("23:59", "24:00", $formattedText);
		$formattedText = str_replace("11:59 pm", "12:00 am", $formattedText);

		return $formattedText;
	}

	public static function getShopOpeningHours(Shop $shop, Center $center) {
        $timeZoneName = ScopeConfiguration::getScope()->getTimeZone()->getName();

        $dateTimeInCenter = self::getCurrentTimeInCenter($timeZoneName);

        $yearlySchedule = self::getPrevCurNextYearlySchedule(ScopeConfiguration::getScope()->getYearlySchedule(), $dateTimeInCenter->getTimestamp());
        /** @var ObjectStorage $weeklySchedule */
        $weeklySchedule = ScopeConfiguration::getScope()->getWeeklySchedule();

        if ($weeklySchedule) {
            /** @var DailyHours $dailyHours */
            foreach ($weeklySchedule as $dailyHours) {
                $dayOfWeek = $dailyHours->getDayOfWeek();
                $weeklyOpeningHours[$dayOfWeek] = [
                    "dayOfWeek" => $dayOfWeek,
                    "hours" => []
                ];
                if (!$dailyHours->getClosed()) {
                    $weeklyOpeningHours[$dayOfWeek]["hours"] = [
                        HoursHelper::extractTimeFromTimestamp($dailyHours->getFrom()),
                        HoursHelper::extractTimeFromTimestamp($dailyHours->getTill())
                    ];
                    if ($dailyHours->getFromExt()) {
                        $weeklyOpeningHours[$dayOfWeek]["hours"][] = HoursHelper::extractTimeFromTimestamp($dailyHours->getFromExt());
                        $weeklyOpeningHours[$dayOfWeek]["hours"][] = HoursHelper::extractTimeFromTimestamp($dailyHours->getTillExt());
                    }
                }
            }
        }
    }
}
