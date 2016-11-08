<?php
/**
 * Created by PhpStorm.
 * User: lundgren
 * Date: 2016-11-08
 * Time: 22:37
 */

namespace AppBundle\Service;


use Vich\UploaderBundle\Mapping\PropertyMapping;
use Vich\UploaderBundle\Naming\NamerInterface;

class ApplicationUploadNamer implements NamerInterface
{
    public function name($object, PropertyMapping $mapping)
    {
        $file = $mapping->getFile($object);
        $name = $file->getClientOriginalName();

        return uniqid(). '_' . $name;
    }
}