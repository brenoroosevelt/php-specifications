<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

class Property extends Selector
{
    public function isSatisfiedBy($candidate): bool
    {
        $value = is_object($candidate) && property_exists($candidate, $this->key) ? $candidate->{$this->key} : null;
        return $this->constraint->isSatisfiedBy($value);
    }
}
