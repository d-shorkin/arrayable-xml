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
        // This needs for load root attributes
        $dom = dom_import_simplexml($this->xml);
        $tmp = new \SimpleXMLElement(sprintf('<root>%s</root>', $dom->ownerDocument->saveXML($dom->ownerDocument->documentElement)));
        $array = $this->nodeToArray($tmp);
        if($this->miniElements){
            return $array[$this->xml->getName()];
        }
        return $array[$this->xml->getName()][0];
    }

    /**
     * @param \SimpleXMLElement $xml
     * @return array
     */
    private function nodeToArray(\SimpleXMLElement $xml): array
    {
        $children = [];

        foreach ($xml->children() as $node) {
            $arr = $this->parseNodeAttributes($node);

            if ($node->count()) {
                if (!$this->childrenFieldName) {
                    $arr = array_merge($arr, $this->nodeToArray($node));
                } else {
                    $arr[$this->childrenFieldName] = $this->nodeToArray($node);
                }
            } elseif ((string)$node) {
                $arr[$this->textFieldName] = (string)$node;
            }

            if (!isset($children[$node->getName()])) {
                $children[$node->getName()] = [];
            }

            $children[$node->getName()][] = $arr;
        }

        if (!$this->miniElements) {
            return $children;
        }

        foreach ($children as $key => $value) {
            if (count($value) == 1) {
                $children[$key] = $children[$key][0];
            }
        }

        return $children;
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