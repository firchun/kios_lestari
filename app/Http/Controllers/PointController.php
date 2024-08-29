<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\point;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PointController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data point pelanggan'
        ];
        return view('admin.point.index', $data);
    }
    public function getPointDataTable()
    {
        $users = User::where('role', 'User')->orderByDesc('id');

        return DataTables::of($users)

            ->addColumn('action', function ($user) {
                return '<button type="button" onclick="change(' . $user->id . ')" class="btn btn-warning">Gunakan</button>';
            })
            ->addColumn('point', function ($user) {
                $jumlah = Pesanan::where('id_user', $user->id)->count();
                $reward = Setting::first()->point;
                return '<span class="font-weight-bold h5 text-danger">' . number_format($jumlah * $reward) . '</span> Point';
            })
            ->addColumn('saldo', function ($user) {
                $jumlah = Pesanan::where('id_user', $user->id)->count();
                $reward = Setting::first()->point;
                $saldo = Setting::first()->saldo_point;
                return '<span class="font-weight-bold h5 text-danger">Rp ' . number_format(($jumlah * $reward) * $saldo) . '</span>';
            })


            ->rawColumns(['action', 'point', 'saldo'])
            ->make(true);
    }
}
