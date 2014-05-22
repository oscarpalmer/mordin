<?php

namespace oscarpalmer\Mordin\Test;

use oscarpalmer\Mordin\File;

class FileTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->dir = __DIR__ . "/../../../tmp";

        if (file_exists($this->dir) === false) {
            mkdir($this->dir);
        }
    }

    public function tearDown()
    {
        foreach (glob("{$this->dir}/*") as $file) {
            unlink($file);
        }

        rmdir($this->dir);
    }

    public function testCreateAndDelete()
    {
        $create = File::create("{$this->dir}/test_create_delete");
        $delete = File::delete("{$this->dir}/test_create_delete");

        $this->assertTrue($create);
        $this->assertTrue($delete);
    }

    public function testErrors()
    {
        File::create("{$this->dir}/test_create_error");
        $this->assertFalse(File::create("{$this->dir}/test_create_error"));

        $this->assertFalse(File::delete("not_a_file"));

        $this->assertFalse(File::exists("not_a_file"));

        $this->assertFalse(File::read("not_a_file"));

        $this->assertFalse(File::rename("not_a_file", "not_a_file_too"));

        $this->assertFalse(File::write(1234, 5678));

        File::create("{$this->dir}/test_permissions_error");
        chmod("{$this->dir}/test_permissions_error", 0000);
        $this->assertFalse(File::write("{$this->dir}/test_permissions_error", 1234));
    }

    public function testExists()
    {
        File::create("{$this->dir}/test_exists");

        $this->assertTrue(File::exists("{$this->dir}/test_exists"));
        $this->assertFalse(File::exists("not_a_file"));
    }

    public function testReadAndWrite()
    {
        $write = File::write("{$this->dir}/test_read_write", "Testing, testing...");
        $read = File::read("{$this->dir}/test_read_write");

        $this->assertTrue($write);
        $this->assertEquals($read, "Testing, testing...");
    }

    public function testRename()
    {
        File::create("{$this->dir}/test_rename");

        $this->assertTrue(File::exists("{$this->dir}/test_rename"));

        File::rename("{$this->dir}/test_rename", "{$this->dir}/test_rename_new");

        $this->assertTrue(File::exists("{$this->dir}/test_rename_new"));
        $this->assertFalse(File::exists("{$this->dir}/test_rename"));
    }

    public function testWriteArrayAndObject()
    {
        $array = array(1,2,3,4);

        $object = new \stdClass;
        $object->alpha = "omega";

        File::write("{$this->dir}/test_write_array", $array);
        $this->assertEquals(File::read("{$this->dir}/test_write_array"), "[1,2,3,4]");

        File::write("{$this->dir}/test_write_object", $object);
        $this->assertEquals(File::read("{$this->dir}/test_write_object"), "{\"alpha\":\"omega\"}");
    }
}