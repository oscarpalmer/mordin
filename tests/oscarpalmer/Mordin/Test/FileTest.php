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
            if (is_dir($file)) {
                rmdir($file);
                continue;
            }

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

        try {
            File::create(1234);
        } catch (\Exception $e) {
            $this->assertInstanceOf("InvalidArgumentException", $e);
        }

        try {
            File::create("{$this->dir}/test_create_error");
            File::create("{$this->dir}/test_create_error");
        } catch (\Exception $e) {
            $this->assertInstanceOf("LogicException", $e);
        }

        try {
            File::delete(1234);
        } catch (\Exception $e) {
            $this->assertInstanceOf("InvalidArgumentException", $e);
        }

        try {
            File::delete("{$this->dir}/not_a_file");
        } catch (\Exception $e) {
            $this->assertInstanceOf("LogicException", $e);
        }

        File::create("{$this->dir}/test_permissions_error");
        chmod("{$this->dir}/test_permissions_error", 0000);
        $this->assertFalse(File::write("{$this->dir}/test_permissions_error", 1234));

        File::mkdir("{$this->dir}/_mkdir_rmdir_");
        $delete = File::delete("{$this->dir}/_mkdir_rmdir_");
        $this->assertTrue($delete);
    }

    public function testExists()
    {
        File::create("{$this->dir}/test_exists");

        $this->assertTrue(File::exists("{$this->dir}/test_exists"));
        $this->assertFalse(File::exists("not_a_file"));
    }

    public function testMkdir()
    {
        $create = File::mkdir("{$this->dir}/_mkdir_", false);
        $this->assertTrue($create);

        try {
            File::mkdir("{$this->dir}/_mkdir_");
        } catch (\Exception $e) {
            $this->assertInstanceOf("LogicException", $e);
        }

        try {
            File::mkdir(1234);
        } catch (\Exception $e) {
            $this->assertInstanceOf("InvalidArgumentException", $e);
        }

        try {
            File::mkdir("{$this->dir}/_mkdir_", "permissions");
        } catch (\Exception $e) {
            $this->assertInstanceOf("InvalidArgumentException", $e);
        }

        try {
            File::mkdir("{$this->dir}/_mkdir_", 0777, "recursive");
        } catch (\Exception $e) {
            $this->assertInstanceOf("InvalidArgumentException", $e);
        }
    }

    public function testReadAndWrite()
    {
        $write = File::write("{$this->dir}/test_read_write", "Testing, testing...");
        $read = File::read("{$this->dir}/test_read_write");

        $this->assertTrue($write);
        $this->assertEquals($read, "Testing, testing...");

        try {
            File::read("not_a_file");
        } catch (\Exception $e) {
            $this->assertInstanceOf("LogicException", $e);
        }

        try {
            File::write(1234, 5678);
        } catch (\Exception $e) {
            $this->assertInstanceOf("InvalidArgumentException", $e);
        }
    }

    public function testRename()
    {
        File::create("{$this->dir}/rename_test");
        File::rename("{$this->dir}/rename_test", "{$this->dir}/rename_test_new");

        $this->assertTrue(File::exists("{$this->dir}/rename_test_new"));
        $this->assertFalse(File::exists("{$this->dir}/rename_test"));

        try {
            File::rename(1234, "new_name");
        } catch (\Exception $e) {
            $this->assertInstanceOf("InvalidArgumentException", $e);
        }

        try {
            File::rename("not_a_file", "new_name");
        } catch (\Exception $e) {
            $this->assertInstanceOf("LogicException", $e);
        }

        try {
            File::rename("{$this->dir}/rename_test_new", 1234);
        } catch (\Exception $e) {
            $this->assertInstanceOf("InvalidArgumentException", $e);
        }
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