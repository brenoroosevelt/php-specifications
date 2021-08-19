# Specification Pattern - PHP

Implementation of Specification Pattern in PHP for general purpose.

## Requirements

* PHP >= 7.1 

## Install 

```bash
composer require brenoroosevelt/php-specifications
```

## Definition
 
Specifications ara classes that implements the interface [`Specification`](src/Specification.php): 
```php
<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification;

interface Specification
{
    /**
     * Evaluates the candidate with the specification
     *
     * @param $candidate
     * @return bool
     */
    public function isSatisfiedBy($candidate): bool;
}
```

### Constraints

The functions below evaluate a candidate using the following specifications:

Function | Specification |
--------------------------- | --------------------------------------------------------
`isNull()`                  | is (using `is_null()`)
`isNotNull()`               | is not `!is_null()`
`isEmpty()`                 | is empty (using `empty()`)
`isNotEmpty()`              | not empty (using `empty()`)
`equals($value)`            | equals to the given value (using `==`)
`notEquals($value)`         | not equals to the given value (using `!=`)
`same($value)`              | identical to the given value (using `===`)
`notSame($value)`           | not identical to the given value (using `!==`)
`greaterThan($value)`       | greater the given value (using `>`)
`greaterThanEqual($value)`  | greater than or equal to the given value (using `>=`)
`lessThan($value)`          | less than to the given value (using `<`)
`lessThanEqual($value)`     | less than or equal to to the given value (using `<=`)
`startsWith($prefix, bool $case = true)`| string starts with another given string
`endsWith($suffix, bool $case = true)`         | string ends with another given string
`contains($value, bool $strict = true)`         | evaluates if the candidate contains a given value (can be used for strings or arrays)
`in($values, bool $trict = true)`               | evaluates if the candidate exists in a list 
`keyExists($key)`           | key exists in a candidate
`keyNotExists($key)`        | key does not exist in a candidate
`true()`                    | Always `true` 
`false()`                   | Always `false` 

### Operators

Logic               | Operator
--------------------------- | --------------------------------------------------------
class `Not(Specification $specification)`                  | `NOT`
class `AllOf(Specification ...$specification)`                  | `AND`
class `AnyOf(Specification ...$specification)`               | `OR`
class `OneOf(Specification ...$specification)`               | `XOR`
class `NoneOf(Specification ...$specification)`               | check that none of the specifications match

### Chaining Specifications

Specifications can be chained using the following function:

Function               | Operator | Example
-----|----
`allOf()`                  | `AND` | allOf()->isNull()->isNotEmpty() ...
`anyOf()`               | `OR` |  anyOf()->isNull()->equals(2) ...
`oneOf()`               | `XOR` | oneOf()->greaterThan(1)->isEmpty() ...
`noneOf()`               | none of | noneOf()->isNotNull()->contains('active') ...

Chained specifications will be evaluated with the corresponding operator.

### Transversal

