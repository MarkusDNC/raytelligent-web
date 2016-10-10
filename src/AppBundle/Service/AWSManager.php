<?php
/**
 * Created by PhpStorm.
 * User: lundgren
 * Date: 412016-10-10
 * Time: 13:54
 */

namespace AppBundle\Service;


use AppBundle\Entity\User;
use AppBundle\Event\InstanceLaunchedEvent;
use Aws\Ec2\Ec2Client;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class AWSManager
{
    /**
     * @var Ec2Client
     */
    private $ec2Client;

    /**
     * @var string
     */
    private $imageId;

    /**
     * @var string
     */
    private $instanceType;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(Ec2Client $ec2Client, $imageId, $instanceType, EventDispatcherInterface $eventDispatcher)
    {
        $this->ec2Client = $ec2Client;
        $this->imageId = $imageId;
        $this->instanceType = $instanceType;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function launchNewInstance($instanceName, User $user)
    {
        $result = $this->ec2Client->runInstances([
            'ImageId' => $this->imageId,
            'InstanceType' => $this->instanceType,
            'MaxCount' => 1,
            'MinCount' => 1,
        ]);

        // TODO: Handle potential failures
        $instanceLaunchedEvent = new InstanceLaunchedEvent($result, $user);
        $this->eventDispatcher->dispatch($instanceLaunchedEvent);

        return true;
    }

}