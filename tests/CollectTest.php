<?php

use PHPUnit\Framework\TestCase;
require_once ('src/Collect.php');
require_once ('src/helpers.php');
class CollectTest extends TestCase
{
    public function testKeysAssociativeArray()
    {
        $array = ['a' => 1, 'b' => 2, 'c' => 3];
        $collect = new Collect\Collect($array);
        $keys = $collect->keys();
        $this->assertEquals(['a', 'b', 'c'], $keys->toArray());
    }
    public function testKeysNumericArray(){
        $array = [1 => 'a', 2 => 'b', 3 => 'c'];
        $collect = new Collect\Collect($array);
        $keys = $collect->keys();
        $this->assertEquals([1,2,3], $keys->toArray());
    }
    public function testKeysEmptyArray()
    {
        $array = [];
        $collect = new Collect\Collect($array);
        $keysCollection = $collect->keys();
        $keys = $keysCollection->toArray();
        $this->assertEquals([], $keys);
    }

    public function testValuesAssociativeArray()
    {
        $array = ['a' => 1, 'b' => 2, 'c' => 3];
        $collect = new Collect\Collect($array);
        $keys = $collect->values();
        $this->assertEquals([1, 2, 3], $keys->toArray());
    }
    public function testValuesNumericArray()
    {
        $array = [1 => 'lion', 2 => 'cheetah', 3 => 'leopard'];
        $collect = new Collect\Collect($array);
        $values = $collect->values();
        $expectedValues = ['lion', 'cheetah', 'leopard'];
        $this->assertEquals($expectedValues, $values->toArray());
    }
    public function testValuesEmptyArray()
    {
        $array = [];
        $collect = new Collect\Collect($array);
        $values = $collect->values();
        $this->assertEquals([], $values->toArray());
    }

    public function testGetWithKey()
    {
        $array = ['a' => 'hi!', 'b' => 'bye!'];
        $collect = new Collect\Collect($array);
        $result = $collect->get('a');
        $this->assertEquals('hi!', $result);
    }
    public function testGetWithoutKey()
    {
        $array = ['a' => 'hi!', 'b' => 'bye!'];
        $collect = new Collect\Collect($array);
        $result = $collect->get();
        $this->assertEquals($array, $result);
    }
    public function testExceptWithArray()
    {
        $array = ['red' => 'apple', 'yellow' => 'banana', 'green' => 'grapes'];
        $collect = new Collect\Collect($array);
        $result = $collect->except(['red', 'yellow']);
        $this->assertEquals(['green' => 'grapes'], $result->toArray());
    }
    public function testExceptCountElements()
    {
        $collect = new Collect\Collect(['a' => 1, 'b' => 2, 'c' => 3]);
        $result = $collect->except('a');
        $resultArray = $result->toArray();
        $this->assertCount(2, $resultArray);
    }
    public function testExceptAllKeys(){
        $collect = new Collect\Collect(['a' => 1, 'b' => 2, 'c' => 3]);
        $result = $collect->except('a', 'b', 'c');
        $this->assertCount(0, $result->toArray());
    }

}