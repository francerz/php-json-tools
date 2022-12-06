<?php

namespace Francerz\JsonTools\Dev;

use Francerz\JsonTools\JsonMap;
use Francerz\JsonTools\JsonMappedInterface;
use JsonSerializable;

class TreeNodeClass implements JsonMappedInterface, JsonSerializable
{
    private $childNodes = [];

    public static function getJsonMap()
    {
        return [
            new JsonMap('children', 'childNodes', TreeNodeClass::class)
        ];
    }

    public function jsonSerialize()
    {
        return [
            'children' => $this->childNodes
        ];
    }

    public function addChild(TreeNodeClass $child)
    {
        $this->childNodes[] = $child;
    }
}
