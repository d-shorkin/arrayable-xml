<?php


namespace Dshorkin\ArrayableXml\Tests\Unit;


use PHPUnit\Framework\TestCase;
use Dshorkin\ArrayableXml\ArrayableXml;

class ArrayableXmlTest extends TestCase
{
    /**
     * @var string
     */
    private $xml;

    protected function setUp()
    {
        $this->xml = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<Test MainAttribute="Text" AnotherMainAttribute="1">
    <Item>Some text</Item>
    <Item TestCode="22"/>
    <Item>
        <SubItem SomeAttribute="Some attribute text" AnotherAttribute="182.2">test text</SubItem>
        <SoBigParamSoBigParamSoBigParamJustTrue/>
    </Item>
    <Item/>
    <Item>
        <Test Field="field">One</Test>
    </Item>
</Test>
XML;
    }

    public function testSuccessful()
    {
        $xmlToArray = new ArrayableXml(simplexml_load_string($this->xml));

        $this->assertArraySubset([
            'MainAttribute' => 'Text',
            'AnotherMainAttribute' => 1,
            'children' => [
                'Item' => [
                    ['text' => 'Some text'],
                    ['TestCode' => 22],
                    [
                        'children' => [
                            'SubItem' => [
                                'SomeAttribute' => 'Some attribute text',
                                'AnotherAttribute' => 182.2,
                                'text' => 'test text'
                            ],
                            'SoBigParamSoBigParamSoBigParamJustTrue' => []
                        ]
                    ],
                    [],
                    [
                        'children' => [
                            'Test' => [
                                'Field' => 'field',
                                'text' => 'One'
                            ]
                        ]
                    ]
                ],
            ]
        ], $xmlToArray->toArray());
    }

    public function testSuccessfulMini()
    {
        $xmlToArray = new ArrayableXml(simplexml_load_string($this->xml), '');

        $this->assertArraySubset([
            'MainAttribute' => 'Text',
            'AnotherMainAttribute' => 1,
            'Item' => [
                ['text' => 'Some text'],
                ['TestCode' => 22],
                [
                    'SubItem' => [
                        'SomeAttribute' => 'Some attribute text',
                        'AnotherAttribute' => 182.2,
                        'text' => 'test text'
                    ],
                    'SoBigParamSoBigParamSoBigParamJustTrue' => []
                ],
                [],
                [
                    'Test' => [
                        'Field' => 'field',
                        'text' => 'One'
                    ]
                ]
            ]
        ], $xmlToArray->toArray());
    }

    public function testAnotherTextField()
    {
        $xmlToArray = new ArrayableXml(simplexml_load_string($this->xml), '', 'NodeText');

        $this->assertArraySubset([
            'MainAttribute' => 'Text',
            'AnotherMainAttribute' => 1,
            'Item' => [
                ['NodeText' => 'Some text'],
                ['TestCode' => 22],
                [
                    'SubItem' => [
                        'SomeAttribute' => 'Some attribute text',
                        'AnotherAttribute' => 182.2,
                        'NodeText' => 'test text'
                    ],
                    'SoBigParamSoBigParamSoBigParamJustTrue' => []
                ],
                [],
                [
                    'Test' => [
                        'Field' => 'field',
                        'NodeText' => 'One'
                    ]
                ]
            ]
        ], $xmlToArray->toArray());
    }

    public function testDisableMinification()
    {
        $xmlToArray = new ArrayableXml(simplexml_load_string($this->xml), '', 'text', false);

        $this->assertArraySubset([
            'MainAttribute' => 'Text',
            'AnotherMainAttribute' => 1,
            'Item' => [
                [
                    'text' => 'Some text'
                ],
                [
                    'TestCode' => 22
                ],
                [
                    'SubItem' => [
                        [
                            'SomeAttribute' => 'Some attribute text',
                            'AnotherAttribute' => 182.2,
                            'text' => 'test text'
                        ]
                    ],
                    'SoBigParamSoBigParamSoBigParamJustTrue' => []
                ],
                [],
                [
                    'Test' => [
                        [
                            'Field' => 'field',
                            'text' => 'One'
                        ]
                    ]
                ]
            ]
        ], $xmlToArray->toArray());
    }
}