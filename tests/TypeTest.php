<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Contracts\Tests;


use BrenoRoosevelt\Contracts\Collection\Type\Collection;
use function BrenoRoosevelt\Specification\all;
use function BrenoRoosevelt\Specification\anyOf;
use function BrenoRoosevelt\Specification\equals;
use function BrenoRoosevelt\Specification\isNotEmpty;
use function BrenoRoosevelt\Specification\length;
use function BrenoRoosevelt\Specification\none;
use function \BrenoRoosevelt\Specification\key;
use function BrenoRoosevelt\Specification\valueOf;

class TypeTest extends TestCase
{
    public function testTypes()
    {
        $groups = [
            [
                'nome' => 'breno',
                'idade' => 10,
                'ativo' => true,
            ],
            [
                'nome' => 'wellyta',
                'idade' => 30,
                'ativo' => true,
            ],
            [
                'nome' => 'pablo',
                'idade' => 45,
                'ativo' => false,
            ]
        ];

//        $r = accept($groups, valueOf('idade', isNull()));
//
//        var_dump($r);
self::countOf()

        valueOf(1, anyOf());


        var_dump(all(valueOf('idade', equals(450)))->isSatisfiedBy($groups));
        //var_dump(accept($groups, contains(1));

        return;
        $a = new \stdClass();
        $b = new \stdClass();
        $c = new \stdClass();
        $d = new \stdClass();

        $a->valor = 10;
        $b->valor = 20;
        $c->valor = 30;

        $b->status = 'inativo';
        $c->status = 'ativo';
        $d->status = 'ativo';

        $e = [
            'valor' => 45,
            'status' => 'inativo'
        ];

        $col = new Collection();
        $col->set('val1', 9999);
        $col->add($a, $b, $c, $d, $e);
        $col->pad(-10, 1);
        $v=$col->sumBy('valor');
        $gr = $col->groupBy('status');

//        var_dump($v);
//        var_dump($gr);
        var_dump($col->values());

//        $d2 = $d1->add(1,2,3);
//        $d3 = $d2->remove(2);
//        $d4 = $d3->delete(1, 2);
//
//        $this->assertNotSame($d1, $d2);
//        var_dump($d1->values());
//        var_dump($d3->values());
//        var_dump($d4->values());
//
//        $d5 = $d4->each(function ($v) {
//            $v = 8;
//        });
//
//        var_dump($d5->values());
        $this->assertTrue(true);
    }
}
