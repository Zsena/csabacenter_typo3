<?php

namespace DigitalZombies\Center\ViewHelpers;

use DigitalZombies\Center\Domain\Repository\OpeningHours\SpecialClosingDaysRepository;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class SortShopSpecialClosingDaysViewHelper
 * @package DigitalZombies\Center\ViewHelpers
 *
 *
 */
class GetNextSpecialClosingDaysForShopViewHelper extends AbstractViewHelper
{

    /**
     * @var \DigitalZombies\Center\Domain\Repository\OpeningHours\SpecialClosingDaysRepository
     */
    protected $specialClosingDaysRepository;

    /**
     * @param \DigitalZombies\Center\Domain\Repository\OpeningHours\SpecialClosingDaysRepository $repository
     *
     * @return void
     */
    public function injectShopRepository(SpecialClosingDaysRepository $repository)
    {
        $this->specialClosingDaysRepository = $repository;
    }

    /**
     * @param int $uid
     * @return \DigitalZombies\Center\Domain\Model\OpeningHours\SpecialClosingDay
     */
    public function render($uid)
    {
        /** @var  \DigitalZombies\Center\Domain\Model\OpeningHours\SpecialClosingDay $closingDay */
        $closingDay = $this->specialClosingDaysRepository->findShopSpecialClosingDays($uid);
        if (!empty($closingDay)) {
            foreach ($closingDay as $key => $row) {
                    $result[$key] = $row['closing_day'];
            }
            array_multisort($result, SORT_ASC, $closingDay);
            $result = $closingDay[0];
        }else{
            $result = false;
        }
        return $result;
    }
}
