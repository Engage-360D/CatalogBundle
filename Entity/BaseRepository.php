<?php

/*
 * This file is part of the Engage360d Catalog Bundle
 *
 * (c) Aliocha Ryzhkov <alioch@yandex.ru>
 */

namespace Engage360d\Bundle\CatalogBundle\Entity;

use Doctrine\ORM\EntityRepository;

class BaseRepository extends EntityRepository
{
    /**
     * @param integer $page
     * @param integer $limit
     * @param array $order Sorting options
     *  Format of the $order argument:
     *      $order = array(
     *          array(
     *              'property' = > 'createdAt',
     *              'direction' => 'ASC',
     *          ),
     *      )
     *
     * @return array
     */
    public function findSubset($page, $limit, $order = array())
    {
        $qb = $this->createQueryBuilder('entity');

        foreach ($order as $set) {
            if (isset($set['property']) && isset($set['direction'])) {
                $qb->orderBy('entity.' . $set['property'], $set['direction']);
            }
        }

        $qb->setFirstResult(($page - 1) * $limit)
            ->setMaxResults($limit);

        return $qb->getQuery()->getResult();
    }

    public function findRecords($catalogId, $page = null, $limit = null)
    {
        $qb = $this->createQueryBuilder('rec');

        $qb->innerJoin('rec.catalog', 'c')
            ->where('c.id = :catalogId')
            ->setParameter('catalogId', $catalogId)
            ->orderBy('rec.order', 'ASC');

        if ($page && $limit) {
            $qb->setFirstResult(($page - 1) * $limit)
                ->setMaxResults($limit);
        }

        return $qb->getQuery()->getResult();
    }
}