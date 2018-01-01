<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsQueueToOriginalAddressDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (env('DB_CONNECTION') != 'mongodb') {
            Schema::table('original_address_datas', function (Blueprint $table) {
                $table->boolean('is_queue')->default(false);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (env('DB_CONNECTION') != 'mongodb') {
            Schema::table('original_address_datas', function (Blueprint $table) {
                $table->dropColumn('is_queue');
            });
        }
    }
}
