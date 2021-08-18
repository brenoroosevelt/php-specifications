<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification;

use BrenoRoosevelt\Specification\Spec\Rule;

abstract class Aggregate implements Specification, Chainable
{
    /** @var Specification[] */
    protected $specifications;

    public function __construct(Specification ...$specifications)
    {
        $this->specifications = $specifications;
    }

    public function chain(Specification $specification)
    {
        $this->specifications[] = $specification;
    }
}
