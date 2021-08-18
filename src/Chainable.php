<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification;

interface Chainable extends Specification
{
    /**
     * Appends the new specification
     *
     * @param Specification $specification
     * @return mixed
     */
    public function chain(Specification $specification);
}
