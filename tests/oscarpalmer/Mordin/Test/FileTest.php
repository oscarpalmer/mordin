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

        if (file_exists($this->dir . "/test_create_error") === false) {
            file_put_contents($this->dir . "/test_create_error", "");
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

        $this->assertFalse(File::create("{$this->dir}/test_create_error"));
        $this->assertFalse(File::delete("{$this->dir}/test_delete_error"));

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

        $create = File::mkdir("{$this->dir}/_mkdir_");
        $this->assertFalse($create);
    }

    public function testReadAndWrite()
    {
        $write = File::write("{$this->dir}/test_read_write", "Testing, testing...");
        $read = File::read("{$this->dir}/test_read_write");

        $this->assertTrue($write);
        $this->assertEquals($read, "Testing, testing...");

        $this->assertFalse(File::read("{$this->dir}/not_a_file  "));
    }

    public function testRename()
    {
        File::create("{$this->dir}/rename_test");
        File::rename("{$this->dir}/rename_test", "{$this->dir}/rename_test_new");

        $this->assertTrue(File::exists("{$this->dir}/rename_test_new"));
        $this->assertFalse(File::exists("{$this->dir}/rename_test"));

        File::create("{$this->dir}/rename_test_xxx");
        $this->assertFalse(File::rename("{$this->dir}/rename_test_new", "{$this->dir}/rename_test_xxx"));
    }

    public function testSize()
    {
        File::create("{$this->dir}/test_size", "these are words.");

        $this->assertSame(16, File::size("{$this->dir}/test_size"));
        $this->assertFalse(File::size("{$this->dir}/not_a_file"));
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