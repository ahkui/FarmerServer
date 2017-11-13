<?php

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

Route::post('deploy', function()
{
    ini_set('max_execution_time', 300);
    $cmd = 'cd /var/www;/usr/bin/git fetch origin 2>&1;/usr/bin/git reset --hard origin/master 2>&1;chmod -R 777 /var/www/storage;composer dump-autoload;php artisan clear-compiled;php artisan view:clear;php artisan config:clear;php artisan optimize;php artisan queue:restart';
    exec($cmd, $output, $return);
    if ($return !== 0) return response($output,500);
    $exitCode = Artisan::call('migrate');
    return ['gitdeploy'=>$output,'migrate'=>$exitCode];
});
