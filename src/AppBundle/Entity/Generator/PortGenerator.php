<?php
/**
 * Created by PhpStorm.
 * User: lundgren
 * Date: 2016-11-08
 * Time: 23:02
 */

namespace AppBundle\Entity\Generator;


use AppBundle\Entity\Application;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Id\AbstractIdGenerator;

class PortGenerator
{
    const FIRST_PORT = 5556;

    public function generate(EntityManager $em, $entity)
    {
        $user = $entity->getSensors()[0]->getUser();
        $applicationCount = $em->getRepository(Application::class)->getApplicationCountBelongingTo($user);

        return PortGenerator::FIRST_PORT + $applicationCount;
    }
}