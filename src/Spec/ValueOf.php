<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

/**
 * generic selector
 */
class ValueOf extends Selector
{
    public function isSatisfiedBy($candidate): bool
    {
        if (is_array($candidate)) {
            return (new Key($this->key, $this->constraint))->isSatisfiedBy($candidate);
        }

        if (is_object($candidate) && property_exists($candidate, $this->key)) {
            return (new Property($this->key, $this->constraint))->isSatisfiedBy($candidate);
        }

        return (new Method($this->key, $this->constraint))->isSatisfiedBy($candidate);
    }
}
