<?php

namespace App\DTO;

class Filler
{
    public function fill(array $data, object &$dataTransformObject)
    {
        foreach ($data as $property => $value) {

            if (!property_exists($dataTransformObject, $property)) {
                throw new NotExistingProperty(sprintf(
                        'The %s property does not exist in class %s',
                        $property,
                        get_class($dataTransformObject))
                );
            }

            $dataTransformObject->$property = $value;
        }
    }
}
