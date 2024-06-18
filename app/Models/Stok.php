<?php

namespace App\Models;

use GuzzleHttp\RetryMiddleware;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stok extends Model
{
    use HasFactory;

    protected $table = 'stok';
    protected $guarded = [];

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
    public static function getStok($id_produk)
    {
        $stokMasuk = Self::where('id_produk', $id_produk)->where('jenis', 'masuk')->sum('jumlah');
        $stokKeluar = Self::where('id_produk', $id_produk)->where('jenis', ['penjualan', 'rusak'])->sum('jumlah');

        return $stokMasuk - $stokKeluar;
    }
}
