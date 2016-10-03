<?php
/**
 * Created by PhpStorm.
 * User: lundgren
 * Date: 392016-09-29
 * Time: 21:01
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Sensor
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="sensors")
 */
class Sensor
{
    /**
     * @var string
     * @ORM\Id
     * @ORM\Column(type="string")
     * @Assert\Uuid(message="This isn't a valid identifier")
     *
     */
    private $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="sensors")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Sensor
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Sensor
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }


}