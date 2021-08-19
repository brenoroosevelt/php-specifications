<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

use BrenoRoosevelt\Specification\Specification;

class IsType implements Specification
{
    /** @var string */
    private $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function isSatisfiedBy($candidate): bool
    {
        return gettype($candidate) === $this->type;
    }
}
