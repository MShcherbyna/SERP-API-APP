<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class DataForSeo extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'dataForSeo';
    }
}
