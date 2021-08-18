<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

use BrenoRoosevelt\Specification\Specification;

class Not implements Specification
{
    /** @var Specification */
    private $specification;

    public function __construct(Specification $specification)
    {
        $this->specification = $specification;
    }

    public function isSatisfiedBy($candidate): bool
    {
       return !$this->specification->isSatisfiedBy($candidate);
    }
}
