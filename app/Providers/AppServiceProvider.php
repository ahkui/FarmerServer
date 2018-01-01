<?php

namespace App\Providers;

use App\GoogleMapsApi;
use Config;
use Geocoder\Provider\Chain\Chain;
use Geocoder\Provider\GeoPlugin\GeoPlugin;
use Geocoder\Provider\GoogleMaps\GoogleMaps;
use Http\Client\Curl\Client;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        if (Schema::hasCollection('google_maps_apis')) {
            $apikey = GoogleMapsApi::orderBy('used_count')->first();
            Config::set('geocoder', [
                'cache-duration' => 9999999,
                'providers'      => [
                    Chain::class => [
                        GoogleMaps::class => [
                            'en-US',
                            $apikey ? $apikey->apikey : null,
                        ],
                        GeoPlugin::class  => [],
                    ],
                ],
                'adapter'  => Client::class,
            ]);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
