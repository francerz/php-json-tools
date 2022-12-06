<?php

namespace Francerz\JsonTools\Tests;

use Francerz\JsonTools\Dev\DemoClass;
use Francerz\JsonTools\Dev\TreeNodeClass;
use Francerz\JsonTools\JsonEncoder;
use PHPUnit\Framework\TestCase;
use stdClass;

class JsonEncoderTest extends TestCase
{
    public function testEncode()
    {
        $obj = new DemoClass(1, 2, 3);

        $json = JsonEncoder::encode($obj);
        $this->assertEquals('{"alpha":1,"bravo":2,"charlie":3}', $json);
    }

    public function testDecode()
    {
        $obj = JsonEncoder::decode('{"alpha":1,"bravo":2,"charlie":3,"delta":4}', DemoClass::class);

        $expected = new DemoClass(1, 2, 3);
        $expected->delta = 4;
        $this->assertEquals($expected, $obj);
    }

    public function testDecodeStdClass()
    {
        $obj = JsonEncoder::decode('{"a":1,"b":2}');

        $expected = new stdClass();
        $expected->a = 1;
        $expected->b = 2;
        $this->assertEquals($expected, $obj);
    }

    public function testDecodeNestedObjects()
    {
        $obj = JsonEncoder::decode('{"a":{"b":1,"c":2}}');

        $expected = new stdClass();
        $expected->a = new stdClass();
        $expected->a->b = 1;
        $expected->a->c = 2;
        $this->assertEquals($expected, $obj);
    }

    public function testEncodeTreeNodes()
    {
        $child = new TreeNodeClass();
        $root = new TreeNodeClass();
        $root->addChild($child);

        $json = JsonEncoder::encode($root);

        $this->assertEquals('{"children":[{"children":[]}]}', $json);

        $actual = JsonEncoder::decode($json, TreeNodeClass::class);
        $this->assertEquals($root, $actual);

        $notActual = JsonEncoder::decode($json);
        $this->assertNotEquals($root, $notActual);
    }
}
