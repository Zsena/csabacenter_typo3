<?php

namespace DigitalZombies\Center\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Database\Query\Restriction\DeletedRestriction;

/**
 * The repository for record base
 */
class FalRepository extends ResourceFactory
{


    /**
     * grabs falimage
     * @param int $pid
     * @param string $table
     * @param string $fieldName
     * @return \TYPO3\CMS\Core\Resource\FileReference
     */
    public static function resolveImage($pid, $table, $fieldName)
    {
    	/** @var \TYPO3\CMS\Core\Database\Query\QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('sys_file_reference');

        /** @var DeletedRestriction $deleteRestriction */
        $deleteRestriction = GeneralUtility::makeInstance(DeletedRestriction::class);
        $queryBuilder->getRestrictions()->removeAll()->add($deleteRestriction);
        $fileReferenceData = $queryBuilder->select('*')
            ->from('sys_file_reference')
            ->where(
                $queryBuilder->expr()->eq(
                    'uid_foreign',
                    $queryBuilder->createNamedParameter($pid, \PDO::PARAM_INT)
                )
            )
			->andWhere(
				$queryBuilder->expr()->eq(
					'tablenames',
					$queryBuilder->createNamedParameter($table, \PDO::PARAM_STR)
				)
			)
            ->andWhere(
                $queryBuilder->expr()->eq(
                    'fieldname',
                    $queryBuilder->createNamedParameter($fieldName, \PDO::PARAM_STR)
                )
            )
            ->execute()
            ->fetch();
        return $fileReferenceData;
    }
}