<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use HasFactory;
    protected $table = 'rating';
    protected $guarded = [];

    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
    static function getRatingProduk($id_produk)
    {
        $jumlah_ulasan = Self::where('id_produk', $id_produk)->count();
        $jumlah_rating = Self::where('id_produk', $id_produk)->sum('rating');
        if ($jumlah_ulasan > 0) {
            $rating_rata_rata = $jumlah_rating / $jumlah_ulasan;
        } else {
            $rating_rata_rata = 0;
        }
        return round($rating_rata_rata, 1);
    }
    static function getCountRatingProduk($id_produk)
    {
        $jumlah_ulasan = Self::where('id_produk', $id_produk)->count();

        return $jumlah_ulasan;
    }
}
