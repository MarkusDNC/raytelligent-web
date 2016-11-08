<?php
/**
 * Created by PhpStorm.
 * User: lundgren
 * Date: 412016-10-10
 * Time: 17:43
 */

namespace AppBundle\EventListener;

use AppBundle\Entity\AWSInstance;
use AppBundle\Event\InstanceLaunchedEvent;
use Doctrine\ORM\EntityManager;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PersistInstanceInfoListener implements EventSubscriberInterface
{

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            InstanceLaunchedEvent::NAME => 'onInstanceLaunched'
        ];
    }

    public function onInstanceLaunched(InstanceLaunchedEvent $instanceLaunchedEvent)
    {
        $user = $instanceLaunchedEvent->getUser();
        $result = $instanceLaunchedEvent->getResult();
        $instances = $result->get('Instances');
        dump($instances);
        $instance = new AWSInstance();
        $instance->setInstanceId($instances[0]['InstanceId'])
                ->setReservationId($result->get('ReservationId'))
                ->setLaunchDate($instances[0]['LaunchTime'])
                ->setUser($user);
        $this->em->persist($instance);
        $this->em->flush();
    }
}