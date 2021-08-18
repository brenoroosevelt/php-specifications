<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

class Method extends Selector
{
    public function isSatisfiedBy($candidate): bool
    {
        $key = $this->key;
        $args = [];
        if (is_array($key)) { // method arguments, $key = ['getValueByStatus', 1]
            $args = $key;
            $key = array_shift($args);
        }

        $value = is_object($candidate) && method_exists($candidate, $key) ? $candidate->{$key}(...$args) : null;
        return $this->constraint->isSatisfiedBy($value);
    }
}
