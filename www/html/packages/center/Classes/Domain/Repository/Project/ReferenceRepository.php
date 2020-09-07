<?php
namespace DigitalZombies\Center\Domain\Repository\Project;

use DigitalZombies\Center\Domain\Repository\RecordBaseRepository;


/**
 * The repository for references
 */
class ReferenceRepository extends RecordBaseRepository {

    /**
     * @param $uids
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findByUids($uids)
    {
        $query = $this->createQuery();

        return $query->matching($query->in('uid', $uids))->execute();
    }

    /**
     * @param $uids
     * @return array|\TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findByTags($uids)
    {
        $query = $this->createQuery();

        return $query->matching($query->in('referenceTags.uid', $uids))->execute();
    }

}