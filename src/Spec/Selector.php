<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

use BrenoRoosevelt\Specification\Specification;

abstract class Selector implements Specification
{
    protected $key;

    /** @var Specification */
    protected $constraint;

    public function __construct($key, Specification $constraint)
    {
        $this->key = $key;
        $this->constraint = $constraint;
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
