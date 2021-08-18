<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

use BrenoRoosevelt\Specification\Specification;

class None implements Specification
{
    /** @var Specification */
    private $constraint;

    public function __construct(Specification $constraint)
    {
        $this->constraint = $constraint;
    }

    public function isSatisfiedBy($candidate): bool
    {
        if (!is_iterable($candidate)) {
            return false;
        }

        foreach ($candidate as $value) {
            if ($this->constraint->isSatisfiedBy($value)) {
                return false;
            }
        }

        return true;
    }
}
