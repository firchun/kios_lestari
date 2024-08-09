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
        Schema::create('point_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pesanan');
            $table->foreignId('id_user');
            $table->string('jumlah');
            $table->timestamps();

            $table->foreign('id_pesanan')->references('id')->on('pesanan');
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('point_user');
    }
};
