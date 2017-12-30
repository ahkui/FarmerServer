<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Geocoder\Provider\Chain\Chain;
use Geocoder\Provider\GeoPlugin\GeoPlugin;
use Geocoder\Provider\GoogleMaps\GoogleMaps;
use Http\Client\Curl\Client;
use App\GoogleMapsApi;
use Config;

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
        
        if (Schema::hasTable('google_maps_apis')) {
            $apikey = GoogleMapsApi::orderBy('used_count')->first();
            Config::set('geocoder',[
                'cache-duration' => 9999999,
                'providers' => [
                    Chain::class => [
                        GoogleMaps::class => [
                            'en-US',
                            $apikey?$apikey->apikey:null,
                        ],
                        GeoPlugin::class  => [],
                    ],
                ],
                'adapter'  => Client::class,
            ]);
        }

        // Schema::create('users_collection', function($collection)
        // {

        //     $collection->unique('email');
        // });
        
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
