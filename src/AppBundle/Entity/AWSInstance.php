<?php
/**
 * Created by PhpStorm.
 * User: lundgren
 * Date: 412016-10-10
 * Time: 18:04
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;
use AppBundle\Entity\User;

/**
 * Class AWSInstance
 * @package AppBundle\Entity
 * @ORM\Table(name="instances")
 * @ORM\Entity()
 *
 */
class AWSInstance
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer
     */
    private $id;

    /**
     * @ORM\Column(name="reservation_id", type="string")
     *
     * @var string
     */
    private $reservationId;

    /**
     * @ORM\Column(name="instance_id", type="string")
     *
     * @var string
     */
    private $instanceId;

    /**
     * @ORM\Column(name="launch_date", type="datetime")
     *
     * @var \DateTime
     */
    private $launchDate;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     *
     * @var User
     */
    private $user;

    /**
     * @ORM\Column(name="public_dns", type="string", nullable=true)
     *
     * @var string
     */
    private $publicDns;

    /**
     * @ORM\Column(name="public_ip", type="string", nullable=true)
     *
     * @var string
     */
    private $publicIp;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return AWSInstance
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getReservationId()
    {
        return $this->reservationId;
    }

    /**
     * @param string $reservationId
     * @return AWSInstance
     */
    public function setReservationId($reservationId)
    {
        $this->reservationId = $reservationId;

        return $this;
    }

    /**
     * @return string
     */
    public function getInstanceId()
    {
        return $this->instanceId;
    }

    /**
     * @param string $instanceId
     * @return AWSInstance
     */
    public function setInstanceId($instanceId)
    {
        $this->instanceId = $instanceId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLaunchDate()
    {
        return $this->launchDate;
    }

    /**
     * @param mixed $launchDate
     * @return AWSInstance
     */
    public function setLaunchDate($launchDate)
    {
        $this->launchDate = $launchDate;

        return $this;
    }

    /**
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param \AppBundle\Entity\User $user
     * @return AWSInstance
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string
     */
    public function getPublicDns()
    {
        return $this->publicDns;
    }

    /**
     * @param string $publicDns
     * @return AWSInstance
     */
    public function setPublicDns($publicDns)
    {
        $this->publicDns = $publicDns;

        return $this;
    }

    /**
     * @return string
     */
    public function getPublicIp()
    {
        return $this->publicIp;
    }

    /**
     * @param string $publicIp
     * @return AWSInstance
     */
    public function setPublicIp(string $publicIp): AWSInstance
    {
        $this->publicIp = $publicIp;

        return $this;
    }




}