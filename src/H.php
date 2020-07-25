<?php

namespace Haruncpi\LaravelH;

class H
{
    /**
     * @return bool
     */
    public function isLocalhost()
    {
        $list = array('127.0.0.1', '::1');
        $host = $_SERVER['REMOTE_ADDR'];
        if (in_array($host, $list) || strpos($host, '.test') !== false) {
            // local
            return true;
        } else {
            //production
            return false;
        }
    }

    /**************************
     * Auth helpers
     *************************/

    /**
     * @param null $guard
     * @return bool
     */
    public function isLoggedIn($guard = null)
    {
        return auth($guard)->check();
    }

    /**
     * @param null $guard
     * @return string|null
     */
    public function getUsername($guard = null)
    {
        if (!auth($guard)->check()) return null;
        return auth($guard)->user()->name;
    }

    /**
     * @param null $guard
     * @return int|null
     */
    public function getUserId($guard = null)
    {
        if (!auth($guard)->check()) return null;
        return auth($guard)->user()->id;
    }

    /**
     * @param null $guard
     * @return string|null
     */
    public function getUserEmail($guard = null)
    {
        if (!auth($guard)->check()) return null;
        return auth($guard)->user()->email;
    }

    /**
     * @param null $guard
     * @return object|null
     */
    public function getCurrentUser($guard = null)
    {
        if (!auth($guard)->check()) return null;
        return auth($guard)->user();
    }


    /***************************
     * currency helper
     ***************************/
    /**
     * @param $amount
     * @param int $decimal
     * @return string
     */
    public function toMoney($amount, $decimal = 2)
    {
        if (is_null($amount) || !is_numeric($amount)) return $amount;
        return number_format($amount, $decimal);
    }

    /**
     * @param $number
     * @param array $option
     * @return bool|mixed|string|null
     */
    public function numberToWord($number, $option = ['decimal' => 'dollar', 'fraction' => 'cents'])
    {
        $hyphen = '-';
        $conjunction = ' and ';
        $separator = ', ';
        $negative = 'negative ';
        $decimal = ' ' . $option['decimal'] . ' ';
        $afterFraction = $option['fraction'];
        $dictionary = array(0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine', 10 => 'ten', 11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen', 19 => 'nineteen', 20 => 'twenty', 30 => 'thirty', 40 => 'fourty', 50 => 'fifty', 60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety', 100 => 'hundred', 1000 => 'thousand', 1000000 => 'million', 1000000000 => 'billion', 1000000000000 => 'trillion', 1000000000000000 => 'quadrillion', 1000000000000000000 => 'quintillion');

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int)$number < 0) || (int)$number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error('convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING);
            return false;
        }

        if ($number < 0) {
            return $negative . $this->numberToWord(abs($number));
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
                $tens = ((int)($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $this->numberToWord($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int)($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = $this->numberToWord($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->numberToWord($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string)$fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words) . " " . $afterFraction;
        }

        return $string;
    }
}