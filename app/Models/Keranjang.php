<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang';
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    static function getCountKeranjang($id_user)
    {
        return Self::where('id_user', $id_user)->count();
    }
}
