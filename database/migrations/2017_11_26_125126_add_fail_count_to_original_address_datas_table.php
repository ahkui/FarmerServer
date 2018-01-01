<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFailCountToOriginalAddressDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (env('DB_CONNECTION') != 'mongodb') 
        Schema::table('original_address_datas', function (Blueprint $table) {
            $table->integer('fail_count')->default(0);
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
        Schema::table('original_address_datas', function (Blueprint $table) {
            $table->dropColumn('fail_count');
        });
    }
}
