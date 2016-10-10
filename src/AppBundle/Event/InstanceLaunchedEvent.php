<?php
/**
 * Created by PhpStorm.
 * User: lundgren
 * Date: 412016-10-10
 * Time: 17:35
 */

namespace AppBundle\Event;

use AppBundle\Entity\User;
use Aws\Result;
use Symfony\Component\EventDispatcher\Event;

class InstanceLaunchedEvent extends Event
{
    const NAME = 'rt.instance.launched';

    /**
     * @var Result
     */
    private $result;

    /**
     * @var User
     */
    private $user;


    public function __construct(Result $result, User $user)
    {
        $this->result = $result;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function getUser()
    {
        return $this->user;
    }

}