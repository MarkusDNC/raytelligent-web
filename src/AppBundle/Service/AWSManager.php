<?php
/**
 * Created by PhpStorm.
 * User: lundgren
 * Date: 412016-10-10
 * Time: 13:54
 */

namespace AppBundle\Service;


use AppBundle\DTO\PublicDnsAndIpDto;
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
            'ImageId' => 'ami-10122807',
            'KeyName' => 'amazon-centos',
            'InstanceType' => 't2.micro',
            'MaxCount' => 1,
            'MinCount' => 1,
            'SecurityGroupIds' => ['sg-0073eb7d'],
        ]);

        // TODO: Handle potential failures
        $instanceLaunchedEvent = new InstanceLaunchedEvent($result, $user);
        $this->eventDispatcher->dispatch(InstanceLaunchedEvent::NAME, $instanceLaunchedEvent);

        return true;
    }

    public function getPublicDnsAndIp($instanceId) : PublicDnsAndIpDto
    {
        $publicDnsAndIpDto = new PublicDnsAndIpDto();
        $result = $this->ec2Client->describeInstances([
            'InstanceIds' => [
                $instanceId,
            ],
        ]);

        $publicDnsAndIpDto
            ->setDns($result["Reservations"][0]["Instances"][0]["PublicDnsName"])
            ->setIp($result["Reservations"][0]["Instances"][0]["PublicIpAddress"]);

        return $publicDnsAndIpDto;
    }

}