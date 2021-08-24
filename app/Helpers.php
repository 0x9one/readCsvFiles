<?php

declare(strict_types = 1);

// create a function to format amount price

function formatDollarAmount(float $amount): string 
{

    $isNegative = $amount < 0;

    return ($isNegative ? '-' : '') . '$' . number_format(abs($amount), 2);

}

// create a function to format date

function formatDate(string $date): string
{
    return date('M j, Y', strtotime($date));
}