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
    $meter = 5;
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
        ])->whereIn('types', $tags)->get(['name', 'location', 'types']);
});


    
Route::get('filter/tags','GeometryController@tags');
Route::post('filter/tags','GeometryController@tags');