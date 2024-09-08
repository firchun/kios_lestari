<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('point_user', function (Blueprint $table) {
            $table->dropColumn('jumlah');
            $table->dropForeign(['id_pesanan']);
            $table->dropColumn('id_pesanan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('point_user', function (Blueprint $table) {
            //
        });
    }
};
