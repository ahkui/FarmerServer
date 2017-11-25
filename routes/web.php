<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::any('adminer', '\Miroc\LaravelAdminer\AdminerAutologinController@index');

Auth::routes();

use App\GoogleMapsApi;

Route::get('googlemaps', 'HomeController@googleapi')->name('googlemapsapi');
Route::post('googlemaps', 'HomeController@addgoogleapi');

Route::get('{location}', function () {
    $currentApiKey = config('geocoder.providers.Geocoder\Provider\Chain\Chain.Geocoder\Provider\GoogleMaps\GoogleMaps.1');
    dump($currentApiKey);
    if ($currentApiKey) {
        $location = Geocoder::geocode(request()->location)->get()->first();
        if ($location) {
            dump($location);
            $apikey = GoogleMapsApi::whereApikey($currentApiKey)->first();
            dump($apikey);
            if($apikey)
                $apikey->update(['used_count'=>$apikey->used_count+1]);
        }
    }
});

Route::get('/', function () {
    return redirect()->route('googlemapsapi');
});


Route::get('/home', 'HomeController@index')->name('home');
