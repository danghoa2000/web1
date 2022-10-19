<?php

namespace App;

if (!function_exists('number_format_short')) {
    function number_format_short($n, $precision = 0)
    {
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            return $n_format;
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            return $n_format . 'k';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            return $n_format . 'M';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            return $n_format . 'K';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            return $n_format . 'T';
        }
    }
}
