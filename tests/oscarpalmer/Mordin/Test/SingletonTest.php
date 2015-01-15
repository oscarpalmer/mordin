<?php

namespace oscarpalmer\Mordin\Test;

use oscarpalmer\Mordin\Singleton;

class One extends Singleton { /** Mock class. */ }
class Two extends Singleton { /** Mock class. */ }

class SingletonTest extends \PHPUnit_Framework_TestCase
{
    public function testGetInstance()
    {
        $instance_one = Singleton::getInstance();
        $instance_two = Singleton::getInstance();

        $this->assertInstanceOf("oscarpalmer\Mordin\Singleton", $instance_one);
        $this->assertInstanceOf("oscarpalmer\Mordin\Singleton", $instance_two);

        $this->assertSame($instance_one, $instance_two);
    }

    public function testMultipleSingletons()
    {
        $instance_one = One::getInstance();
        $instance_two = Two::getInstance();

        $this->assertInstanceOf("oscarpalmer\Mordin\Singleton", $instance_one);
        $this->assertInstanceOf("oscarpalmer\Mordin\Singleton", $instance_two);

        $this->assertNotSame($instance_one, $instance_two);
    }
}