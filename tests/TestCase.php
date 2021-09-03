<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Tests;

use BrenoRoosevelt\Specification\Spec\DateTime\DT;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public function setUp(): void
    {
        DT::resetNow();
        parent::setUp();
    }
}
