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

}