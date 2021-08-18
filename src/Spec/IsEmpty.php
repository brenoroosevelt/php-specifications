<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

use BrenoRoosevelt\Specification\Specification;

class IsEmpty implements Specification
{
    public function isSatisfiedBy($candidate): bool
    {
        return empty($candidate);
    }
}
