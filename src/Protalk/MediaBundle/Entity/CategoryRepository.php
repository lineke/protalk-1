<?php

/**
 * ProTalk
 *
 * Copyright (c) 2012-2013, ProTalk
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Protalk\MediaBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends EntityRepository
{
    /**
     * Get the most used categories
     *
     * @param  int      $max
     * @return Doctrine Collection
     */
    public function getMostUsedCategories($max = 20)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('c.slug', 'c.name', 'COUNT(m.id) as mediaCount');
        $qb->from('\Protalk\MediaBundle\Entity\Category', 'c');
        $qb->join('c.medias', 'm');
        $qb->where('m.isPublished = 1');
        $qb->groupBy('c.slug');
        $qb->orderBy('mediaCount', 'DESC');
        $qb->setMaxResults($max);

        $query = $qb->getQuery();

        return $query->execute();
    }

    /**
     * Get all used categories
     *
     * @return Doctrine Collection
     */
    public function getAllCategories()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('c.slug', 'c.name', 'COUNT(m.id) as mediaCount');
        $qb->from('\Protalk\MediaBundle\Entity\Category', 'c');
        $qb->join('c.medias', 'm');
        $qb->where('m.isPublished = 1');
        $qb->groupBy('c.slug');
        $qb->orderBy('c.name', 'ASC');

        $query = $qb->getQuery();

        return $query->execute();
    }
}
