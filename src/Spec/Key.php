<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

class Key extends Selector
{
    public function isSatisfiedBy($candidate): bool
    {
        $value = $candidate[$this->key] ?? null;
        return $this->constraint->isSatisfiedBy($value);
    }
}
