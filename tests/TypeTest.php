<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Tests;


use BrenoRoosevelt\Specification\Spec\DateTime\DT;
use BrenoRoosevelt\Specification\Spec\DateTime\pt_BR;

class TypeTest extends TestCase
{
    public function testTypes()
    {
//        $currentLocale = setlocale(LC_TIME, 0);

//        $currentLocale = setlocale(LC_TIME, "pt_BR");
//        $currentLocale = setlocale(LC_TIME, "C");
        var_dump(DT::isLastDayOfMonth(DT::immutable()));
        $this->assertTrue(true);
    }
}
