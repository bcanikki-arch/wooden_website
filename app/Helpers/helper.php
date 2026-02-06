<?php

use App\Models\Sitesetting;

function setting($field = null, $default = null)
{
    $setting = SiteSetting::first();
    if (!$setting) {
        return $default;
    }

    if (is_null($field)) {
        return $setting->toArray();
    }

    return $setting->$field ?? $default;
}

if (!function_exists('indianCurrency')) {
    function indianCurrency($amount)
    {
        $amount = number_format($amount, 2, '.', '');
        $parts = explode('.', $amount);
        $integer = $parts[0];
        $decimal = $parts[1];

        if (strlen($integer) > 3) {
            $last3 = substr($integer, -3);
            $rest = substr($integer, 0, -3);
            $rest = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $rest);
            $integer = $rest . "," . $last3;
        }

        return "₹ " . $integer . "." . $decimal;
    }
}

if (!function_exists('convertNumberToWords')) {
    function convertNumberToWords($number)
    {
        $hyphen      = '-';
        $conjunction = ' and ';
        $separator   = ', ';
        $negative    = 'negative ';
        $decimal     = ' point ';

        $dictionary  = [
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'forty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
            100 => 'hundred',
            1000 => 'thousand',
            100000 => 'lakh',
            10000000 => 'crore',
        ];

        if (!is_numeric($number)) {
            return false;
        }

        if ($number < 0) {
            return $negative . convertNumberToWords(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;

            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;

            case $number < 1000:
                $hundreds  = floor($number / 100);
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' hundred';
                if ($remainder) {
                    $string .= $conjunction . convertNumberToWords($remainder);
                }
                break;

            case $number < 100000:
                $thousands = floor($number / 1000);
                $remainder = $number % 1000;
                $string = convertNumberToWords($thousands) . ' thousand';
                if ($remainder) {
                    $string .= $separator . convertNumberToWords($remainder);
                }
                break;

            case $number < 10000000:
                $lakhs = floor($number / 100000);
                $remainder = $number % 100000;
                $string = convertNumberToWords($lakhs) . ' lakh';
                if ($remainder) {
                    $string .= $separator . convertNumberToWords($remainder);
                }
                break;

            default:
                $crores = floor($number / 10000000);
                $remainder = $number % 10000000;
                $string = convertNumberToWords($crores) . ' crore';
                if ($remainder) {
                    $string .= $separator . convertNumberToWords($remainder);
                }
                break;
        }

        if ($fraction !== null && is_numeric($fraction)) {
            $string .= $decimal;
            $words = [];
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return ucfirst($string);
    }
}
