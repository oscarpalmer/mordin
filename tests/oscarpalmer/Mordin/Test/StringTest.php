<?php

namespace oscarpalmer\Mordin\Test;

use oscarpalmer\Mordin\String;

class StringTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->abc = "abcdefghijklmnopqrstuvwxyzåäö";
        $this->abc_caps = "ABCDEFGHIJKLMNOPQRSTUVWXYZÅÄÖ";

        $this->widont_after = "A Longer Title To Showcase How Widont&nbsp;Works";
        $this->widont_before = "A Longer Title To Showcase How Widont Works  ";
    }

    public function testBeginsWith()
    {
        $this->assertTrue(String::beginsWith($this->abc, "abc"));
        $this->assertFalse(String::beginsWith($this->abc, "åäö"));

        $this->assertTrue(String::beginsWith($this->abc, "ABC", true));
        $this->assertFalse(String::beginsWith($this->abc, "ÅÄÖ", true));
    }

    public function testContains()
    {
        $this->assertTrue(String::contains($this->abc, "op"));
        $this->assertFalse(String::contains($this->abc, "po"));

        $this->assertTrue(String::contains($this->abc, "OP", true));
        $this->assertFalse(String::contains($this->abc, "PO", true));
    }

    public function testEndsWith()
    {
        $this->assertTrue(String::endsWith($this->abc, "åäö"));
        $this->assertFalse(String::endsWith($this->abc, "abc"));

        $this->assertTrue(String::endsWith($this->abc, "ÅÄÖ", true));
        $this->assertFalse(String::endsWith($this->abc, "ABC", true));
    }

    public function testExcerpt()
    {
        $this->assertSame("An excerpt…", String::excerpt("An excerpt for an article.", 11));
        $this->assertSame("An excerpt for an article.", String::excerpt("An excerpt for an article."));
        $this->assertSame("An excerpt~", String::excerpt("An excerpt for an article.", 11, "~"));
    }

    public function testIsNoun()
    {
        $this->assertTrue(String::isEmail("user@example.com"));
        $this->assertFalse(String::isEmail("user at example dot com"));

        $this->assertTrue(String::isUrl("http://example.com"));
        $this->assertFalse(String::isUrl("example.com"));
    }

    public function testLength()
    {
        $this->assertSame(29, String::length($this->abc));
    }

    public function testLowercase()
    {
        $this->assertSame($this->abc, String::lowercase($this->abc_caps));
    }

    public function testUppercase()
    {
        $this->assertSame($this->abc_caps, String::uppercase($this->abc));
    }

    public function testWidont()
    {
        $this->assertSame("A Title", String::widont("A Title"));
        $this->assertSame($this->widont_after, String::widont($this->widont_before));
    }
}