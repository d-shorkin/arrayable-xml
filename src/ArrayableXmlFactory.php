<?php


namespace Dshorkin\ArrayableXml;


class ArrayableXmlFactory
{
    /**
     * Create ArrayableXml from xml string
     *
     * @param string $str XML string
     * @param string $childrenFieldKey Parse child nodes in children property, if you send empty string child nodes will be merge with attributes
     * @param string $textFieldKey Text content will be parse in property with this key
     * @param bool $miniElements If you set it to true in all elements you get array
     * @return ArrayableXmlInterface
     */
    public function create(string $str, string $childrenFieldKey = 'children', string $textFieldKey = 'text', $miniElements = true): ArrayableXmlInterface
    {
        return new ArrayableXml(simplexml_load_string($str), $childrenFieldKey, $textFieldKey, $miniElements);
    }

    /**
     * @param \SimpleXMLElement $xml
     * @param string $childrenFieldKey Parse child nodes in children property, if you send empty string child nodes will be merge with attributes
     * @param string $textFieldKey Text content will be parse in property with this key
     * @param bool $miniElements If you set it to true in all elements you get array
     * @return ArrayableXmlInterface
     */
    public function createFromSimpleXmlElement(\SimpleXMLElement $xml, string $childrenFieldKey = 'children', string $textFieldKey = 'text', $miniElements = true): ArrayableXmlInterface
    {
        return new ArrayableXml($xml, $childrenFieldKey, $textFieldKey, $miniElements);
    }
}