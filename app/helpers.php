<?php

function percent($total, $individual, $decimals = 2, $thou_sep = '', $symbol = '%')
{
    return ($total != 0)
        ? (number_format((($individual * 100) / $total), $decimals, '.', $thou_sep) . $symbol)
        : 0 . $symbol;

}


/**
 * @param string|null $input
 * @return string|null
 */
function server_date(string $input = null): ?string
{
    if ($input != null) {
        $date = (\DateTime::createFromFormat('m/d/Y', $input));
        if ($date instanceof DateTime)
            return $date->format('Y-m-d');
    }
    return null;
}