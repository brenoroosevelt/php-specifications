<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

use BrenoRoosevelt\Specification\Specification;

class Exactly implements Specification
{
    /** @var Specification */
    private $constraint;

    private $count;

    public function __construct(int $count, Specification $constraint)
    {
        $this->count = $count;
        $this->constraint = $constraint;
    }

    public function isSatisfiedBy($candidate): bool
    {
        if (!is_iterable($candidate)) {
            return false;
        }

        $count = 0;
        foreach ($candidate as $value) {
            if ($this->constraint->isSatisfiedBy($value)) {
                $count++;
                if ($count > $this->count) {
                    return false;
                }
            }
        }

        return $count === $this->count;
    }
}
