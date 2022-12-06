PHP JSON Tools
=======================================

Installation
---------------------------------------

This library may be installed with composer.

```sh
composer require francerz/sql-tools
```

Usage
---------------------------------------

Implementing `JsonMappedAttributesInterface` interface into `Student` class.

```php
use Francerz\JsonTools\JsonAttributeMap;
use Francerz\JsonTools\JsonMappedAttributesInterface;

class Student implements JsonMappedAttributesInterface
{
    private $studentId;
    private $givenName;
    private $familyName;

    public function getJsonMappings()
    {
        return [
            new JsonAttributeMap('id', 'studentId'),
            new JsonAttributeMap('given_name', 'givenName'),
            new JsonAttributeMap('family_name', 'familyName')
        ];
    }
}
```

Decoding JSON string to object.

```php
$json = '{"id":123,"given_name":"John","family_name":"Doe"}';

$student = \Francerz\JsonTools\JsonEncoder::decode($json, Student::class);
```

Decoding JSON string to object's array.

```php
$json = '[' .
    '{"id":123,"given_name":"John","family_name":"Doe"},' .
    '{"id":321,"given_name":"Jane","family_name":"Smith"}' .
']';

$students = \Francerz\JsonTools\JsonEncoder::decode($json, Student::class);
```
