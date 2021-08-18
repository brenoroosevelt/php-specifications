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
