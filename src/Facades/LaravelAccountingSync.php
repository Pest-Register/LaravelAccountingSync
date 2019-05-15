<?php

namespace PestRegister\LaravelAccountingSync\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelAccountingSync extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravelaccountingsync';
    }
}
