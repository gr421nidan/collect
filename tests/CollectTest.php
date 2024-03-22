<?php

use PHPUnit\Framework\TestCase;
require_once ('src/Collect.php');
require_once ('src/helpers.php');
class CollectTest extends TestCase
{
    // Тест на ассоциативный массив
    public function testKeysAssociativeArray()
    {
        $array = ['a' => 1, 'b' => 2, 'c' => 3];
        $collect = new Collect\Collect($array);
        $keys = $collect->keys();
        $this->assertEquals(['a', 'b', 'c'], $keys->toArray());
    }
    // Тест на числовые ключи массива
    public function testKeysNumericArray(){
        $array = [1 => 'a', 2 => 'b', 3 => 'c'];
        $collect = new Collect\Collect($array);
        $keys = $collect->keys();
        $this->assertEquals([1,2,3], $keys->toArray());
    }
    // Тест на пустой массив
    public function testKeysEmptyArray()
    {
        $array = [];
        $collect = new Collect\Collect($array);
        $keysCollection = $collect->keys();
        $keys = $keysCollection->toArray();
        $this->assertEquals([], $keys);
    }
    // Тест на ассоциативный массив
    public function testValuesAssociativeArray()
    {
        $array = ['a' => 1, 'b' => 2, 'c' => 3];
        $collect = new Collect\Collect($array);
        $keys = $collect->values();
        $this->assertEquals([1, 2, 3], $keys->toArray());
    }
    // Тест на числовые ключи массива
    public function testValuesNumericArray()
    {
        $array = [1 => 'lion', 2 => 'cheetah', 3 => 'leopard'];
        $collect = new Collect\Collect($array);
        $values = $collect->values();
        $expectedValues = ['lion', 'cheetah', 'leopard'];
        $this->assertEquals($expectedValues, $values->toArray());
    }
    // Тест на пустой массив
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
    //Тест, на исключение элементов
    public function testExceptWithArray()
    {
        $array = ['red' => 'apple', 'yellow' => 'banana', 'green' => 'grapes'];
        $collect = new Collect\Collect($array);
        $result = $collect->except(['red', 'yellow']);
        $this->assertEquals(['green' => 'grapes'], $result->toArray());
    }
    // Тест на тип возвращаемого значения
    public function testExceptCountElements()
    {
        $collect = new Collect\Collect(['a' => 1, 'b' => 2, 'c' => 3]);
        $result = $collect->except('a');
        $this->assertInstanceOf(Collect\Collect::class, $result);
    }
    //Тест на исключение всех ключей
    public function testExceptAllKeys(){
        $collect = new Collect\Collect(['a' => 1, 'b' => 2, 'c' => 3]);
        $result = $collect->except('a', 'b', 'c');
        $this->assertCount(0, $result->toArray());
    }
    // Тест, что возвращенная коллекция содержит только указанные элементы и сто после коолекция осталась неизменной
    public function testOnlyReturnSelectedOnes()
    {
        $array = ['a' => 1, 'b' => 2, 'c' => 3];
        $collect = new Collect\Collect($array);
        $result = $collect->only(['a', 'c']);
        $this->assertEquals(['a' => 1, 'c' => 3], $result->toArray());
        $this->assertSame($array, $collect->toArray());
    }
    // Тест, что первый элемент соответствует ожидаемому
    public function testFirst()
    {
        $array = ['a' => 100, 'b' => 200, 'c' => 300];
        $collect = new Collect\Collect($array);
        $result = $collect->first();
        $this->assertEquals(100, $result);
        $this->assertSame($array, $collect->toArray());
    }
    public function testCount()
    {
        $collect = new Collect\Collect(['purple','white','black', 'red']);
        $this->assertSame(4, $collect->count());
    }
    public function testToArrayMethod()
    {
        $array = ['a' => 1, 'b' => 2, 'c' => 3];
        $collect = new Collect\Collect($array);
        $this->assertEquals($array, $collect->toArray());
    }
    //Тест, что результат поиска соответствует ожидаемому
    public function testSearchMethod()
    {
        $array = [
            ['id' => 1, 'color' => 'Blue'],
            ['id' => 2, 'color' => 'Yellow'],
            ['id' => 3, 'color' => 'Orange'],
            ['id' => 4, 'color' => 'Yellow'],
        ];

        $collect = new Collect\Collect($array);
        $result = $collect->search('color', 'Yellow')->toArray();
        $expectedResult = [
            ['id' => 2, 'color' => 'Yellow'],
            ['id' => 4, 'color' => 'Yellow'],
        ];

        $this->assertEquals($expectedResult, $result);
    }
    //Тест, что возвращает массив с новыми данными, которые сравниваем с ожидаемыми
    public function testMap()
    {
        $array = [1, 2, 3, 4];
        $collect = new Collect\Collect($array);
        $doubling = function ($value) {
            return $value * 2;
        };
        $result = $collect->map($doubling)->toArray();
        $expectedResult = [2, 4, 6, 8];
        $this->assertEquals($expectedResult, $result);
    }
    //Тест, на добавление нового значения в конец массива, сравнение с ожидаемым результатом
    public function testPush()
    {
        $collect = new Collect\Collect([1,'hi', 3, 2, 9]);
        $collect->push('bye');
        $this->assertSame([1,'hi', 3, 2, 9, 'bye'], $collect->toArray());
    }
    //Тест, на добавление нового значения в начало массива, сравнение с ожидаемым результатом
    public function testUnshift()
    {
        $collect = new Collect\Collect([1, 2, 3, 4]);
        $collect->unshift(0);
        $this->assertSame([0, 1, 2, 3, 4], $collect->toArray());
    }
    //Тест, на удаление 1 значения массива, сравнение с ожидаемым результатом
    public function testShift()
    {
        $collect = new Collect\Collect(['a' => 1, 'b' => 2, 'c' => 3]);
        $collect->shift();
        $this->assertSame(['b' => 2, 'c' => 3], $collect->toArray());
    }
    //Тест, на удаление последнего значения массива, сравнение с ожидаемым результатом
    public function testPop()
    {
        $collect = new Collect\Collect(['purple','white','black', 'red']);
        $collect->pop();
        $this->assertSame(['purple','white','black'], $collect->toArray());
    }


}