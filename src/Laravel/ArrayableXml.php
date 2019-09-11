<?php


namespace Dshorkin\ArrayableXml\Laravel;


use Illuminate\Support\Facades\Facade;
use Dshorkin\ArrayableXml\ArrayableXmlInterface;

/**
 * Class ArrayableXml
 * @package Dshorkin\ArrayableXml\Laravel
 * @method static ArrayableXmlInterface create(string $str, string $childrenFieldKey = 'children', string $textFieldKey = 'text', $miniElements = true)
 * * @method static ArrayableXmlInterface createFromSimpleXmlElement(\SimpleXMLElement $xml, string $childrenFieldKey = 'children', string $textFieldKey = 'text', $miniElements = true)
 */
class ArrayableXml extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'arrayable-xml-factory';
    }
}