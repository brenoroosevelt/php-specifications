<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

use BrenoRoosevelt\Specification\Aggregate;

/**
 * check if it matches exactly one of the specifications
 */
class OneOf extends Aggregate
{
    /**
     * @inheritDoc
     */
    public function isSatisfiedBy($candidate): bool
    {
        $match = 0;
        foreach ($this->specifications as $specification) {
            if ($specification->isSatisfiedBy($candidate)) {
                $match++;
                if ($match > 1) {
                    return false;
                }
            }
        }

        return $match === 1;
    }
}
