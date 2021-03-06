# Specification Pattern - PHP

Implementation of Specification Pattern in PHP for general purpose.

## Requirements

* PHP >= 7.1 

## Install 

```bash
composer require brenoroosevelt/php-specifications
```

## Definition
 
Specifications are classes that implements the interface [`Specification`](src/Specification.php): 
```php
<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification;

interface Specification
{
    public function isSatisfiedBy($candidate): bool;
}
```

### Constraints

The functions below evaluate a candidate using the following specifications:

Function | Specification |
---------------------------------------- | ----------------------------------
`isTrue()`                  | is true (using `=== true`)
`isFalse()`                  | is false (using `=== false`)
`isNull()`                  | is null (using `is_null()`)
`isNotNull()`               | is not null `!is_null()`
`isEmpty()`                 | is empty (using `empty()`)
`isNotEmpty()`              | not empty (using `empty()`)
`isInstanceOf($classOrObject)`              | is instance of (using `instanceof`)
`isType($type)`              | is type (using `gettype()`)
`equals($value)`            | equals to the given value (using `==`)
`notEquals($value)`         | not equals to the given value (using `!=`)
`same($value)`              | identical to the given value (using `===`)
`notSame($value)`           | not identical to the given value (using `!==`)
`greaterThan($value)`       | greater the given value (using `>`)
`greaterThanEqual($value)`  | greater than or equal to the given value (using `>=`)
`lessThan($value)`          | less than to the given value (using `<`)
`lessThanEqual($value)`     | less than or equal to to the given value (using `<=`)
`between($i, $f)`                   | `>=` and `<=`
`startsWith($prefix, bool $case = true)`| string starts with another given string
`endsWith($suffix, bool $case = true)`         | string ends with another given string
`contains($value, bool $strict = true)`         | evaluates if the candidate contains a given value (can be used for strings or arrays)
`in($values, bool $trict = true)`               | evaluates if the candidate exists in a list 
`true()`                    | Always `true` 
`false()`                   | Always `false` 
`spec(Specification $spec)`                   | proxy another specification 
`rule($rule)`                   | callable or specification class name


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
-----|----|----
`allOf()`                  | `AND` | `allOf()->isNull()->isNotEmpty() ...`
`anyOf()`               | `OR` |  `anyOf()->isNull()->equals(2) ...`
`oneOf()`               | `XOR` | `oneOf()->greaterThan(1)->isEmpty() ...`
`noneOf()`               | none of | `noneOf()->isNotNull()->contains('active') ...`

Chained specifications will be evaluated with the corresponding operator.

### Transverse Specifications for iterables

Often used with collections, these especial specifications iterate candidates and evaluate their elements.

Function               | Operator | Example
-----|----|----
`all(Specification $spcification)`                  | Check that all of elements match with the specification | `all(property('age', lessThan(5)))`
`any(Specification $spcification)`                  | Check that any of elements match with the specification | `any(method('getAge', lessThan(5)))`
`atLeast(int $count, Specification $spcification)`               | Check that at least the count number of elements match with the specification | `atLeast(2, lessThan(5))`
`atMost(int $count, Specification $spcification)`               | Check that at most the count number of elements match with the specification | `atMost(5, length(equals(10)))`
`exactly(int $count, Specification $spcification)`               | Check that exactly the count number of elements match with the specification | `exactly(3, key('age', lessThan(5)))`
`none(Specification $spcification)`     | Check that none of elements match with the specification | `none(key('age', between(5, 15)))`

### Selectors

These special specifications extract candidate values and then evaluate the specification.

Function               | Operator | Example
-----|----|----
`key(string $key, Specification $spcification)`                  | Extract value using key/index | `key('age', greaterThan(10)`
`method(string/array $method, Specification $spcification)`                  | Extract value using method  | `method(['getPrice', $tax]', lessThan(200.50)`
`property(string $property, Specification $spcification)`               | Extract value from property| `property('name', length(between(2, 10))`
`count(Specification $spcification)`               | Extract count from countable candidates | `count(equals(10))`
`length(Specification $spcification)`               | Extract the length from string candidates | `length(equals(10))`


### Creating Specifications

```php
<?php
class RecentUser implements Specification
{
    private $daysAgo;
    
    public function __construct(int $daysAgo = 15) {
        $this->daysAgo = $daysAgo;
    }
    
    public function isSatisfiedBy($candidate): bool
    {
        $daysAgo = 
            (new DateTimeImmutable())->modify(sprintf("-%s days", $this->daysAgo));
        
        return 
            $candidate instanceof User && 
            $candidate->createdAt() >= $daysAgo;
    }
}
```

```php
<?php
$user = new User(/** ... */);

(new RecentUser(30))->isSatisfiedBy($user); // (bool)
rule(RecentUser::class, 30)->isSatisfiedBy($user); // (bool)
anyOf()->rule(RecentUser::class)->method('getCategory', in(['premium']))->isSatisfiedBy($user); // (bool)
```

#### Inline Specifications

```php
<?php

rule(fn($candidate) => $candidate->isActive());

```
