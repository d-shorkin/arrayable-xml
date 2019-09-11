<?php


namespace Dshorkin\XmlToArray\Tests\Unit;


use PHPUnit\Framework\TestCase;
use Dshorkin\ArrayableXml\ArrayableXmlFactory;
use Dshorkin\ArrayableXml\ArrayableXmlInterface;

class FactoryTest extends TestCase
{
    public function testCreateFromString()
    {
        $factory = new ArrayableXmlFactory();

        $this->assertInstanceOf(
            ArrayableXmlInterface::class,
            $factory->create('<root></root>')
        );
    }

    public function testCreateFromSimpleXmlElement()
    {
        $factory = new ArrayableXmlFactory();

        $this->assertInstanceOf(
            ArrayableXmlInterface::class,
            $factory->createFromSimpleXmlElement(simplexml_load_string('<root></root>'))
        );
    }

    public function testCreateWithoutTextField()
    {
        $factory = new ArrayableXmlFactory();

        $this->expectException(\InvalidArgumentException::class);

        $this->assertInstanceOf(
            ArrayableXmlInterface::class,
            $factory->create('<root></root>', '', '')
        );
    }
}