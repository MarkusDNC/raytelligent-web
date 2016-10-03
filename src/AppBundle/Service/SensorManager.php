<?php
/**
 * Created by PhpStorm.
 * User: lundgren
 * Date: 402016-10-03
 * Time: 20:31
 */

namespace AppBundle\Service;


use AppBundle\Entity\Application;

class SensorManager
{

    public function updateSensors($sensors, Application $application)
    {
        foreach ($sensors as $sensor) {
            $sensor->setApplication($application);
        }
    }

}