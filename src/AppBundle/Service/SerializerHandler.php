<?php

namespace AppBundle\Service;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\PropertyInfo\Type;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;

use AppBundle\Entity\Person;
use AppBundle\Entity\People;
use AppBundle\Service\PeopleTypeExtractor;


class SerializerHandler
{

    static public function getSerializer() {

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = [new ObjectNormalizer(), new ArrayDenormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        return $serializer;

    }

    static public function unserialzeArray($className, array $data)
    {
        $reflectionClass = new \ReflectionClass($className);
        $object = $reflectionClass->newInstanceWithoutConstructor();

        foreach ($data as $property => $value) {
            if (!$reflectionClass->hasProperty($property)) {
                throw new \Exception(sprintf(
                    'Class "%s" does not have property "%s"',
                    $className,
                    $property
                ));
            }

            $reflectionProperty = $reflectionClass->getProperty($property);
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($object, $value);
        }

        return $object;
    }

}