<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification;

class Validation implements Specification
{
    const DEFAULT_MESSAGE = 'Invalid input';

    /** @var Specification */
    private $rule;

    /** @var string */
    private $errorMessage;

    public function __construct($rule, ?string $errorMessage = null)
    {
        $this->rule = $rule instanceof Specification ? $rule : rule($rule);
        $this->errorMessage = $errorMessage ?? self::DEFAULT_MESSAGE;
    }

    public function specification(): Specification
    {
        return $this->rule;
    }

    public function errorMessage(): string
    {
        return $this->errorMessage;
    }

    public function isSatisfiedBy($candidate): bool
    {
        return $this->rule->isSatisfiedBy($candidate);
    }
}
