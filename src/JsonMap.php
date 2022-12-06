<?php

namespace Francerz\JsonTools;

class JsonMap
{
    private $jsonAttrName;
    private $objectAttrName;
    private $attrType;

    public function __construct($jsonAttrName, $objectAttrName = null, $attrType = null)
    {
        $this->jsonAttrName = $jsonAttrName;
        $this->objectAttrName = $objectAttrName;
        $this->attrType = $attrType;
    }

    public function getJsonAttrName()
    {
        return $this->jsonAttrName;
    }

    public function getObjectAttrName()
    {
        return $this->objectAttrName;
    }

    public function getAttrType()
    {
        return $this->attrType;
    }
}
