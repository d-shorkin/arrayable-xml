<?php


namespace Dshorkin\ArrayableXml;


interface ArrayableXmlInterface
{
    /**
     * Returns instance of SimpleXMLElement
     *
     * @return \SimpleXMLElement
     */
    public function getSimpleXml(): \SimpleXMLElement;

    /**
     * Returns array from XML
     *
     * @return array
     */
    public function toArray(): array;
}