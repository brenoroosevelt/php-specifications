<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

use BrenoRoosevelt\Specification\Specification;

class PregMatch implements Specification
{
    /** @var string */
    private $pattern;

    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

    public function isSatisfiedBy($candidate): bool
    {
        return is_string($candidate) && preg_match($this->pattern, $candidate) === 1;
    }
}
