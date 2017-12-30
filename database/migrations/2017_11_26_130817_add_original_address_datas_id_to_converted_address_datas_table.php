<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOriginalAddressDatasIdToConvertedAddressDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('converted_address_datas', function (Blueprint $table) {
            $table->unsignedInteger('original_address_datas_id')->unique()->index('FK_converted_address_datas_original_address_datas_id');
            $table->foreign('original_address_datas_id', 'FK_converted_address_datas_original_address_datas_id')->references('id')->on('original_address_datas')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('converted_address_datas', function (Blueprint $table) {
            $table->dropForeign('FK_converted_address_datas_original_address_datas_id');
            $table->dropColumn('original_address_datas_id');
        });
    }
}
