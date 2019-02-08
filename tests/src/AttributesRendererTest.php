<?php
namespace tests;

use Germania\AttributesRenderer\AttributesRenderer;


class AttributesRendererTest extends \PHPUnit\Framework\TestCase
{


    /**
     * @dataProvider provideAttributesData
     */
    public function testSimple( $attributes, $value, $separator, $expected_string)
    {
        $sut = new AttributesRenderer( $separator );

        $result = $sut( $attributes, $value, $separator );

        $this->assertEquals($expected_string, $result);
    }


    public function provideAttributesData()
    {
        $attr = array('foo' => 'bar', 'empty' => null, 'one' => "two");

        return [
            [ $attr, null, " ", 'foo="bar" one="two"'],
            [ $attr, null, ";", 'foo="bar";one="two"'],

            [ "foo", "bar", " ", 'foo="bar"'],
            [ "foo", "bar", ";", 'foo="bar"'],

            [ "foo", "", ";", 'foo=""'],
            [ "foo", "", " ", 'foo=""'],
            [ "foo", null, " ", ''],
            [ "foo", false, " ", ''],
        ];
    }

}
