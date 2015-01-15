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

        $this->assertFalse(Arr::first(array()));
        $this->assertFalse(Arr::last(array()));
    }

    public function testGet()
    {
        $array = array("alpha", "beta" => 1);

        $this->assertSame("alpha", Arr::get($array, 0));
        $this->assertSame(1, Arr::get($array, "beta"));
        $this->assertSame("default", Arr::get($array, 2, "default"));
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
    }
}