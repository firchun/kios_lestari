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
        Schema::create('pengantaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pesanan');
            $table->string('nama_pengantar');
            $table->text('keterangan')->nullable();
            $table->boolean('sampai')->default(0);
            $table->string('foto_bukti')->nullable();
            $table->timestamps();

            $table->foreign('id_pesanan')->references('id')->on('pesanan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengantaran');
    }
};
