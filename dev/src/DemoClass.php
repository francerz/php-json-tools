<?php

namespace Francerz\JsonTools\Dev;

use Francerz\JsonTools\JsonMap;
use Francerz\JsonTools\JsonMappedInterface;
use JsonSerializable;

class DemoClass implements JsonMappedInterface, JsonSerializable
{
    private $alpha;
    private $bravo;
    private $charlie;

    #region Static Methods
    public static function getJsonMaps()
    {
        return [
            new JsonMap('alpha'),
            new JsonMap('bravo'),
            new JsonMap('charlie')
        ];
    }
    #endregion

    public function __construct($alpha = null, $bravo = null, $charlie = null)
    {
        $this->alpha = $alpha;
        $this->bravo = $bravo;
        $this->charlie = $charlie;
    }

    public function jsonSerialize()
    {
        return [
            'alpha' => $this->alpha,
            'bravo' => $this->bravo,
            'charlie' => $this->charlie
        ];
    }
}
