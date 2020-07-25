<?php

use Haruncpi\LaravelH\F;
use Haruncpi\LaravelH\H;

if (!function_exists('f')) {
    function f()
    {
        return new F();
    }
}

if (!function_exists('h')) {
    function h()
    {
        return new H();
    }
}