<?php
/**
 * Created by PhpStorm.
 * User: lundgren
 * Date: 402016-10-03
 * Time: 18:50
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping AS ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class Application
 * @package AppBundle\Entity
 * @ORM\Table(name="applications")
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Application
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
     * @var string
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Field can not be left blank")
     * @Assert\Length(max="255", maxMessage="The location is too long")
     */
    private $location;

    /**
     * @var Sensor
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Sensor", inversedBy="application")
     * @ORM\JoinColumn(name="sensor_id", referencedColumnName="id")
     * @Assert\NotBlank(message="Field can not be left blank")
     */
    private $sensor;

    /**
     * @var File
     * @Vich\UploadableField(mapping="application_code", fileNameProperty="fileName")
     * @Assert\NotBlank(message="Field can not be left blank")
     */
    private $code;


    /**
     * @var string
     * @ORM\Column(name="file_name", type="string", length=255)
     */
    private $fileName;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Application
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     * @return Application
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Sensor
     */
    public function getSensor()
    {
        return $this->sensor;
    }

    /**
     * @param Sensor $sensor
     * @return Application
     */
    public function setSensor($sensor)
    {
        $this->sensor = $sensor;

        return $this;
    }

    /**
     * @return File
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param File $code
     * @return Application
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     * @return Application
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }


}