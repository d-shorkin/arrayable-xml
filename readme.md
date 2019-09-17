# Arrayable XML

PHP library for parsing XML to array. This library can formatting attributes of xml

## Installation

Install via composer:

```bash
composer require d-shorkin/arrayable-xml
```

## Usage

```php
$xmlString = <<<XML
<root rootAttr="bar">
    <example testAttr="foo">1</example>
    <example>2</example>
</root>
XML;

$factory = new Dshorkin\ArrayableXml\ArrayableXmlFactory();
$arrayableXml = $factory->create($xmlString);

var_dump($arrayableXml->toArray());
```

Result:

```
array(2) {
  ["rootAttr"]=>
  string(3) "bar"
  ["children"]=>
  array(1) {
    ["example"]=>
    array(2) {
      [0]=>
      array(2) {
        ["testAttr"]=>
        string(3) "foo"
        ["text"]=>
        string(1) "1"
      }
      [1]=>
      array(1) {
        ["text"]=>
        string(1) "2"
      }
    }
  }
}
```

## Laravel

If you does not use `php artisan package:discover` command. You need add `ArrayableXmlProvider` to config.

`config/app.php`

```php
'providers' => [
    // ...
    
    Dshorkin\ArrayableXml\Laravel\ArrayableXmlProvider::class,
],

'aliases' => [
    // ...
    
    'ArrayableXml' => Dshorkin\\ArrayableXml\Laravel\ArrayableXml::class
]
```

Basic laravel usage:

```php
ArrayableXml::create($xmlString)->toArray()
```

## Class reference

Dshorkin\ArrayableXml\ArrayableXmlFactory

#### Create

```
ArrayableXmlFactory::create(string $str, [string $childrenFieldKey, [string $textFieldKey, [bool $miniElements]]]): ArrayableXmlInterface
```

| Param            	| Type   	| Default  	| Description                                                                                                                        	|
|------------------	|--------	|----------	|------------------------------------------------------------------------------------------------------------------------------------	|
| str              	| string 	|          	| XML string                                                                                                                         	|
| childrenFieldKey 	| string 	| children 	| Parse child nodes in children property, if you send empty string child nodes will be merge with attributes                         	|
| textFieldKey     	| string 	| text     	| Text content will be parse in property with this key                                                                               	|
| miniElements     	| bool   	| true     	| If you disable it all elements will be return array of children. By default if parent has single child that will be returned alone 	|


#### Create From SimpleXmlElement

```
ArrayableXmlFactory::createFromSimpleXmlElement(\SimpleXMLElement $xml, [string $childrenFieldKey, [string $textFieldKey, [bool $miniElements]]]): ArrayableXmlInterface
```


