<?php

namespace Francerz\JsonTools;

use ReflectionClass;
use RuntimeException;
use stdClass;

abstract class JsonEncoder
{
    private static function getClassReflection(string $classType)
    {
        /** @var ReflectionClass[] */
        static $classReflections = [];
        if (!isset($classReflections[$classType])) {
            $classReflections[$classType] = new ReflectionClass($classType);
        }
        return $classReflections[$classType];
    }

    private static function getClassPropertiesReflection(string $classType)
    {
        /** @var PropertyReflection[][] */
        static $propRef = [];
        $classRef = static::getClassReflection($classType);
        if (!isset($propRef[$classType])) {
            $props = [];
            foreach ($classRef->getProperties() as $p) {
                $p->setAccessible(true);
                $props[$p->getName()] = $p;
            }
            $propRef[$classType] = $props;
        }
        return $propRef[$classType];
    }

    /**
     * @param string $classType
     * @return JsonMap[]
     */
    private static function getClassJsonMappings(string $classType)
    {
        static $mappings = [];
        if (isset($mappings[$classType])) {
            return $mappings[$classType];
        }
        if (!class_exists($classType)) {
            return [];
        }
        $interfaces = class_implements($classType);
        if (!in_array(JsonMappedInterface::class, $interfaces, true)) {
            return [];
        }

        /** @var JsonMap[] */
        $maps = $classType::getJsonMaps();
        $mappings = [];
        foreach ($maps as $m) {
            $mappings[$m->getJsonAttrName()] = $m;
        }
        return $mappings[$classType] = $mappings;
    }

    public static function encode($data)
    {
        return json_encode($data);
    }

    /**
     * Decodes given json string and tries to cast it to typed objects.
     *
     * Object typing only applies to closest to root objects found in JSON.
     *
     * @param string $jsonString JSON serialized data.
     * @param string $classType Default closest to root level class.
     *
     * @return mixed
     */
    public static function decode(string $jsonString, string $classType = stdClass::class)
    {
        $json = json_decode($jsonString, false);
        if (json_last_error()) {
            throw new RuntimeException("Unable to decode Json String (" . json_last_error_msg() . ").");
        }
        return static::decodeData($json, $classType);
    }

    private static function decodeArray(array $array, string $classType)
    {
        foreach ($array as &$v) {
            $v = static::decodeData($v, $classType);
        }
        return $array;
    }

    private static function decodeObject(object $object, string $classType)
    {
        $ref = static::getClassReflection($classType);
        $maps = static::getClassJsonMappings($classType);
        $prop = static::getClassPropertiesReflection($classType);
        $obj = $ref->newInstanceWithoutConstructor();
        foreach ($object as $k => $v) {
            $type = stdClass::class;
            if (isset($maps[$k]) && ($map = $maps[$k])) {
                $k = $map->getObjectAttrName() ?? $map->getJsonAttrName();
                $type = $map->getAttrType() ?? $type;
            }
            $v = static::decodeData($v, $type);
            isset($prop[$k]) ?
                $prop[$k]->setValue($obj, $v) :
                $obj->$k = $v;
        }
        return $obj;
    }

    private static function decodeData($data, string $classType)
    {
        if (is_array($data)) {
            return static::decodeArray($data, $classType);
        } elseif (is_object($data)) {
            return static::decodeObject($data, $classType);
        }
        return $data;
    }
}
