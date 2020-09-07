<?php
namespace DigitalZombies\Center\Domain\Repository\Shop;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\EndTimeRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\HiddenRestriction;
use TYPO3\CMS\Core\Database\Query\Restriction\StartTimeRestriction;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;


/**
 * The repository for chain stores
 */
class CenterShopRepository extends Repository {
    /**
     *
     */
    public function initializeObject() {
        /** @var $defaultQuerySettings \TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface */
        $defaultQuerySettings = $this->objectManager->get(QuerySettingsInterface::class);
        $defaultQuerySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($defaultQuerySettings);
    }

    /**
     * Update Inline Centershop Record of diverse Records
     * @param string $table
     * @param string $tableOrigin
     * @param int $record
     * @param string $fieldName
     * @param int $centerUid
     * @return  void
     */
    public function updateRecordWithNewCenter($table, $record, $fieldName, $centerUid, $tableOrigin ) {
        $localizedRecords = $this->getLocalizedRecords($tableOrigin, $record);
        $i=0;
        $rec= "";
        $num = count($localizedRecords);
        foreach ($localizedRecords as $key => $value) {
            $rec .= $value['uid'];
            if($i>0&&$num>$i)
            {$value['uid'].=",";};
            $i++;
        }

        /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable($table);
        $queryBuilder->update($table)
            ->where ($queryBuilder->expr()->eq($fieldName,$record))
            ->set('center',$centerUid);
        if($rec!=""){
            $queryBuilder->orWhere($queryBuilder->expr()->in($fieldName,$rec));
        }
        $queryBuilder->execute();
    }

    /**
     * Get Pid of Storage Folder
     * @param int $id
     * @param string $table
     * @return  int
     */
    public function getStoragePid($id, $table) {

        /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable($table);
        $queryBuilder->getRestrictions()
            ->removeByType(EndTimeRestriction::class)
            ->removeByType(StartTimeRestriction::class)
            ->removeByType(DeletedRestriction::class)
            ->removeByType(HiddenRestriction::class);
        $pid = $queryBuilder->select('pid')
            ->from($table)
            ->where($queryBuilder->expr()->eq('uid',$id))
            ->execute()
            ->fetchAll();
        return $pid[0]['pid'];
    }

    /**
     * Update Inline Centershop Record of diverse Records
     * @param string $tableOrigin
     * @param int $record
     * @return  array
     */
    public function getLocalizedRecords($tableOrigin, $record) {
        /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable($tableOrigin);

        $queryBuilder->getRestrictions()
            ->removeByType(EndTimeRestriction::class)
            ->removeByType(StartTimeRestriction::class)
            ->removeByType(DeletedRestriction::class)
            ->removeByType(HiddenRestriction::class);
        $result = $queryBuilder->select('uid')
            ->from($tableOrigin)
            ->where ($queryBuilder->expr()->eq('l10n_parent',$record))
            ->execute()
            ->fetchAll();
        return $result;
    }

    /**
     * Delete connections between shops and chainstore if attached chainstore is deleted.
     * @param int $uid
     * @return  void
     */
    public function updateShopAfterChainstoreDeletion($uid){

        /** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('pages');
        $queryBuilder->getRestrictions()->removeAll();
        $queryBuilder->update('pages')
            ->where('chain_store =' . $uid)
            ->set('chain_store_tags', '0')
            ->set('chain_store_contact', '0')
            ->set('chain_store_text', '0')
            ->set('chain_store', '0')
            ->execute();
        return;
    }


}