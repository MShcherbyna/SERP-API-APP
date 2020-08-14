<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\DataForSeo\RestClient;

class RestClientServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(RestClient::class, function ($app) {
            return new RestClient(
                config('dataforseo.ba_host'),
                null,
                config('dataforseo.ba_user'),
                config('dataforseo.ba_password')
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
