<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

use BrenoRoosevelt\Specification\Specification;

class AlwaysTrue implements Specification
{
    public function isSatisfiedBy($candidate): bool
    {
       return true;
    }
}
