<?php
/**
 * Created by PhpStorm.
 * User: Markus
 * Date: 2016-09-28
 * Time: 13:28
 */

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM AS ORM;

/**
 * Class User
 * @package AppBundle\Entity
 * @ORM\Table("user")
 * @ORM\Entity
 */

class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedVAlue(strategy="AUTO")
     */

    protected $id;

}