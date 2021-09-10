<?php

use App\Absence;

function isInclusDansPeriode(Absence $absence): bool
{
    $firstDay = getFirstDayOfCurrentMonth();
    $lastDay = getLastDayOfCurrentMonth();

    if ($absence->getStart() > $firstDay && $absence->getStart() <= $lastDay) {
        return true;
    }

    if ($absence->getEnd() > $firstDay && $absence->getEnd() < $lastDay) {
        return true;
    }

    if ($absence->getStart() <= $firstDay && $absence->getEnd() >= $firstDay) {
        return true;
    }

    return false;
}

function getLastDayOfCurrentMonth(): DateTime
{
    $now = new DateTime();

    return new DateTime($now->format('Y-m-t 23:59:59'));
}

function getFirstDayOfCurrentMonth(): DateTime
{
    $now = new DateTime();

    return new DateTime($now->format('Y-m-01 00:00:00'));
}