<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

use BrenoRoosevelt\Specification\Aggregate;

class NoneOf extends Aggregate
{
    public function isSatisfiedBy($candidate): bool
    {
        foreach ($this->specifications as $specification) {
            if ($specification->isSatisfiedBy($candidate)) {
                return false;
            }
        }

        return true;
    }
}
