<?php
/**
 * Created by PhpStorm.
 * User: lundgren
 * Date: 402016-10-03
 * Time: 20:31
 */

namespace AppBundle\Service;


use AppBundle\Entity\Application;
use AppBundle\Enum\SensorUpdateAction;
use Doctrine\ORM\EntityManager;

class SensorManager
{

    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function updateSensors($sensors, Application $application, $action)
    {
        switch ($action) {
            case SensorUpdateAction::ACTION_ADD:
                foreach ($sensors as $sensor) {
                    $sensor->setApplication($application);
                }
                break;
            case SensorUpdateAction::ACTION_REMOVE:
                foreach ($sensors as $sensor) {
                    $sensor->setApplication(null);
                    $this->em->persist($sensor);
                }
                $this->em->flush();
                break;
            default:
                break;
        }

    }

}