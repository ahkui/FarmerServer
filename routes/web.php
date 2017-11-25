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
use App\OriginalAddressData;

Route::get('googlemaps', 'HomeController@googleapi')->name('googlemapsapi');
Route::post('googlemaps', 'HomeController@addgoogleapi');

Route::get('/', function () {
    return redirect()->route('googlemapsapi');
    $currentApiKey = config('geocoder.providers.Geocoder\Provider\Chain\Chain.Geocoder\Provider\GoogleMaps\GoogleMaps.1');
    if ($currentApiKey) {
        $apikey = GoogleMapsApi::whereApikey($currentApiKey)->first();
        foreach (OriginalAddressData::whereIsConverted(false)->whereIsFail(false)->take(50)->get() as $item) {
            $location = Geocoder::geocode($item->address)->get()->first();
            if($apikey) $apikey->update(['used_count'=>$apikey->used_count+1]);
            if (!$location) {
                $location = Geocoder::geocode($item->name)->get()->first();
                if($apikey) $apikey->update(['used_count'=>$apikey->used_count+1]);
            }
            if ($location) {
                $data = collect();
                $temp = collect();
                foreach ($location->getAdminLevels() as $key => $value) {
                    $temp->put($key,$value?$value->getName():'');
                }
                $data->put('levels',$temp);
                $temp = collect();
                $temp->put('south',$location->getBounds()->getSouth());
                $temp->put('west',$location->getBounds()->getWest());
                $temp->put('north',$location->getBounds()->getNorth());
                $temp->put('east',$location->getBounds()->getEast());
                $data->put('bounds',$temp);
                $data->put('country',$location->getCountry()?$location->getCountry()->getName():'');
                $data->put('address',$location->getFormattedAddress());
                $data->put('latitude',$location->getCoordinates()->getLatitude());
                $data->put('longitude',$location->getCoordinates()->getLongitude());
                $data->put('longitude',$location->getCoordinates()->getLongitude());
                $data->put('name',$item->name);
                ConvertedAddressData::updateOrCreate([
                    'longitude'=>$data['longitude'],
                    'latitude'=>$data['latitude'],
                ],$data->toArray());
                
                $item->update(['is_converted'=>true,'is_fail'=>false]);
            }
            else{
                $item->update(['is_fail'=>true]);
            }
        }
    }
});

Route::get('/home', 'HomeController@index')->name('home');
