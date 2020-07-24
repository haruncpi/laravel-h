<?php

namespace Haruncpi\LaravelH\Facades;

use Illuminate\Support\Facades\Facade;


class FormFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return \Haruncpi\LaravelH\F::class;
    }
}
