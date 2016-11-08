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
        $this->queue->connect("tcp://192.168.1.110:5555");
    }

    public function sendApplicationData(Application $application, AWSInstance $awsInstance)
    {
        $data = [];
        $sensors = $application->getSensors();
        $userEndpoint = $awsInstance->getPublicDns();
        if($userEndpoint == null) {
            /*$userEndpoint = $this->awsm->getEndpoint($awsInstance->getInstanceId());
            $awsInstance->setPublicDns($userEndpoint);
            $this->em->persist($awsInstance);
            $this->em->flush();*/
            $userEndpoint = "192.168.1.120:5556";
        }

        $data['subject'] = MessageSubjectType::TYPE_NEW_APPLICATION;
        $data['sender-id'] = (string)$this->identity;
        $data['application-path'] = $application->getCode()->getPathname();
        $data['user-endpoint'] = $userEndpoint;

        foreach ($sensors as $sensor) {
            $data['uuids'][] = $sensor->getId();
        }
        dump($application);
        exit;
        $jsonData = json_encode($data);
        return $this->queue->send($jsonData)->recv();
    }
}