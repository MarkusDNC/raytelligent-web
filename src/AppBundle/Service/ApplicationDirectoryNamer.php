<?php
/**
 * Created by PhpStorm.
 * User: lundgren
 * Date: 2016-11-08
 * Time: 22:33
 */

namespace AppBundle\Service;


use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\DirectoryNamerInterface;

class ApplicationDirectoryNamer implements DirectoryNamerInterface
{
    public function directoryName($object, PropertyMapping $mapping)
    {
        $user = $object->getSensors()[0]->getUser();
        return 'user-' . $user->getId();
    }
}