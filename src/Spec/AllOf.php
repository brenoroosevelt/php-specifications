<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

use BrenoRoosevelt\Specification\Aggregate;

class AllOf extends Aggregate
{
    public function isSatisfiedBy($candidate): bool
    {
        if (empty($this->specifications)) {
            return false;
        }

        foreach ($this->specifications as $specification) {
            if (!$specification->isSatisfiedBy($candidate)) {
                return false;
            }
        }

        return true;
    }
}
