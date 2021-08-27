<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

use BrenoRoosevelt\Specification\Specification;

class Between implements Specification
{
    private $i;
    private $f;
    private $boundaries;

    public function __construct($i, $f, bool $boundaries = true)
    {
        $this->i = $i;
        $this->f = $f;
        $this->boundaries = $boundaries;
    }

    public function isSatisfiedBy($candidate): bool
    {
        $rule =
            $this->boundaries ?
                new AllOf(new GreaterThanEqual($this->i), new LessThanEqual($this->f)) :
                new AllOf(new GreaterThan($this->i), new LessThan($this->f));

        return $rule->isSatisfiedBy($candidate);
    }
}
