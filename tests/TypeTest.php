<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Tests;


use BrenoRoosevelt\Specification\Validator;
use function BrenoRoosevelt\Specification\between;
use function BrenoRoosevelt\Specification\in;
use function BrenoRoosevelt\Specification\isNotEmpty;
use function BrenoRoosevelt\Specification\length;

class TypeTest extends TestCase
{
    public function testTypes()
    {
        $v = new Validator;

        $fn = function ($v) {
            return is_bool($v);
        };

        $v
            ->field('nome', in(['1', '3']), 'não pode ser vazio')
            ->field('nome', $fn , 'deveser booleano')
            ->field('nome', length(between(5, 10)), 'Tamanho entre 1 e 10')
            ->notRequired('age')
            ->field('age', length(between(5, 10)), 'age entre 1 e 10')
            ->allowsEmpty('age');

        $errros = $v->getErrors(['nome' => '1']);
        var_dump($errros);
    }
}
