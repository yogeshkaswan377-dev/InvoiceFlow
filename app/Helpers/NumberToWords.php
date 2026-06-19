<?php

namespace App\Helpers;

class NumberToWords
{
    public static function convert($number)
    {
        $number = abs(round($number));

        if ($number == 0) return 'Zero';

        $ones = [
            '',
            'One',
            'Two',
            'Three',
            'Four',
            'Five',
            'Six',
            'Seven',
            'Eight',
            'Nine',
            'Ten',
            'Eleven',
            'Twelve',
            'Thirteen',
            'Fourteen',
            'Fifteen',
            'Sixteen',
            'Seventeen',
            'Eighteen',
            'Nineteen'
        ];
        $tens = ['', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'];

        $result = '';

        if ($number >= 10000000) {
            $result .= self::convert(intdiv($number, 10000000)) . ' Crore ';
            $number %= 10000000;
        }
        if ($number >= 100000) {
            $result .= self::convert(intdiv($number, 100000)) . ' Lakh ';
            $number %= 100000;
        }
        if ($number >= 1000) {
            $result .= self::convert(intdiv($number, 1000)) . ' Thousand ';
            $number %= 1000;
        }
        if ($number >= 100) {
            $result .= $ones[intdiv($number, 100)] . ' Hundred ';
            $number %= 100;
        }
        if ($number >= 20) {
            $result .= $tens[intdiv($number, 10)] . ' ';
            $number %= 10;
        }
        if ($number > 0) {
            $result .= $ones[$number] . ' ';
        }

        return trim($result);
    }

    /**
     * Format number in Indian comma system (12,34,567.89)
     */
    public static function indianFormat($number)
    {
        $number = round($number, 2);
        $parts = explode('.', number_format($number, 2, '.', ''));
        $integer = $parts[0];
        $decimal = $parts[1] ?? '00';

        $last3 = substr($integer, -3);
        $rest = substr($integer, 0, -3);

        if ($rest != '') {
            $rest = preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $rest);
            $integer = $rest . ',' . $last3;
        } else {
            $integer = $last3;
        }

        return $integer . '.' . $decimal;
    }
}
