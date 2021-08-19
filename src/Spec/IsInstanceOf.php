<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

use BrenoRoosevelt\Specification\Specification;

class IsInstanceOf implements Specification
{
    /** @var string */
    private $className;

    /**
     * @param string|object $classOrObject
     */
    public function __construct($classOrObject)
    {
        $this->className = $classOrObject;
    }

    public function isSatisfiedBy($candidate): bool
    {
        return $candidate instanceof $this->className;
    }
}
