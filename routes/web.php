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

Route::get('{location}', function () {
    dump(request()->location);
    $location = Geocoder::geocode(request()->location)->get();
    dump($location);
    dump($location->count());
    foreach ($location as $item) {
        $coordinates = $item->getCoordinates();
        dump($coordinates->getLatitude() .' '. $coordinates->getLongitude());
    }
});

Route::get('/', function () {
    // dump(config('geocoder.providers.Geocoder\Provider\Chain\Chain.Geocoder\Provider\GoogleMaps\GoogleMaps.1'));
    dump(Geocoder::geocode('taizhong')->get());
    // config(['geocoder.providers.Geocoder\Provider\Chain\Chain.Geocoder\Provider\GoogleMaps\GoogleMaps.1' => 'qwe']);
    dump(config('geocoder.providers.Geocoder\Provider\Chain\Chain.Geocoder\Provider\GoogleMaps\GoogleMaps.1'));
    dump(Geocoder::geocode('gaoxiong')->get());
    // return config('geocode');
    // return view('welcome');
});


Route::get('/home', 'HomeController@index')->name('home');
