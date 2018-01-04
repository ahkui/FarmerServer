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

use App\ConvertedAddressData;
use App\OriginalAddressData;

Route::get('googlemaps', 'HomeController@googleapi')->name('googlemapsapi');
Route::post('googlemaps', 'HomeController@addgoogleapi');

Route::get('/', function () {
    return view('home');

    return redirect()->route('googlemapsapi');
});

Route::get('location', function () {
    return Storage::get('location.json');
});

Route::get('/home', 'HomeController@index')->name('home');
    use App\GoogleMapsApi;

Route::get('now', function () {
    dump(
        OriginalAddressData::whereNull('is_converted')->get()
    );
    dump(
        ConvertedAddressData::where('location', 'near', [
            '$geometry' => [
                'type'        => 'Point',
                'coordinates' => [
                        121.5063464,
                        25.02963,
                ],
            ],
            '$maxDistance' => 1000,
        ])->get()
    );
    return Carbon\Carbon::now();
});
