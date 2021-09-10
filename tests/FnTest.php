<?php

namespace App\Tests;

use App\Absence;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;

require dirname(__FILE__) . '/../vendor/autoload.php';
require_once dirname(__FILE__) . '/../src/fn.php';

class FnTest extends TestCase
{

    /**
     * @dataProvider providerIsInclusDansPeriode
     */
    public function testIsInclusDansPeriode(DateTimeInterface $start, DateTimeInterface $end, bool $expected)
    {
        $absence = new Absence($start, $end);

        $result = isInclusDansPeriode($absence);

        $this->assertEquals($expected, $result);
    }

    public function providerIsInclusDansPeriode(): array
    {
        $today = new DateTimeImmutable();
        $currentYear = $today->format('Y');
        $currentMonth = $today->format('m');
        $currentDay = $today->format('d');
        $lastDayOfMonth = new DateTimeImmutable(getLastDayOfCurrentMonth()->format('Y-m-d H:i:s'));
        $firstDayOfMonth = new DateTimeImmutable(getFirstDayOfCurrentMonth()->format('Y-m-d H:i:s'));

        return [
            // expected true
            [$today, $today, true],
            [$today->setDate($currentYear, $currentMonth, 15), $today->setDate($currentYear, $currentMonth, 15)->modify('+1 month'), true],
            [$today->setDate($currentYear, $currentMonth, 2), $today->setDate($currentYear, $currentMonth, 16), true],
            [$today->setDate($currentYear, $currentMonth, $currentDay), $today->setDate($currentYear, $currentMonth, $currentDay), true],
            [$today->modify('-1 month'), $today->modify('+1 month'), true],
            [$lastDayOfMonth, $lastDayOfMonth->modify('+1 days'), true],
            [$firstDayOfMonth->modify('-1 day'), $firstDayOfMonth, true],
            [$firstDayOfMonth->modify('-1 day'), $firstDayOfMonth->modify('+3 day'), true],
            [$today, $today->modify('+1 year'), true],
            // expected false
            [$today->modify('-2 month'), $today->modify('-1 month'), false],
            [$today->modify('+1 month'), $today->modify('+2 month'), false],
            [$today->modify('+1 year'), $today->modify('+1 year')->modify('+1 month'), false],
        ];
    }
}