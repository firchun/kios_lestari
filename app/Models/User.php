<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    static function userPoint($id)
    {
        $jumlah = Pesanan::where('id_user', $id)->count();
        $reward = Setting::first()->point;
        $terpakai =  point::where('id_user', $id)->sum('jumlah');
        $point = number_format(($jumlah * $reward) - $terpakai);
        return $point;
    }
    static function userSaldo($id)
    {
        $point = self::userPoint($id);
        $saldo = Setting::first()->saldo_point;
        return 'Rp ' . number_format($point * $saldo);
    }
}
