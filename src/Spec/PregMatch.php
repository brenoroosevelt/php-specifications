<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

use BrenoRoosevelt\Specification\Specification;
use Throwable;

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
        try {
            $subject = (string) $candidate;
            return preg_match($this->pattern, $subject) === 1;
        } catch (Throwable $exception) {
        }

        return false;
    }
}
