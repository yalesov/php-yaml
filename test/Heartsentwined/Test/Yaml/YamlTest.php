<?php
namespace Heartsentwined\Test\Yaml;

use Heartsentwined\Yaml\Yaml;

class YamlTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->tmpFile = '.yaml';
        $this->tmpPath = realpath(dirname($this->tmpFile));
    }

    public function tearDown()
    {
        unlink($this->tmpFile);
    }

    public function testParse()
    {
        // yaml stream
        $yaml = 'foo: bar';
        $this->assertSame(
            array('foo' => 'bar'),
            Yaml::parse($yaml));

        // yaml file
        file_put_contents($this->tmpFile, 'foo: bar');
        $this->assertSame(
            array('foo' => 'bar'),
            Yaml::parse($this->tmpFile));

        // __DIR__
        file_put_contents($this->tmpFile, 'foo: __DIR__/bar');
        $this->assertSame(
            array('foo' => "{$this->tmpPath}/bar"),
            Yaml::parse($this->tmpFile));

        // ___DIR___
        file_put_contents($this->tmpFile, 'foo: ___DIR___/bar');
        $this->assertSame(
            array('foo' => '__DIR__/bar'),
            Yaml::parse($this->tmpFile));

        // multiple __DIR__
        file_put_contents($this->tmpFile, '__DIR__/foo: __DIR__/bar');
        $this->assertSame(
            array("{$this->tmpPath}/foo" => "{$this->tmpPath}/bar"),
            Yaml::parse($this->tmpFile));

        // multiple ___DIR___
        file_put_contents($this->tmpFile, '___DIR___/foo: ___DIR___/bar');
        $this->assertSame(
            array('__DIR__/foo' => '__DIR__/bar'),
            Yaml::parse($this->tmpFile));

        // altogether
        file_put_contents($this->tmpFile, "__DIR__/foo: ___DIR___/bar\n___DIR___/bar: __DIR__/foo");
        $this->assertSame(
            array(
                "{$this->tmpPath}/foo" => '__DIR__/bar',
                '__DIR__/bar' => "{$this->tmpPath}/foo",
            ),
            Yaml::parse($this->tmpFile));

        // neither available when passed in a string
        $yaml = '__DIR__/foo: ___DIR___/bar';
        $this->assertSame(
            array('__DIR__/foo' => '___DIR___/bar'),
            Yaml::parse($yaml));
    }
}
