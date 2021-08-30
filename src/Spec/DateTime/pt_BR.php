<?php
declare(strict_types=1);

namespace BrenoRoosevelt\Specification\Spec\DateTime;

class pt_BR implements Dictionary
{
    public static $months = [
        1 => 'Janeiro',
        2 => 'Fevereiro',
        3 => 'Março',
        4 => 'Abril',
        5 => 'Maio',
        6 => 'Junho',
        7 => 'Julho',
        8 => 'Agosto',
        9 => 'Setembro',
        10 => 'Outubro',
        11 => 'Novembro',
        12 => 'Dezembro',
    ];

    public static $weeks = [
        1 => 'Segunda-feira',
        2 => 'Terça-feira',
        3 => 'Quarta-feira',
        4 => 'Quinta-feira',
        5 => 'Sexta-feira',
        6 => 'Sábado',
        7 => 'Domingo',
    ];

    public function month(int $n, $short = false): string
    {
        $month = self::$months[$n];
        return $short ? substr($month, 0, 3) : $month;
    }

    public function week(int $n, $short = false): string
    {
        $week = self::$weeks[$n];
        return $short ? substr($week, 0, 3) : $week;
    }
}
