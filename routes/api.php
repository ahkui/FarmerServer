<?php

use App\FarmPlace;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//*********Don't Touch!!!!**********//
Route::post('deploy', function () {
    ini_set('max_execution_time', 300);
    $cmd = 'cd /var/www;/usr/bin/git fetch origin 2>&1;/usr/bin/git reset --hard origin/master 2>&1;chmod -R 777 /var/www/storage;composer dump-autoload;php artisan clear-compiled;php artisan view:clear;php artisan config:clear;php artisan queue:restart';
    exec($cmd, $output, $return);
    if ($return !== 0) {
        return response($output, 500);
    }
    $exitCode = Artisan::call('migrate');

    return ['gitdeploy'=>$output, 'migrate'=>$exitCode];
});
//*********Don't Touch!!!!**********//

// Route::post('{name}', function () {
//     return \App\Book::get();

//     return request()->name;
// });
// Route::get('{name}', function () {
//     \App\User::firstOrCreate([
//         'name' => 'ahkui',
//         'email'=> 'ahkui@outlook.com',
//     ]);

//     return \App\User::get();

//     return request()->name;
// });

Route::get('path', function () {
    $lat = request()->lat;
    $long = request()->long;
    $meter = 100;
    $tags = ['accounting', 'airport', 'amusement_park', 'aquarium', 'art_gallery', 'atm', 'bakery', 'bank', 'bar', 'beauty_salon', 'bicycle_store', 'book_store', 'bowling_alley', 'bus_station', 'cafe', 'campground', 'car_dealer', 'car_rental', 'car_repair', 'car_wash', 'casino', 'cemetery', 'church', 'city_hall', 'clothing_store', 'convenience_store', 'courthouse', 'dentist', 'department_store', 'doctor', 'electrician', 'electronics_store', 'embassy', 'fire_station', 'florist', 'funeral_home', 'furniture_store', 'gas_station', 'gym', 'hair_care', 'hardware_store', 'hindu_temple', 'home_goods_store', 'hospital', 'insurance_agency', 'jewelry_store', 'laundry', 'lawyer', 'library', 'liquor_store', 'local_government_office', 'locksmith', 'lodging', 'meal_delivery', 'meal_takeaway', 'mosque', 'movie_rental', 'movie_theater', 'moving_company', 'museum', 'night_club', 'painter', 'park', 'parking', 'pet_store', 'pharmacy', 'physiotherapist', 'plumber', 'police', 'post_office', 'real_estate_agency', 'restaurant', 'roofing_contractor', 'rv_park', 'school', 'shoe_store', 'shopping_mall', 'spa', 'stadium', 'storage', 'store', 'subway_station', 'supermarket', 'synagogue', 'taxi_stand', 'train_station', 'transit_station', 'travel_agency', 'veterinary_care', 'zoo', 'administrative_area_level_1', 'administrative_area_level_2', 'administrative_area_level_3', 'administrative_area_level_4', 'administrative_area_level_5', 'colloquial_area', 'country', 'establishment', 'finance', 'floor', 'food', 'general_contractor', 'geocode', 'health', 'intersection', 'locality', 'natural_feature', 'neighborhood', 'place_of_worship', 'political', 'point_of_interest', 'post_box', 'postal_code', 'postal_code_prefix', 'postal_code_suffix', 'postal_town', 'premise', 'room', 'route', 'street_address', 'street_number', 'sublocality', 'sublocality_level_4', 'sublocality_level_5', 'sublocality_level_3', 'sublocality_level_2', 'sublocality_level_1', 'subpremise', 'locality', 'sublocality', 'postal_code', 'country', 'administrative_area_level_1', 'administrative_area_level_2', 'establishment', 'finance', 'food', 'general_contractor', 'grocery_or_supermarket', 'health', 'place_of_worship', 'administrative_area_level_3'];
    if (request()->tags != null) {
        $typess = request()->tags;
        $tags = explode(',', $typess);
    }
    if (request()->distance != null) {
        $meter = request()->distance;
    }

    return
        FarmPlace::where('location', 'near', [
            '$geometry' => [
                'type'        => 'Point',
                'coordinates' => [
                    floatval($lat),
                    floatval($long),
                ],
            ],
            '$maxDistance' => floatval($meter),
        ])->whereIn('types', $tags)->where('status', 1)->get(['name', 'location', 'types', 'place_id']);
});

Route::get('deletePlace', function () {
    $id = request()->id;

    return FarmPlace::where('place_id', $id)->delete();
});

Route::get('editPlace', function () {
    $id = request()->id;
    $editData = FarmPlace::where('place_id', $id)->get(['name', 'location', 'types', 'status'])->first();

    if (request()->name != null) {
        $editData->name = request()->name;
    }
    if (request()->lat != null) {
        $editData->location->coordinates[0] = request()->lat;
    }
    if (request()->long != null) {
        $editData->location->coordinates[1] = request()->lat;
    }
    if (request()->tags != null) {
        $typess = request()->tags;
        $editData->types = explode(',', $typess);
    }
    if (request()->status != null) {
        $editData->status = request()->status;
    }
    $editData->save();

    return FarmPlace::where('place_id', $id)->get()->first();
});
