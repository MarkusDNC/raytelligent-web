<?php
/**
 * Created by PhpStorm.
 * User: lundgren
 * Date: 2016-10-24
 * Time: 19:33
 */

namespace AppBundle\Service;


use AppBundle\Entity\Application;

class CommunicationManager
{
    /**
     * @var \ZMQSocket
     */
    private $queue;

    public function __construct($ipcEndpoint)
    {
        $this->queue = new \ZMQSocket(new \ZMQContext(), \ZMQ::SOCKET_REQ, "test-socket");
        $this->queue->connect($ipcEndpoint);
    }

    public function sendApplicationData(Application $application)
    {
        $data = [];
        $sensors = $application->getSensors();
        $fileName = $application->getFileName();

        $data['file-name'] = $fileName;

        foreach ($sensors as $sensor) {
            $data['sensors'][] = $sensor->getId();
        }

        $jsonData = json_encode($data);
        return $this->queue->send($jsonData)->recv();
    }
}