<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

use BrenoRoosevelt\Specification\Specification;
use Countable;
use Traversable;

class Count implements Specification
{
    /** @var Specification */
    private $constraint;

    public function __construct(Specification $constraint)
    {
        $this->constraint = $constraint;
    }

    public function isSatisfiedBy($candidate): bool
    {
        $size = null;
        if (is_array($candidate) || $candidate instanceof Countable) {
            $size = count($candidate);
        }

        if ($candidate instanceof Traversable) {
            $size = iterator_count(clone $candidate);
        }

        return $this->constraint->isSatisfiedBy($size);
    }
}
