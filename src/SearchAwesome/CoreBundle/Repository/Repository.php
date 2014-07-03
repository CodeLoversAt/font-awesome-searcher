<?php
/**
 * @package font-awesome-searcher
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 02.07.14
 * @time 19:25
 */

namespace SearchAwesome\CoreBundle\Repository;


use Doctrine\ODM\MongoDB\DocumentRepository;

class Repository extends DocumentRepository
{
    /**
     * @param string[] $ids
     *
     * @return array
     */
    public function findByIds(array $ids)
    {
        if (0 === count($ids)) {
            return $this->findAll();
        }

        $idsToUse = array();
        foreach ($ids as $id) {
            $idsToUse[] = new \MongoId($id);
        }

        return $this->createQueryBuilder()
            ->field('_id')->in($idsToUse)
            ->getQuery()
            ->execute()
            ->toArray();
    }
}