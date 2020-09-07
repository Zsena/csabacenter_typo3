<?php
namespace DigitalZombies\Center\Domain\Repository\Records;

use Doctrine\DBAL\Query\QueryBuilder;
use DigitalZombies\Center\Domain\Model\RecordBase;
use DigitalZombies\Center\Domain\Repository\RecordBaseRepository;
use DigitalZombies\Center\Mapper\RecordBaseDataMapper;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;


/**
 * The repository for blog
 */
class BlogRepository extends RecordBaseRepository {

    /**
     * @param array $blogEntryPages
     * @return array
     */
    public function listAllContentBlogForCenter($blogEntryPages) {
        $contentBlogs = [];
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('tx_center_domain_model_recordbase');

        $records = $queryBuilder->select('rb.*')
            ->from('tx_center_domain_model_recordbase', 'rb')
            ->where($queryBuilder->expr()->in('rb.type', [1,4,135]))
            ->andWhere($queryBuilder->expr()->in('rb.pid', $blogEntryPages))
            ->execute()
            ->fetchAll();

        $resultCount = count($records);

        if ($resultCount > 0) {
            /** @var RecordBaseDataMapper $dataMapper */
            $dataMapper = $this->objectManager->get(RecordBaseDataMapper::class);

            $contentBlogs = $dataMapper->map(RecordBase::class, $records);
        }

        return $contentBlogs;
    }

}