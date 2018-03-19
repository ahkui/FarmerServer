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

Route::get('path', function () {
    $lat = request()->lat;
    $long = request()->long;
    $meter = 100;
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
        $editData->location->coordinates[1] = request()->long;
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

Route::get('filter/tags', 'GeometryController@tags');
Route::post('filter/tags', 'GeometryController@tags');
