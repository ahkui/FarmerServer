<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeConvertedAddressDatasAddressColumnToText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (env('DB_CONNECTION') != 'mongodb') 
        Schema::table('converted_address_datas', function (Blueprint $table) {
            $table->text('address')->change();
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
        Schema::table('converted_address_datas', function (Blueprint $table) {
            $table->string('address')->change();
        });
    }
}
