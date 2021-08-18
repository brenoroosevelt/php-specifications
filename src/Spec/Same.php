<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

use BrenoRoosevelt\Specification\Specification;

class Same extends MixedValue implements Specification
{
    public function isSatisfiedBy($candidate): bool
    {
        return $candidate === $this->value;
    }
}
