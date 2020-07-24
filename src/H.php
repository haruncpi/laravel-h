<?php

namespace Haruncpi\LaravelH;

class H
{
    /**
     * @return string
     */
    public function version()
    {
        return 'v1.0.0';
    }

    /**
     * @return bool
     */
    public function isLocalhost()
    {
        $list = array('127.0.0.1', '::1');

        if (in_array($_SERVER['REMOTE_ADDR'], $list)) {
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
     * @return bool
     */
    public function isLoggedIn()
    {
        return auth()->check();
    }

    /**
     * @return string|null
     */
    public function getUsername()
    {
        if (!auth()->check()) return null;
        return auth()->user()->name;
    }

    /**
     * @return int|null
     */
    public function getUserId()
    {
        if (!auth()->check()) return null;
        return auth()->user()->id;
    }

    /**
     * @return string|null
     */
    public function getUserEmail()
    {
        if (!auth()->check()) return null;
        return auth()->user()->email;
    }

    /**
     * @return object|null
     */
    public function getCurrentUser()
    {
        if (!auth()->check()) return null;
        return auth()->user();
    }


    /***************************
     * currency helper
     ***************************/
    
    function toMoney($amount)
    {
        if (is_null($amount)) return $amount;
        return number_format($amount, 2);
    }
}