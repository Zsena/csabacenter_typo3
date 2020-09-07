<?php

namespace DigitalZombies\Center\Domain\Repository\Misc;

use DigitalZombies\Center\Constants\HideInApp;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use DigitalZombies\Center\Domain\Model\Records\Coupon;
use DigitalZombies\Center\Mapper\RecordBaseDataMapper;

/**
 * The repository for offers
 */
class CouponRepository extends Repository
{
    /**
     * Updates coupon record with new amount
     * @param int $uid
     * @param int $newAmount
     * @return void
     */
    public function setAmount($uid, $newAmount)
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_center_domain_model_records_coupon');
        $queryBuilder->getRestrictions()->removeAll();
        $queryBuilder->update('tx_center_domain_model_records_coupon')
            ->where('tx_center_domain_model_records_coupon.uid =' . $uid)
            ->set('coupons_redeemed', $newAmount)
            ->execute();
        return;
    }

    /**
     * Updates coupon record with new amount
     * @param int $uid
     * @param int $userUid
     * @return void
     */
    public function flagCouponWithUser($uid, $userUid)
    {
        if ($userUid) {
            /** @var QueryBuilder $queryBuilder */
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable('tx_center_domain_model_coupons_user');
            $queryBuilder->getRestrictions()->removeAll();
            $queryBuilder->insert('tx_center_domain_model_coupons_user')
                ->values([
                    'uid_coupon' => $uid,
                    'uid_user' => $userUid
                ])
                ->execute();
        }
        return;
    }

    /**
     * Check if Coupon is already redeemded by FE User
     * @param int $uid
     * @param int $couponUid
     * @return boolean $result
     */
    public function checkIfCouponIsRedeemedByFEUser($uid, $couponUid)
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_center_domain_model_coupons_user');
        $queryBuilder->getRestrictions()->removeAll();

        if ($uid) {
            $matches = $queryBuilder->select('*')
                ->from('tx_center_domain_model_coupons_user')
                ->where('uid_coupon =' . $couponUid)
                ->andWhere('uid_user =' . $uid)
                ->execute()
                ->fetchAll();

            if ($matches) {
                return true;
            }
        }

        return false;
    }

    /**
     * Updates old coupons and sets deleted to 1
     * @param int $period
     * @return int
     */
    public function deleteOldCoupons($period)
    {
        $days = $period * 24 * 60 * 60;
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_center_domain_model_records_coupon');
        $queryBuilder->getRestrictions()->removeAll();
        return $queryBuilder->update('tx_center_domain_model_records_coupon')
            ->where('tx_center_domain_model_records_coupon.endtime +' . $days . '< UNIX_TIMESTAMP(NOW())')
            ->andWhere('tx_center_domain_model_records_coupon.endtime !=0')
            ->set('deleted', '1')
            ->execute();
    }

    /**
     * @param $centerId
     * @return array
     */
    public function listAllForCenter($centerId)
    {
        $coupon = [];
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_center_domain_model_records_coupon');

        $records = $queryBuilder->select('coupon.*')
            ->from('tx_center_domain_model_records_coupon', 'coupon')
            ->leftJoin('coupon',
                'tx_center_domain_model_records_center_mm',
                'centers',
                "centers.uid_foreign = coupon.uid AND centers.tablenames = 'tx_center_domain_model_records_coupon'")
            ->orWhere($queryBuilder->expr()->eq('centers.uid_local', $centerId),
                ($queryBuilder->expr()->eq('coupon.center', $centerId)))
            ->andWhere($queryBuilder->expr()->in('coupon.hide_in_app',
                [HideInApp::NO_RESTRICTION, HideInApp::ONLY_IN_APP]))
            ->andWhere($queryBuilder->expr()->eq('sys_language_uid', 0))
            ->groupBy('coupon.uid')
            ->execute()
            ->fetchAll();

        $resultCount = count($records);

        if ($resultCount > 0) {
            /** @var RecordBaseDataMapper $dataMapper */
            $dataMapper = $this->objectManager->get(RecordBaseDataMapper::class);

            $coupon = $dataMapper->map(Coupon::class, $records, Coupon::TABLE_NAME);
        }

        return $coupon;
    }
}

