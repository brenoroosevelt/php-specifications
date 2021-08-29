<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Tests;


use BrenoRoosevelt\Specification\Spec\DateTime\DT;

class TypeTest extends TestCase
{
    public function testTypes()
    {
        var_dump(DT::isFirstDayOfYear());
        $this->assertTrue(true);
    }
}
