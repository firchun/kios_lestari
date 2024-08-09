<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Produk;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->role == 'User') {
            return redirect()->to('/');
        }
        $data = [
            'title' => 'Dashboard',
            'users' => User::count(),
            'Produk' => Produk::count()
        ];
        return view('admin.dashboard', $data);
    }
    public function chat()
    {
        $data = [
            'title' => 'Chat',
            'setting' => Setting::getSetting(),
        ];
        return view('pages.chat', $data);
    }
}
