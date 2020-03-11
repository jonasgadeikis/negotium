<?php

namespace App\Utilities;

use JMS\Serializer\DeserializationContext;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;

trait SerializationTrait
{
    public function serialize($data, $format, $groups = null)
    {
        $serializer = SerializerBuilder::create()->build();
        $result = $serializer->serialize(
            $data,
            $format,
            SerializationContext::create()->setGroups($groups)
        );

        return $result;
    }

    public function deserialize($data, $object, $format)
    {
        $serializer = SerializerBuilder::create()->build();
        $result = $serializer->deserialize($data, $object, $format);

        return $result;
    }
}