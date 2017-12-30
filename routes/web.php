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

Route::get('/', function () {
    return view('home');

    return redirect()->route('googlemapsapi');
});

Route::get('location', function () {
    return Storage::get('location.json');
});

Route::get('/home', 'HomeController@index')->name('home');
