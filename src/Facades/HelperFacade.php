<?php

namespace Haruncpi\LaravelH\Facades;

use Illuminate\Support\Facades\Facade;


class HelperFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return \Haruncpi\LaravelH\H::class;
    }
}