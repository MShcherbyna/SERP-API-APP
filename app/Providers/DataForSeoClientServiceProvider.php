<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\DataForSeo\DataForSeoClient;

class DataForSeoClientServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('dataForSeo', 'App\Services\DataForSeo\DataForSeoClient');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (empty($this->app->getProviders(RestClientServiceProvider::class))) {
            throw new \Exception("RestClientServiceProvider did not load");
        }
    }
}
