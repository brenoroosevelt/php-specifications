<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification;

/**
 * Double dispatch for candidates
 */
trait Candidate
{
    public function isSatisfiedBy(Specification $specification): bool
    {
        return $specification->isSatisfiedBy($this);
    }
}
