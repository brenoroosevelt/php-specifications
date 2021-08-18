<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

abstract class MixedValue
{
    /** @var mixed */
    protected $value;

    /**
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }
}
