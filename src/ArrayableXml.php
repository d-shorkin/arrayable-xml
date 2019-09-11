<?php


namespace Dshorkin\ArrayableXml;

class ArrayableXml implements ArrayableXmlInterface
{
    /**
     * @var \SimpleXMLElement
     */
    private $xml;
    /**
     * @var string
     */
    private $childrenFieldName;
    /**
     * @var string
     */
    private $textFieldName;
    /**
     * @var bool
     */
    private $miniElements;

    /**
     * SimpleXmlElementArrayable constructor.
     *
     * @param \SimpleXMLElement $xml
     * @param string $childrenFieldName Setup empty string for merge Attributes and children
     * @param string $textFieldName
     * @param bool $miniElements
     */
    public function __construct(\SimpleXMLElement $xml, string $childrenFieldName = 'children', string $textFieldName = 'text', $miniElements = true)
    {
        if (!$textFieldName) {
            throw new \InvalidArgumentException('textFieldName must be not empty');
        }

        $this->xml = $xml;
        $this->childrenFieldName = $childrenFieldName;
        $this->textFieldName = $textFieldName;
        $this->miniElements = $miniElements;
    }

    /**
     * @return \SimpleXMLElement
     */
    public function getSimpleXml(): \SimpleXMLElement
    {
        return $this->xml;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->nodeToArray($this->xml);
    }

    /**
     * @param \SimpleXMLElement $xml
     * @return array
     */
    private function nodeToArray(\SimpleXMLElement $xml): array
    {
        // Process node
        $data = $this->parseNodeAttributes($xml);

        if (trim((string)$xml)) {
            $data[$this->textFieldName] = trim((string)$xml);
        }

        if (!$xml->count()) {
            return $data;
        }

        // Load children
        $children = [];
        foreach ($xml->children() as $child) {
            if (!isset($children[$child->getName()])) {
                $children[$child->getName()] = [];
            }

            $children[$child->getName()][] = $this->nodeToArray($child);
        }
        // Compact children
        if($this->miniElements){
            foreach ($children as $key => $value) {
                if (count($value) == 1) {
                    $children[$key] = $children[$key][0];
                }
            }
        }

        // Output
        if($this->childrenFieldName){
            $data[$this->childrenFieldName] = $children;
            return $data;
        }

        return array_merge($data, $children);
    }

    private function parseNodeAttributes(\SimpleXMLElement $node)
    {
        $arr = [];

        foreach ($node->attributes() as $attr) {
            $arr[$attr->getName()] = (string)$attr;

            if (is_numeric($arr[$attr->getName()])) {
                $arr[$attr->getName()] = (float)$arr[$attr->getName()];
            }
        }

        return $arr;
    }
}