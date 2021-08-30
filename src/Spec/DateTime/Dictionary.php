<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec\DateTime;

interface Dictionary
{
    public function month(int $n, $short = false): string;
    public function week(int $n, $short = false): string;
}
