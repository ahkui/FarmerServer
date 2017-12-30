<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeOriginalAddressDatasAddressColumnToText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('original_address_datas', function (Blueprint $table) {
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
        Schema::table('original_address_datas', function (Blueprint $table) {
            $table->string('address')->change();
        });
    }
}
