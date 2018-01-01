<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoogleMapsApisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (env('DB_CONNECTION') != 'mongodb') 
        Schema::create('google_maps_apis', function (Blueprint $table) {
            $table->increments('id');
            $table->string('apikey');
            $table->integer('used_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (env('DB_CONNECTION') != 'mongodb') 
        Schema::dropIfExists('google_maps_apis');
    }
}
