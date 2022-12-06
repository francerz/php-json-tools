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

Implementing `JsonMappedInterface` interface into `Student` class.

```php
use Francerz\JsonTools\JsonMap;
use Francerz\JsonTools\JsonMappedInterface;

class Student implements JsonMappedInterface
{
    private $studentId;
    private $givenName;
    private $familyName;

    public function getJsonMaps()
    {
        return [
            new JsonMap('id', 'studentId'),
            new JsonMap('given_name', 'givenName'),
            new JsonMap('family_name', 'familyName')
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
