<?php

namespace oscarpalmer\Mordin\Test;

use oscarpalmer\Mordin\Arr;

class ArrTest extends \PHPUnit_Framework_TestCase
{
    public function testFirstAndLast()
    {
        $array_one = array("alpha", "omega");
        $array_two = array("alpha" => 0, "omega" => 1);

        $this->assertSame(Arr::first($array_one), "alpha");
        $this->assertSame(Arr::first($array_two), 0);
        $this->assertSame(Arr::last($array_one), "omega");
        $this->assertSame(Arr::last($array_two), 1);

        foreach (array("first", "last") as $fn) {
            try {
                Arr::$fn(array());
            } catch (\Exception $e) {
                $this->assertInstanceOf("LogicException", $e);
            }
        }
    }

    public function testGet()
    {
        $array = array("alpha", "beta" => 1);

        $this->assertSame("alpha", Arr::get($array, 0));
        $this->assertSame(1, Arr::get($array, "beta"));
        $this->assertSame("default", Arr::get($array, 2, "default"));

        foreach (array(array(), true) as $key) {
            try {
                Arr::get($array, $key);
            } catch (\Exception $e) {
                $this->assertInstanceOf("InvalidArgumentException", $e);
            }
        }
    }

    public function testInvalidFirstArgument()
    {
        foreach (array("first", "get", "json", "last", "merge") as $fn) {
            try {
                Arr::$fn("array?", 0);
            } catch (\Exception $e) {
                $this->assertInstanceOf("Exception", $e);
            }
        }
    }

    public function testJson()
    {
        $array = array("alpha", "omega");

        $this->assertSame("[\"alpha\",\"omega\"]", Arr::json($array));
    }

    public function testMerge()
    {
        $array_one = array(0 => "alpha", 1 => "beta", 2 => "gamma", 3 => "delta");
        $array_two = array(1 => "not beta", 3 => "not delta", 4 => "epsilon");

        $array_three = Arr::merge($array_one, $array_two);
        $array_four = Arr::merge($array_one, $array_two, true);

        $this->assertSame("beta", $array_three[1]);
        $this->assertSame("epsilon", $array_three[4]);
        $this->assertSame("not beta", $array_four[1]);
        $this->assertSame("epsilon", $array_four[4]);

        try {
            Arr::merge(array(), "array?");
        } catch (\Exception $e) {
            $this->assertInstanceOf("Exception", $e);
        }

        try {
            Arr::merge(array(), array(), "boolean?");
        } catch (\Exception $e) {
            $this->assertInstanceOf("InvalidArgumentException", $e);
        }
    }
}