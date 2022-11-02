<?php

function percent($total, $individual, $decimals = 2, $thou_sep = '', $symbol = '%')
{
    return ($total != 0)
        ? (number_format((($individual * 100) / $total), $decimals, '.', $thou_sep) . $symbol)
        : 0 . $symbol;

}