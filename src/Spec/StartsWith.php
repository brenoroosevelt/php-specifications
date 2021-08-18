<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

use BrenoRoosevelt\Specification\Specification;

class StartsWith extends MixedValue implements Specification
{
    /** @var bool */
    private $caseSensitive;

    public function __construct(string $prefix, bool $caseSensitive = true)
    {
        parent::__construct($prefix);
        $this->caseSensitive = $caseSensitive;
    }

    public function isSatisfiedBy($candidate): bool
    {
        if (!is_string($candidate)) {
            return false;
        }

        return $this->caseSensitive ?
            0 === strpos($candidate, $this->value) :
            0 === stripos($candidate, $this->value);
    }
}
