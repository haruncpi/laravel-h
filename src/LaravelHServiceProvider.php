<?php

namespace Haruncpi\LaravelH;

use Illuminate\Support\ServiceProvider;

class LaravelHServiceProvider extends ServiceProvider
{

    public function boot()
    {
    }


    public function register()
    {
        $this->app->make(H::class);

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('H', \Haruncpi\LaravelH\Facades\HelperFacade::class);
        $loader->alias('F', \Haruncpi\LaravelH\Facades\FormFacade::class);
    }
}