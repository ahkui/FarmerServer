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
use App\ConvertedAddressData;

Route::get('googlemaps', 'HomeController@googleapi')->name('googlemapsapi');
Route::post('googlemaps', 'HomeController@addgoogleapi');

Route::get('{location}', function () {
    $currentApiKey = config('geocoder.providers.Geocoder\Provider\Chain\Chain.Geocoder\Provider\GoogleMaps\GoogleMaps.1');
    if ($currentApiKey) {
        $location = Geocoder::geocode(request()->location)->get()->first();
        if ($location) {
            dump($location);
            $data = collect();
            $temp = collect();
            foreach ($location->getAdminLevels() as $key => $value) {
                $temp->put($key,$value->getName());
            }
            $data->put('levels',$temp);
            $temp = collect();
            $temp->put('south',$location->getBounds()->getSouth());
            $temp->put('west',$location->getBounds()->getWest());
            $temp->put('north',$location->getBounds()->getNorth());
            $temp->put('east',$location->getBounds()->getEast());
            $data->put('bounds',$temp);
            $data->put('country',$location->getCountry()->getName());
            $data->put('address',$location->getFormattedAddress());
            $data->put('latitude',$location->getCoordinates()->getLatitude());
            $data->put('longitude',$location->getCoordinates()->getLongitude());

            ConvertedAddressData::updateOrCreate([
                'longitude'=>$data['longitude'],
                'latitude'=>$data['latitude'],
            ],$data->toArray());
            
            $apikey = GoogleMapsApi::whereApikey($currentApiKey)->first();
            if($apikey)
                $apikey->update(['used_count'=>$apikey->used_count+1]);
        }
    }
    // dump(ConvertedAddressData::get()->last());
});

Route::get('/', function () {
    return redirect()->route('googlemapsapi');
});


Route::get('/home', 'HomeController@index')->name('home');
