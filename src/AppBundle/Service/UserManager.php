<?php
/**
 * Created by PhpStorm.
 * User: lundgren
 * Date: 392016-09-28
 * Time: 19:32
 */

namespace AppBundle\Service;

use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class UserManager
{

    /**
     * @var EncoderFactoryInterface
     */
    private $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function createUser()
    {
        return new User();
    }

    /**
     * Updates user password
     * @param User $user
     */
    public function updatePassword(User $user)
    {
        if ($user->getPlainPassword() != null) {
            $encoder = $this->encoderFactory->getEncoder($user);
            $user->setPassword($encoder->encodePassword($user->getPlainPassword(), $user->getSalt()));
            $user->setPlainPassword(null);
        }
    }
}