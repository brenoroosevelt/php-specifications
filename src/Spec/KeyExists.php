<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

use BrenoRoosevelt\Specification\Specification;

class KeyExists extends MixedValue implements Specification
{
    public function isSatisfiedBy($candidate): bool
    {
        if (is_array($candidate)) {
            return array_key_exists($this->value, $candidate);
        }

        if ($candidate instanceof \ArrayAccess) {
            return $candidate->offsetExists($this->value);
        }

        return false;
    }
}
