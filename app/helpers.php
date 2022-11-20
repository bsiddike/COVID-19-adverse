<?php

use Carbon\Carbon;

if (!function_exists('percent')) {
    function percent($total, $individual, $decimals = 2, $thou_sep = '', $symbol = '%')
    {
        return ($total != 0)
            ? (number_format((($individual * 100) / $total), $decimals, '.', $thou_sep) . $symbol)
            : 0 . $symbol;
    }
}

if (!function_exists('server_date')) {
    /**
     * @param string|null $input
     * @return string|null
     */
    function server_date(string $input = null): ?string
    {
        if ($input != null) {
            $date = (DateTime::createFromFormat('m/d/Y', $input));
            if ($date instanceof DateTime) {
                return $date->format('Y-m-d');
            }
        }

        return null;
    }
}

if (!function_exists('strtonumber')) {
    /**
     * convert a string value to float character
     *
     * @param string $value
     * @param int $default
     * @return float
     */
    function strtonumber($value, $default = 0)
    {
        $floatValue = floatval(str_replace(',', '', trim($value)));

        return ($default != 0)
            ? $default
            : $floatValue;
    }
}

if (!function_exists('convert_datetime')) {
    /**
     * convert a datetime value to another timezone datetime
     *
     * @param $datetime
     * @param string $toTimeZone
     * @param string $fromTimeZone
     * @return Carbon
     */
    function convert_datetime($datetime, string $toTimeZone = 'UTC', string $fromTimeZone = 'UTC')
    {
        return Carbon::parse($datetime, $fromTimeZone)->setTimezone($toTimeZone);
    }
}

if (!function_exists('random_color')) {
    /**
     * @return string
     */
    function random_color(): string
    {
        return '#' . (str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) .
                str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT) .
                str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT));
    }
}

if (!function_exists('clean')) {
    function clean($str, $default = null)
    {
        $str = trim($str);

        return (strlen($str) > 0)
            ? trim($str)
            : $default;
    }
}

if (!function_exists('filter')) {
    function filter(array &$data)
    {
        foreach ($data as $key => $value) {
            if (is_null($data[$key])) {
                unset($data[$key]);
            }
        }
    }
}

if (!function_exists('query')) {
    function query($route, Illuminate\Http\Request $request)
    {
        return route($route) . '?' . http_build_query($request->query());
    }
}

if (!function_exists('data_limit')) {
    /**
     * @param $filename
     * @param $divider
     * @return bool
     */
    function data_limit($filename, $divider = 1)
    {
        $file_count = (int)filter_var($filename, FILTER_SANITIZE_NUMBER_INT);
        return (($file_count % $divider) == 0);
    }
}
