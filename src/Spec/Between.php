<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

use BrenoRoosevelt\Specification\Specification;

class Between implements Specification
{
    private $i;
    private $f;

    public function __construct($i, $f)
    {
        $this->i = $i;
        $this->f = $f;
    }

    public function isSatisfiedBy($candidate): bool
    {
        return (new AllOf(new GreaterThanEqual($this->i), new LessThanEqual($this->f)))->isSatisfiedBy($candidate);
    }
}
