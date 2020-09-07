<?php
namespace DigitalZombies\Center\Domain\Repository\Misc;

use TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Resource\ResourceFactory;

/**
 * The repository for gallery
 */
class GalleryRepository extends Repository
{
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
     * Returns all galleries not respecting the storage pid settings
     *
     * @return int
     */
    public function deleteOldGalleries()
    {

        // Step 1: Get all old galleries where endtime is before actual date
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_center_domain_model_misc_gallery');
        $queryBuilder->getRestrictions()->removeAll();
        $galleries = $queryBuilder->select('*')
            ->from('tx_center_domain_model_misc_gallery')
            ->where('endtime < UNIX_TIMESTAMP(NOW())')
            ->andWhere('tx_center_domain_model_misc_gallery.endtime !=0')
            ->andWhere('tx_center_domain_model_misc_gallery.deleted !=0')
            ->execute()
            ->fetchAll();
        $count = (int)count($galleries);

        // Step 2: Set all File references of old galleries to deleted = 1
        foreach ($galleries as $gallery) {
            /** @var QueryBuilder $queryBuilderFileReference */
            $queryBuilderFileReference = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable('sys_file_reference');
            $files = $queryBuilderFileReference->select('uid')
                ->from('sys_file_reference')
                ->where($queryBuilderFileReference->expr()->eq('uid_foreign', $queryBuilderFileReference->createNamedParameter((int)$gallery['uid'])))
                ->andWhere(
                    $queryBuilderFileReference->expr()->eq('tablenames', $queryBuilderFileReference->createNamedParameter('tx_center_domain_model_misc_gallery'))
                )
                ->execute()
                ->fetchAll();
            // Delete files
            $resourceFactory = ResourceFactory::getInstance();
            foreach ($files as $file) {
                $fileReferenceObject = $resourceFactory->getFileReferenceObject($file['uid']);
                // Before deleting the original image check if it exists.
                $fileReferenceObject->getOriginalFile()->delete();
            }

            $queryBuilderMMRecords = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable('tx_center_domain_model_misc_gallery_record_mm');

            // Step 3: Delete Gallery References
            /** @var QueryBuilder $queryBuilderMMRecords */
            $queryBuilderMMRecords->delete('tx_center_domain_model_misc_gallery_record_mm')
                ->where('uid_local =' . (int)$gallery['uid'])
                ->execute();

        }
        // Delete galleries
        $queryBuilder->delete('tx_center_domain_model_misc_gallery')
            ->where('endtime < UNIX_TIMESTAMP(NOW())')
            ->andWhere('tx_center_domain_model_misc_gallery.endtime !=0')
            ->execute();
        return $count;
    }

    /**
     * Returns all galleries to delete in $days
     *
     * @param int $days
     * @return array
     */
    public function findGalleriesToDelete($days = 11)
    {
        $secondsLeftToDelete = (int)($days * 24 * 60 * 60);
        $notifyTill = (int)(($days - 1) * 24 * 60 * 60);
        // Step 1: Get all old galleries where endtime is before actual date
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_center_domain_model_misc_gallery');
        $queryBuilder->getRestrictions()->removeAll();
        $galleries = $queryBuilder->select('*')
            ->from('tx_center_domain_model_misc_gallery')
            ->where($secondsLeftToDelete . ' + UNIX_TIMESTAMP(NOW()) > endtime')
            ->andWhere($notifyTill . ' + UNIX_TIMESTAMP(NOW()) < endtime')
            ->andWhere('tx_center_domain_model_misc_gallery.endtime !=0')
            ->andWhere('tx_center_domain_model_misc_gallery.deleted =0')
            ->execute()
            ->fetchAll();



        return $galleries;
    }
}