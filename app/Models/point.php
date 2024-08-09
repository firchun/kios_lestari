<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class point extends Model
{
    use HasFactory;
    protected $table = 'point_user';
    protected $guarded = [];
    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
