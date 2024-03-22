<?php

use PHPUnit\Framework\TestCase;
require_once ('src/Collect.php');
require_once ('src/helpers.php');
class CollectTest extends TestCase
{
    public function testCount()
    {
        $collect = new Collect\Collect([13,17]);
        $this->assertSame(2, $collect->count());
    }
    public function testKeysAssociativeArray()
    {
        $array = ['a' => 1, 'b' => 2, 'c' => 3];
        $collect = new Collect\Collect($array);
        $keys = $collect->keys();
        $this->assertEquals(['a', 'b', 'c'], $keys->toArray());
    }
    public function testKeysEmptyArray()
    {
        $array = [];
        $collect = new Collect\Collect($array);
        $keysCollection = $collect->keys();
        $keys = $keysCollection->toArray();
        $this->assertEquals([], $keys);
    }
    public function testKeysNumericArray(){
        $array = [1 => 'a', 2 => 'b', 3 => 'c'];
        $collect = new Collect\Collect($array);
        $keys = $collect->keys();
        $this->assertEquals([1,2,3], $keys->toArray());
    }
    public function testValues()
    {
        //Тест с числовыми ключами
        $array = [1 => 'apple', 2 => 'banana', 3 => 'cherry'];
        $collection = new Collect\Collect($array);
        $valuesCollection = $collection->values();
        $values = $valuesCollection->toArray();
        $expectedValues = ['apple', 'banana', 'cherry'];
        $this->assertEquals($expectedValues, $values);

    }
}