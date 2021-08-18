<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Contracts\Tests;

use BrenoRoosevelt\Contracts\Collection\Strategy\Dictionary;
use BrenoRoosevelt\Contracts\Support\StronglyTyped;
use BrenoRoosevelt\Contracts\Collection\KeyValueDotNotationTrait;
use BrenoRoosevelt\Contracts\Support\Traits\StronglyTypedTrait;

class KeyValor implements Dictionary, StronglyTyped
{
    use KeyValueDotNotationTrait;
    use StronglyTypedTrait;

    public function allowedTypes(): array
    {
        return [StronglyTyped::OBJECT];
    }
}
