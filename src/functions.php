<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification;

use BrenoRoosevelt\Specification\Spec\All;
use BrenoRoosevelt\Specification\Spec\Any;
use BrenoRoosevelt\Specification\Spec\AtLeast;
use BrenoRoosevelt\Specification\Spec\AtMost;
use BrenoRoosevelt\Specification\Spec\Between;
use BrenoRoosevelt\Specification\Spec\Contains;
use BrenoRoosevelt\Specification\Spec\Equals;
use BrenoRoosevelt\Specification\Spec\Exactly;
use BrenoRoosevelt\Specification\Spec\GreaterThan;
use BrenoRoosevelt\Specification\Spec\GreaterThanEqual;
use BrenoRoosevelt\Specification\Spec\In;
use BrenoRoosevelt\Specification\Spec\IsEmpty;
use BrenoRoosevelt\Specification\Spec\IsFalse;
use BrenoRoosevelt\Specification\Spec\IsInstanceOf;
use BrenoRoosevelt\Specification\Spec\IsNull;
use BrenoRoosevelt\Specification\Spec\IsTrue;
use BrenoRoosevelt\Specification\Spec\IsType;
use BrenoRoosevelt\Specification\Spec\Key;
use BrenoRoosevelt\Specification\Spec\KeyExists;
use BrenoRoosevelt\Specification\Spec\Length;
use BrenoRoosevelt\Specification\Spec\LessThan;
use BrenoRoosevelt\Specification\Spec\LessThanEqual;
use BrenoRoosevelt\Specification\Spec\Method;
use BrenoRoosevelt\Specification\Spec\None;
use BrenoRoosevelt\Specification\Spec\NotEquals;
use BrenoRoosevelt\Specification\Spec\Property;
use BrenoRoosevelt\Specification\Spec\Same;
use BrenoRoosevelt\Specification\Spec\Count;
use BrenoRoosevelt\Specification\Spec\ValueOf;
use BrenoRoosevelt\Specification\Spec\Rule;
use BrenoRoosevelt\Specification\Spec\AllOf;
use BrenoRoosevelt\Specification\Spec\AlwaysFalse;
use BrenoRoosevelt\Specification\Spec\AlwaysTrue;
use BrenoRoosevelt\Specification\Spec\AnyOf;
use BrenoRoosevelt\Specification\Spec\NoneOf;
use BrenoRoosevelt\Specification\Spec\Not;
use BrenoRoosevelt\Specification\Spec\OneOf;

if (! function_exists('BrenoRoosevelt\Specification\anyOf')) {
    function anyOf(): Chained
    {
        return new Chained(new AnyOf());
    }
}

if (! function_exists('BrenoRoosevelt\Specification\allOf')) {
    function allOf(): Chained
    {
        return new Chained(new AllOf());
    }
}

if (! function_exists('BrenoRoosevelt\Specification\noneOf')) {
    function noneOf(): Chained
    {
        return new Chained(new NoneOf());
    }
}

if (! function_exists('BrenoRoosevelt\Specification\oneOf')) {
    function oneOf(): Chained
    {
        return new Chained(new OneOf());
    }
}

if (! function_exists('BrenoRoosevelt\Specification\_and')) {
    function _and(): Chained
    {
        return allOf();
    }
}

if (! function_exists('BrenoRoosevelt\Specification\_or')) {
    function _or(): Chained
    {
        return anyOf();
    }
}

if (! function_exists('BrenoRoosevelt\Specification\_xor')) {
    function _xor(): Chained
    {
        return oneOf();
    }
}

if (! function_exists('BrenoRoosevelt\Specification\rule')) {
    function rule($rule, ...$args): Specification
    {
        return new Rule($rule, ...$args);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\not')) {
    function not(Specification $specification): Specification {
        return new Not($specification);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\true')) {
    function true(): Specification {
        return new AlwaysTrue();
    }
}

if (! function_exists('BrenoRoosevelt\Specification\false')) {
    function false(): Specification {
        return new AlwaysFalse();
    }
}

if (! function_exists('BrenoRoosevelt\Specification\contains')) {
    function contains($v, bool $strict = true): Specification {
        return new Contains($v, $strict);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\in')) {
    function in($v, bool $strict = true): Specification {
        return new In($v, $strict);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\notIn')) {
    function notIn($v, bool $strict = true): Specification {
        return new Not(new In($v, $strict));
    }
}

if (! function_exists('BrenoRoosevelt\Specification\notContains')) {
    function notContains($v, bool $strict = true): Specification {
        return new Not(new Contains($v, $strict));
    }
}

if (! function_exists('BrenoRoosevelt\Specification\isTrue')) {
    function isTrue(): Specification {
        return new IsTrue();
    }
}

if (! function_exists('BrenoRoosevelt\Specification\isFalse')) {
    function isFalse(): Specification {
        return new IsFalse();
    }
}

if (! function_exists('BrenoRoosevelt\Specification\isNull')) {
    function isNull(): Specification {
        return new IsNull();
    }
}

if (! function_exists('BrenoRoosevelt\Specification\isNotNull')) {
    function isNotNull(): Specification {
        return new Not(new IsNull());
    }
}

if (! function_exists('BrenoRoosevelt\Specification\isEmpty')) {
    function isEmpty(): Specification {
        return new IsEmpty();
    }
}

if (! function_exists('BrenoRoosevelt\Specification\isNotEmpty')) {
    function isNotEmpty(): Specification {
        return new Not(new IsEmpty());
    }
}

if (! function_exists('BrenoRoosevelt\Specification\isInstanceOf')) {
    function isInstanceOf($objectOrClass): Specification {
        return new IsInstanceOf($objectOrClass);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\isType')) {
    function isType($type): Specification {
        return new IsType($type);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\equals')) {
    function equals($v): Specification {
        return new Equals($v);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\notEquals')) {
    function notEquals($v): Specification {
        return new NotEquals($v);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\same')) {
    function same($v): Specification {
        return new Same($v);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\notSame')) {
    function notSame($v): Specification {
        return new Same($v);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\lessThan')) {
    function lessThan($v): Specification {
        return new LessThan($v);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\lessThanEqual')) {
    function lessThanEqual($v): Specification {
        return new LessThanEqual($v);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\greaterThan')) {
    function greaterThan($v): Specification {
        return new GreaterThan($v);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\greaterThanEqual')) {
    function greaterThanEqual($v): Specification {
        return new GreaterThanEqual($v);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\between')) {
    function between($i, $f, bool $boundaries = true): Specification {
        return new Between($i, $f, $boundaries);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\valueOf')) {
    function valueOf($key, Specification $constraint): Specification {
        return new ValueOf($key, $constraint);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\key')) {
    function key($key, Specification $constraint): Specification {
        return new Key($key, $constraint);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\keyExists')) {
    function keyExists($key): Specification {
        return new KeyExists($key);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\keyNotExists')) {
    function keyNotExists($key): Specification {
        return not(keyExists($key));
    }
}

if (! function_exists('BrenoRoosevelt\Specification\property')) {
    function property($key, Specification $constraint): Specification {
        return new Property($key, $constraint);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\method')) {
    function method($key, Specification $constraint): Specification {
        return new Method($key, $constraint);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\count')) {
    function count(Specification $constraint): Specification {
        return new Count($constraint);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\length')) {
    function length(Specification $constraint): Specification {
        return new Length($constraint);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\all')) {
    function all(Specification $constraint): Specification {
        return new All($constraint);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\any')) {
    function any(Specification $constraint): Specification {
        return new Any($constraint);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\none')) {
    function none(Specification $constraint): Specification {
        return new None($constraint);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\exactly')) {
    function exactly(int $count, Specification $constraint): Specification {
        return new Exactly($count, $constraint);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\atLeast')) {
    function atLeast(int $count, Specification $constraint): Specification {
        return new AtLeast($count, $constraint);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\atMost')) {
    function atMost(int $count, Specification $constraint): Specification {
        return new AtMost($count, $constraint);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\accept')) {
    function accept(iterable $collection, $rule, ...$args) {
        $rule = rule($rule, ...$args);
        if (is_array($collection)) {
            return array_filter($collection, function ($candidate) use ($rule) {
                return $rule->isSatisfiedBy($candidate);
            });
        }

        $result = clone $collection;
        foreach ($result as $key => $candidate) {
            if (!$rule->isSatisfiedBy($candidate)) {
                unset($result[$key]);
            }
        }

        return $result;
    }
}

if (! function_exists('BrenoRoosevelt\Specification\reject')) {
    function reject(iterable $collection, $rule, ...$args) {
        $rule = not(rule($rule, ...$args));
        return accept($collection, $rule);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\match')) {
    function match($candidate, Specification $specification): bool {
        return $specification->isSatisfiedBy($candidate);
    }
}

if (! function_exists('BrenoRoosevelt\Specification\match')) {
    function when($candidate, Specification $specification, callable $operation)
    {
        return $specification->isSatisfiedBy($candidate) ? $operation($candidate) : null;
    }
}

if ( !function_exists('BrenoRoosevelt\Specification\is_iterable')) {
    function is_iterable($obj): bool
    {
        return is_array($obj) || $obj instanceof \Traversable;
    }
}
