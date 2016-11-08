<?php
/**
 * Created by PhpStorm.
 * User: lundgren
 * Date: 2016-10-24
 * Time: 19:33
 */

namespace AppBundle\Service;


use AppBundle\Entity\Application;
use AppBundle\Enum\MessageSubjectType;

class CommunicationManager
{
    /**
     * @var \ZMQSocket
     */
    private $queue;

    private $identity;

    public function __construct($ipcEndpoint)
    {
        $this->identity = openssl_random_pseudo_bytes(16);
        $this->queue = new \ZMQSocket(new \ZMQContext(), \ZMQ::SOCKET_REQ, "test-socket");
        $this->queue->setSockOpt(\ZMQ::SOCKOPT_IDENTITY, $this->identity);
        $this->queue->connect($ipcEndpoint);
    }

    public function sendApplicationData(Application $application)
    {
        $data = [];
        $sensors = $application->getSensors();
        $fileName = $application->getFileName();

        $data['subject'] = MessageSubjectType::TYPE_NEW_APPLICATION;
        $data['sender-id'] = $this->identity;
        $data['application-path'] = $fileName;
        $data['user-endpoint'] = ''; // TODO: Get user endpoint

        foreach ($sensors as $sensor) {
            $data['uuids'][] = $sensor->getId();
        }

        $jsonData = json_encode($data);
        return json_decode($this->queue->send($jsonData)->recv());
    }
}