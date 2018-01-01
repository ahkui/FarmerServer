<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConvertedAddressDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (env('DB_CONNECTION') != 'mongodb') {
            Schema::create('converted_address_datas', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->nullable();
                $table->text('levels');
                $table->text('bounds');
                $table->string('country');
                $table->string('address');
                $table->string('latitude');
                $table->string('longitude');
                $table->timestamps();
            });
        }
        else
            Schema::create('converted_address_datas', function (Blueprint $table) {
                $table->geospatial('location','2dsphere');
            });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (env('DB_CONNECTION') != 'mongodb') {
            Schema::dropIfExists('converted_address_datas');
        }
    }
}
