<?php
/**
 * Created by PhpStorm.
 * User: Markus
 * Date: 2016-09-28
 * Time: 13:28
 */

namespace AppBundle\Entity;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Doctrine\ORM\Mapping AS ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Rollerworks\Bundle\PasswordStrengthBundle\Validator\Constraints as Security;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class User
 * @package AppBundle\Entity
 * @ORM\Table("users")
 * @ORM\Entity
 * @UniqueEntity("email")
 */

class User implements AdvancedUserInterface
{
    /**
     * Just during registration
     * @Assert\NotBlank(message="Field can not be left blank")
     * @Security\PasswordRequirements(
     *     minLength=8,
     *     requireCaseDiff=true,
     *     requireNumbers=true,
     *     requireLetters=true,
     *     tooShortMessage="Password too short",
     *     missingLettersMessage="Password does not contain any letters",
     *     requireCaseDiffMessage="Password does not contain letters with different case",
     *     missingNumbersMessage="Password does not contain any numbers",
     * )
     * @var string
     */
    protected $plainPassword;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @Assert\Length(max="255", maxMessage="Email address is too long")
     * @Assert\Email(message="Invalid email address")
     * @Assert\NotBlank(message="Field can not be left blank")
     * @var string
     */
    protected $email;


    /**
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     * @Assert\Length(max="255", maxMessage="Password is too long")
     *
     * @var string
     */
    protected $password;

    /**
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=false)
     *
     * @var string
     */
    protected $salt;


    /**
     *
     * @ORM\Column(name="first_name", type="string", length=50, nullable=true)
     * @Assert\Length(max="50", maxMessage="Name is too long")
     * @Assert\NotBlank(message="Field can not be left blank")
     *
     * @var string
     */
    protected $firstName;

    /**
     *
     * @ORM\Column(name="last_name", type="string", length=50, nullable=true)
     * @Assert\Length(max="50", maxMessage="Name is too long")
     * @Assert\NotBlank(message="Field can not be left blank")
     *
     * @var string
     */
    protected $lastName;


    /**
     *
     * @ORM\Column(name="address1", type="string", length=50, nullable=true)
     * @Assert\Length(max="50", maxMessage="Address is too long")
     * @Assert\NotBlank(message="Field can not be left blank")
     *
     * @var string
     */
    protected $address1;

    /**
     *
     * @ORM\Column(name="address2", type="string", length=50, nullable=true)
     * @Assert\Length(max="50", maxMessage="Address is too long")
     *
     * @var string
     */
    protected $address2;

    /**
     *
     * @ORM\Column(name="city", type="string", length=30, nullable=true)
     * @Assert\Length(max="30", maxMessage="City is too long")
     * @Assert\NotBlank(message="Field can not be left blank")
     *
     * @var string
     */
    protected $city;

    /**
     *
     * @ORM\Column(name="post_code", type="string", length=10, nullable=true)
     * @Assert\Length(max="10", maxMessage="Post code is too long")
     * @Assert\NotBlank(message="Field can not be left blank")
     *
     * @var string
     */
    protected $postCode;

    /**
     *
     * @ORM\Column(name="country", type="string", length=2, nullable=true)
     * @Assert\Length(max="2", maxMessage="Country is too long")
     * @Assert\NotBlank(message="Field can not be left blank")
     * @Assert\Country(message="Invalid country")
     *
     * @var string
     */
    protected $country;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     * @return User
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @param string $address1
     * @return User
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;

        return $this;
    }

    /**
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @param string $address2
     * @return User
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return User
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getPostCode()
    {
        return $this->postCode;
    }

    /**
     * @param string $postCode
     * @return User
     */
    public function setPostCode($postCode)
    {
        $this->postCode = $postCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     * @return User
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    public function getRoles()
    {
        return array('ROLE_USER');
    }


    public function getUsername()
    {
        return $this->getEmail();
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    function isEnabled()
    {
        return true;
    }

    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
            $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->email,
            $this->password,
            $this->salt
            ) = unserialize($serialized);
    }
}