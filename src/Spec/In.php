<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec;

class In extends Contains
{
    public function isSatisfiedBy($candidate): bool
    {
        return $this->contains($candidate, $this->value, $this->strict);
    }
}
