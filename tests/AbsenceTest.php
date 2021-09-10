<?php

namespace App\Tests;

require dirname(__FILE__).'/../vendor/autoload.php';

use App\Absence;
use DateTime;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;

class AbsenceTest extends TestCase
{
    /**
     * @dataProvider providerGetter
     * @param DateTimeInterface $start
     */
    public function testGetStart(DateTimeInterface $start)
    {
        $absence = new Absence($start, new DateTime());

        $this->assertEquals($start, $absence->getStart());
    }

    /**
     * @dataProvider providerGetter
     * @param DateTimeInterface $end
     */
    public function testGetEnd(DateTimeInterface $end)
    {
        $absence = new Absence(new DateTime(), $end);

        $this->assertEquals($end, $absence->getEnd());
    }

    public function providerGetter(): array
    {
        return [
            [new DateTime()],
            [new DateTime('2021-09-08')],
            [new DateTime('2021-05-08')],
            [new DateTime('2024-05-07')],
        ];
    }
}