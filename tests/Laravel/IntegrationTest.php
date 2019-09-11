<?php


namespace Dshorkin\ArrayableXml\Tests\Laravel;


use Orchestra\Testbench\TestCase;
use Dshorkin\ArrayableXml\ArrayableXmlFactory;
use Dshorkin\ArrayableXml\ArrayableXmlInterface;
use Dshorkin\ArrayableXml\Laravel\ArrayableXml;
use Dshorkin\ArrayableXml\Laravel\ArrayableXmlProvider;

class IntegrationTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ArrayableXmlProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [ArrayableXml::class];
    }

    public function testCallFacade()
    {
        $this->assertInstanceOf(
            ArrayableXmlInterface::class,
            ArrayableXml::create('<root></root>')
        );
    }

    public function testLoadFactoryFromLaravelContainer()
    {
        $this->assertInstanceOf(
            ArrayableXmlFactory::class,
            $this->app->make('arrayable-xml-factory')
        );


    }
}