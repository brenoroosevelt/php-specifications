<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

use BrenoRoosevelt\Specification\Specification;

class EndsWith extends MixedValue implements Specification
{
    /** @var bool */
    private $caseSensitive;

    public function __construct(string $suffix, bool $caseSensitive = true)
    {
        parent::__construct($suffix);
        $this->caseSensitive = $caseSensitive;
    }

    public function isSatisfiedBy($candidate): bool
    {
        if (!is_string($candidate)) {
            return false;
        }

        if (($length = mb_strlen($this->value)) === 0) {
            return true;
        }

        return
            $this->caseSensitive ?
                substr($candidate, -$length) === $this->value :
                strcasecmp(substr($candidate, -$length), $this->value) === 0;
    }
}
