<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

use BrenoRoosevelt\Specification\Specification;

class Length implements Specification
{
    /** @var Specification */
    private $constraint;

    public function __construct(Specification $constraint)
    {
        $this->constraint = $constraint;
    }

    public function isSatisfiedBy($candidate): bool
    {
        $size = is_string($candidate) ? mb_strlen($candidate) : null;
        return $this->constraint->isSatisfiedBy($size);
    }
}
