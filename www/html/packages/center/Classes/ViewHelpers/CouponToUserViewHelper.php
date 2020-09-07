<?php

namespace DigitalZombies\Center\ViewHelpers;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use DigitalZombies\Center\Domain\Repository\Misc\CouponRepository;

class CouponToUserViewHelper extends AbstractViewHelper
{

    /**
     * @var \DigitalZombies\Center\Domain\Repository\Misc\CouponRepository
     */
    protected $couponRepository;


    /**
     * @param \DigitalZombies\Center\Domain\Repository\Misc\CouponRepository $repository
     *
     * @return void
     */
    public function injectCouponRepository(CouponRepository $repository){
        $this->couponRepository = $repository;
    }


    /**
     * Initialize arguments.
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('uid', 'int', 'uid of coupon');
    }


    /**
     * This viewhelper checks if the logged in user has already redeemed the coupon shown in detailview
     * @throws \TYPO3\CMS\Fluid\Core\ViewHelper\Exception
     * @return boolean
     */
    public function render()
    {
        return  $this->couponRepository->checkIfCouponIsRedeemedByFEUser($GLOBALS['TSFE']->fe_user->user['uid'],$this->arguments['uid']);
    }
}


