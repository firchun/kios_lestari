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
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user');
            $table->foreignId('id_produk');
            $table->string('no_invoice');
            $table->integer('jumlah')->default(1);
            $table->boolean('diantar')->default(0);
            $table->enum('jenis', ['order', 'pre-order'])->default('order');
            $table->string('nama_penerima')->nullable();
            $table->string('nomor_penerima')->nullable();
            $table->string('alamat_pengantaran')->nullable();
            $table->enum('status', ['pesanan ditolak', 'pesanan diproses', 'pesanan dalam pengantaran', 'pesanan telah selesai', 'pesanan sampai di lokasi tujuan', 'menunggu barang tersedia'])->default('pesanan diproses');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_produk')->references('id')->on('produk');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pesanan');
    }
};
