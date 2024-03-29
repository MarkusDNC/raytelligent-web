<?php
/**
 * Created by PhpStorm.
 * User: lundgren
 * Date: 402016-10-03
 * Time: 19:32
 */

namespace AppBundle\Entity\Repository;


use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\User;

class SensorRepository extends EntityRepository
{

    public function getSensorsBelongingTo(User $user)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->select('s')
            ->where('s.user = :user')
            ->setParameter('user', $user);
        return $qb->getQuery()->getResult();
    }

    public function getApplicationsBelongingTo(User $user)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->select('s')
            ->innerJoin('s.application', 'a')
            ->where('s.user = :user')
            ->setParameter('user', $user);
        return $qb->getQuery()->getResult();
    }

    public function getApplicableSensorsBelongingTo(User $user)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->select('s')
            ->where('s.user = :user')
            ->andWhere('s.application is null')
            ->setParameter('user', $user);
        return $qb->getQuery()->getResult();
    }

}