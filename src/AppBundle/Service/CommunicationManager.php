<?php
/**
 * Created by PhpStorm.
 * User: lundgren
 * Date: 2016-10-24
 * Time: 19:33
 */

namespace AppBundle\Service;


use AppBundle\Entity\Application;
use AppBundle\Entity\AWSInstance;
use AppBundle\Enum\MessageSubjectType;
use Doctrine\ORM\EntityManager;

class CommunicationManager
{
    /**
     * @var \ZMQSocket
     */
    private $queue;

    /**
     * @var string
     */
    private $identity;

    /*
     * @var AWSManager
     */
    private $awsm;

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct($ipcEndpoint, AWSManager $awsManager, EntityManager $em)
    {
        $this->identity = uniqid();
        $this->awsm = $awsManager;
        $this->em = $em;
        $this->queue = new \ZMQSocket(new \ZMQContext(), \ZMQ::SOCKET_REQ);
        $this->queue->setSockOpt(\ZMQ::SOCKOPT_IDENTITY, $this->identity);
        $this->queue->connect("tcp://localhost:4441");
    }

    public function sendApplicationData(Application $application, AWSInstance $awsInstance)
    {
        $data = [];
        $sensors = $application->getSensors();
        $userServerIp = $awsInstance->getPublicIp();
        if($userServerIp == null) {
            $userServerDnsAndIp= $this->awsm->getPublicDnsAndIp($awsInstance->getInstanceId());
            $awsInstance->setPublicDns($userServerDnsAndIp->getDns());
            $awsInstance->setPublicIp($userServerDnsAndIp->getIp());
            $userServerIp = $userServerDnsAndIp->getIp();
            $this->em->persist($awsInstance);
            $this->em->flush();
        }

        $data['subject'] = MessageSubjectType::TYPE_NEW_APPLICATION;
        $data['sender-id'] = (string)$this->identity;
        $data['application-path'] = $application->getCode()->getPathname();
        $data['user-server-ip'] = $userServerIp;
        $data['application-port'] = $application->getPort();
        $data['instance-id'] = $awsInstance->getInstanceId();
        foreach ($sensors as $sensor) {
            $data['uuids'][] = $sensor->getId();
        }

        $jsonData = json_encode($data);
        return ($this->queue->send($jsonData)->recv());
    }

    public function deleteApplication(Application $application, AWSInstance $awsInstance)
    {
        $data = [];
        $sensors = $application->getSensors();
        $userServerIp = $awsInstance->getPublicIp();

        $data['subject'] = MessageSubjectType::TYPE_DELETE_APPLICATION;
        $data['sender-id'] = (string)$this->identity;
        $data['user-server-ip'] = $userServerIp;
        $data['application-port'] = $application->getPort();
        $data['instance-id'] = $awsInstance->getInstanceId();

        foreach ($sensors as $sensor) {
            $data['uuids'][] = $sensor->getId();
        }

        $jsonData = json_encode($data);
        return json_decode($this->queue->send($jsonData)->recv());

    }
}