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
Route::get('googlemaps', 'HomeController@googleapi');
Route::post('googlemaps', 'HomeController@addgoogleapi');

Route::get('{location}', function () {
    dump(config('geocoder.providers.Geocoder\Provider\Chain\Chain.Geocoder\Provider\GoogleMaps\GoogleMaps.1'));
    $location = Geocoder::geocode(request()->location)->get()->first();
    dump($location);
    if ($location) {
        $apikey = GoogleMapsApi::whereApikey(config('geocoder.providers.Geocoder\Provider\Chain\Chain.Geocoder\Provider\GoogleMaps\GoogleMaps.1'))->first();
        $apikey->update(['used_count'=>$apikey->used_count+1]);
    }
});
// use Geocoder\Provider\Chain\Chain;
// use Geocoder\Provider\GeoPlugin\GeoPlugin;
// use Geocoder\Provider\GoogleMaps\GoogleMaps;
// use Http\Client\Curl\Client;
// use App\GoogleMapsApi;

Route::get('/', function () {
    // dump(config('geocoder.providers.Geocoder\Provider\Chain\Chain.Geocoder\Provider\GoogleMaps\GoogleMaps.1'));
    // dump(Geocoder::geocode('taizhong')->get());
    // config(['geocoder.providers.Geocoder\Provider\Chain\Chain.Geocoder\Provider\GoogleMaps\GoogleMaps.1' => 'qwe']);
    // dump(config('geocoder.providers.Geocoder\Provider\Chain\Chain.Geocoder\Provider\GoogleMaps\GoogleMaps.1'));
    // dump(Geocoder::geocode('gaoxiong')->get());
    // return config('geocode');
    // return view('welcome');
    $settings = Config::all();
    dump($settings);
});


Route::get('/home', 'HomeController@index')->name('home');
