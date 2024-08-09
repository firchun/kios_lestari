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
        Schema::create('pengajuan_return', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pesanan');
            $table->string('jumlah');
            $table->string('keterangan');
            $table->string('foto');
            $table->boolean('disetujui')->default(0);
            $table->boolean('selesai')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengajuan_return');
    }
};