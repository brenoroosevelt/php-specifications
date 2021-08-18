<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification;

use BrenoRoosevelt\Specification\Spec\AllOf;
use BrenoRoosevelt\Specification\Spec\AnyOf;
use BrenoRoosevelt\Specification\Spec\Between;
use BrenoRoosevelt\Specification\Spec\OneOf;

class Chained implements Specification
{
    /** @var Chainable */
    private $chain;

    public function __construct(Chainable $chain)
    {
        $this->chain = $chain;
    }

    /**
     * @inheritDoc
     */
    public function isSatisfiedBy($candidate): bool
    {
        return $this->chain->isSatisfiedBy($candidate);
    }

    protected function append(Specification $specification): self
    {
        $this->chain->chain($specification);
        return $this;
    }

    public function rule($rule, ...$args): self
    {
        return $this->append(rule($rule, ...$args));
    }

    public function not(Specification $specification): self
    {
        return $this->append(not($specification));
    }

    public function and(Specification $specification, Specification ...$specifications): self
    {
        return $this->append(new AllOf($specification, ...$specifications));
    }

    public function or(Specification $specification, Specification ...$specifications): self
    {
        return $this->append(new AnyOf($specification, ...$specifications));
    }

    public function xor(Specification $a, Specification $b): self
    {
        return $this->append(new OneOf($a, $b));
    }

    public function true(): self
    {
        return $this->append(true());
    }

    public function false(): self
    {
        return $this->append(false());
    }

    public function contains($v, bool $strict = true): self
    {
        return $this->append(contains($v, $strict));
    }

    public function notContains($v, bool $strict = true): self
    {
        return $this->append(notContains($v, $strict));
    }

    public function in($v, bool $strict = true): self
    {
        return $this->append(in($v, $strict));
    }

    public function notIn($v, bool $strict = true): self
    {
        return $this->append(notIn($v, $strict));
    }

    public function isNull(): self
    {
        return $this->append(isNull());
    }

    public function isNotNull(): self
    {
        return $this->append(isNotNull());
    }

    public function isEmpty(): self
    {
        return $this->append(isEmpty());
    }

    public function isNotEmpty(): self
    {
        return $this->append(IsNotEmpty());
    }

    public function equals($v): self
    {
        return $this->append(equals($v));
    }

    public function notEquals($v): self
    {
        return $this->append(notEquals($v));
    }

    public function same($v): self
    {
        return $this->append(same($v));
    }

    public function notSame($v): self
    {
        return $this->append(notSame($v));
    }

    public function lessThan($v): self
    {
        return $this->append(lessThan($v));
    }

    public function lessThanEqual($v): self
    {
        return $this->append(lessThanEqual($v));
    }

    public function greaterThan($v): self
    {
        return $this->append(greaterThan($v));
    }

    public function greaterThanEqual($v): self
    {
        return $this->append(greaterThanEqual($v));
    }

    public function between($i, $f): self
    {
        return $this->append(between($i, $f));
    }

    public function valueOf($key, Specification $constraint): self
    {
        return $this->append(valueOf($key, $constraint));
    }

    public function key($key, Specification $constraint): self
    {
        return $this->append(key($key, $constraint));
    }

    public function property($key, Specification $constraint): self
    {
        return $this->append(property($key, $constraint));
    }

    public function method($key, Specification $constraint): self
    {
        return $this->append(method($key, $constraint));
    }

    public function count(Specification $constraint): self
    {
        return $this->append(count($constraint));
    }

    public function length(Specification $constraint): self
    {
        return $this->append(length($constraint));
    }

    public function all(Specification $constraint): self
    {
        return $this->append(all($constraint));
    }

    public function any(Specification $constraint): self
    {
        return $this->append(any($constraint));
    }

    public function none(Specification $constraint): self
    {
        return $this->append(none($constraint));
    }

    public function exactly(int $count, Specification $constraint): self
    {
        return $this->append(exactly($count, $constraint));
    }

    public function atLeast(int $count, Specification $constraint): self
    {
        return $this->append(atLeast($count, $constraint));
    }

    public function atMost(int $count, Specification $constraint): self
    {
        return $this->append(atMost($count, $constraint));
    }

    public function spec(Specification $expr): Specification
    {
        return $this->append($expr);
    }
}
