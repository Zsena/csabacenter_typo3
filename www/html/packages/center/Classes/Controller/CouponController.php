<?php

namespace DigitalZombies\Center\Controller;

use DigitalZombies\Center\Domain\Model\Misc\Sender;
use DigitalZombies\Center\Domain\Model\Records\Coupon;
use DigitalZombies\Center\Domain\Repository\Misc\CouponRepository;
use DigitalZombies\Center\Service\Page\BodyTitleConfiguration;
use DigitalZombies\Center\Utility\DirectionHelper;
use DigitalZombies\Center\Configuration\ScopeConfiguration;

/**
 *
 * This file is part of the "center" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 David Miltz <d.miltz@plan-net.com>, Plan.Net Pulse
 *
 */

/**
 * Class CouponController
 * @package DigitalZombies\Center\Controller
 */
class CouponController extends MetaTagBaseController
{

	/**
	 * @var \DigitalZombies\Center\Domain\Repository\Misc\CouponRepository
	 */
	protected $couponRepository;

	/**
	 * @var string $key
	 */
	protected $key = "209395";


	/**
	 * @param \DigitalZombies\Center\Domain\Repository\Misc\CouponRepository $repository
	 *
	 * @return void
	 */
	public function injectCouponRepository(CouponRepository $repository)
	{
		$this->couponRepository = $repository;
	}

	/**
	 * Renders a detail page for Coupon
	 *
	 * @param Coupon $coupon
	 */
	public function showAction(Coupon $coupon = null)
	{
		//Check Coupon cookie and make entry in DB
		$this->checkCouponCookieAction();

		if ($coupon) {
			parent::addCacheTags($coupon);

			BodyTitleConfiguration::getInstance()->setTitle($coupon->getTitle());

			$this->setMetaTags($coupon);

			$GLOBALS['HTTP_GET_VARS']['tx_center_coupon']['endtime'] = ($coupon->getEndtime()) ? $coupon->getEndtime() : 0;

			$this->view->assignMultiple(array(
				'center' => ScopeConfiguration::getScope(),
				'coupon' => $coupon,
				'availableCoupons' => $coupon->getFixedAmount() - $coupon->getCouponsRedeemed()
			));
			if ($coupon->getSender()->getSenderType() === Sender::SENDER_CENTER) {
				$this->view->assign('directions', DirectionHelper::getDirections());
			}
		}
	}

	/**
	 * Renders a detail page for Coupon
	 *
	 * @param Coupon $coupon
	 */
	public function confirmAction(Coupon $coupon = null)
	{
		if ($coupon) {

			BodyTitleConfiguration::getInstance()->setTitle($coupon->getTitle());

			$this->setMetaTags($coupon);

			$this->view->assignMultiple(array(
				'center' => ScopeConfiguration::getScope(),
				'coupon' => $coupon,
				'couponId' => $this->encode($coupon->getUid(), $this->key),
				'feUser' => $this->encode($GLOBALS['TSFE']->fe_user->user['uid'], $this->key)
			));
		}
	}

	/**
	 * Renders a detail page for Coupon
	 *
	 * @param Coupon $coupon
	 */
	public function redeemAction(Coupon $coupon = null)
	{
		$redeemed = false;

		if ($this->couponRepository->checkIfCouponIsRedeemedByFEUser($GLOBALS['TSFE']->fe_user->user['uid'], $coupon->getUid())) {
			$this->flagCoupon($coupon->getUid(), $coupon->getCouponsRedeemed() + 1);
			$redeemed = true;
		} elseif (ScopeConfiguration::getScope()->getCouponNoLogin()) {
			$this->couponRepository->setAmount($coupon->getUid(), $coupon->getCouponsRedeemed() + 1);
		} else {
			$this->flagCoupon($coupon->getUid(), $coupon->getCouponsRedeemed() + 1);
		}

		if ($coupon) {
			BodyTitleConfiguration::getInstance()->setTitle($coupon->getTitle());
			$this->setMetaTags($coupon);

			$this->view->assignMultiple(array(
				'center' => ScopeConfiguration::getScope(),
				'coupon' => $coupon,
				'redeemed' => $redeemed
			));
		}
	}

	/**
	 * Checks if Cookie is set and flags coupon as redeemed by user
	 * @return void
	 * @param int $couponId
	 * @param int $newAmount
	 */
	public function flagCoupon($couponId, $newAmount)
	{
		$this->couponRepository->setAmount($couponId, $newAmount);
		$this->couponRepository->flagCouponWithUser($couponId, $GLOBALS['TSFE']->fe_user->user['uid']);

		return;
	}

	/**
	 * Checks if Cookie is set and flags coupon as redeemed by user
	 * @return void
	 */
	public function checkCouponCookieAction()
	{
		if (isset($_COOKIE['CouponRedeemedByUser'])) {
			$UserCouponCombination = explode(",", $_COOKIE['CouponRedeemedByUser']);
			if ($UserCouponCombination[0] != "" && $UserCouponCombination[1] != "") {
				if (!ScopeConfiguration::getScope()->getCouponNoLogin()) {
					$this->couponRepository->flagCouponWithUser(
						intval(
							$this->decode(
								$UserCouponCombination[0],
								$this->key
							)
						),
						intval(
							$this->decode(
								$UserCouponCombination[1],
								$this->key
							)
						)
					);
				}

				unset ($_COOKIE['CouponRedeemedByUser']);
				//UNSET COOKIE
				setcookie("CouponRedeemedByUser", "", time() - 100, '/');
			}
		}
		return;
	}

	/**
	 * encode value for cookie
	 * @param string $string
	 * @param int $key
	 * @return string
	 */
	public function encode($string, $key)
	{
		$key = sha1($key);
		$strLen = strlen($string);
		$keyLen = strlen($key);
		$hash = "";
		$j = 0;
		for ($i = 0; $i < $strLen; $i++) {
			$ordStr = ord(substr($string, $i, 1));
			if ($j == $keyLen) {
				$j = 0;
			}
			$ordKey = ord(substr($key, $j, 1));
			$j++;
			$hash .= strrev(base_convert(dechex($ordStr + $ordKey), 16, 36));
		}
		return $hash;
	}

	/**
	 * decode value for cookie
	 * @param string $string
	 * @param int $key
	 * @return string
	 */
	public function decode($string, $key)
	{
		$key = sha1($key);
		$strLen = strlen($string);
		$keyLen = strlen($key);
		$hash = "";
		$j = 0;
		for ($i = 0; $i < $strLen; $i += 2) {
			$ordStr = hexdec(base_convert(strrev(substr($string, $i, 2)), 36, 16));
			if ($j == $keyLen) {
				$j = 0;
			}
			$ordKey = ord(substr($key, $j, 1));
			$j++;
			$hash .= chr($ordStr - $ordKey);
		}
		return $hash;
	}

	/**
	 * Renders a detail page for News
	 *
	 * @return string
	 */
	public function getCouponsAction()
	{
		$response['coupons'] = [];
		if (ScopeConfiguration::hasCenter()) {
			$couponRecords = $this->couponRepository->listAllForCenter(ScopeConfiguration::getCenterUid());
			$detailLink = '';
			/** @var Coupon $coupon */
			foreach ($couponRecords as $coupon) {
				if (isset($this->settings['detailPages']['coupon'])) {
					$detailLink = $this->uriBuilder
						->reset()
						->setTargetPageUid($this->settings['detailPages']['coupon'])
						->setArguments(['tx_center_coupon' => [
							'controller' => 'Coupon',
							'action' => 'show',
							'coupon' => $coupon->getUid(),
						]])
						->setCreateAbsoluteUri(true)
						->buildFrontendUri();
				}
				$this->view->assign('coupon', $coupon);
				$content = $this->view->render();
				$couponArray = [
					'uid' => $coupon->getUid(),
					'timestamp' => $coupon->getStarttime(),
					'starttime' => $coupon->getStarttime(),
					'endtime' => $coupon->getEndtime(),
					'sender' => $coupon->getSender()->getName(),
					'shop' => null,
					'detail' => [
						'link' => $detailLink,
						'title' => $coupon->getTitle(),
						'abstract' => $coupon->getContentAbstract(),
						'content' => trim($content),
						'date' => $coupon->getDetailDate(),
						'image' => $this->processImageAndGetUrl($coupon->getContentStagemedia(), 1200),
					],
					'teaser' => [
						'title' => $coupon->getTitle(),
						'abstract' => $coupon->getTeaserAbstract(),
						'date' => $coupon->getTeaserDate(),
						'image' => $this->processImageAndGetUrl($coupon->getTeaserImage()),
						'top' => $coupon->getTopInApp(),
					]
				];
				$this->fillShop($coupon, $couponArray);
				$response['coupons'][] = $couponArray;
			}
		}

		return json_encode($response);
	}
}
