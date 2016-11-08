<?php
/**
 * Created by PhpStorm.
 * User: lundgren
 * Date: 402016-10-03
 * Time: 19:52
 */

namespace AppBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\User;

class ApplicationRepository extends EntityRepository
{
    public function getApplicationsBelongingTo(User $user)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->select('a')
            ->innerJoin('a.sensors', 's')
            ->where('s.user = :user')
            ->setParameter('user', $user);
        return $qb->getQuery()->getResult();
    }

    public function getApplicationCountBelongingTo(User $user)
    {
        $qb = $this->createQueryBuilder('a');
        $qb->select('count(a)')
            ->innerJoin('a.sensors', 's')
            ->where('s.user = :user')
            ->setParameter('user', $user);
        return $qb->getQuery()->getSingleScalarResult();
    }

}