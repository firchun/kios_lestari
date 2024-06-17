<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Pengaturan website',
            'setting' => Setting::getSetting(),
        ];
        return view('admin.setting.index', $data);
    }
    public function update(Request $request)
    {
        $setting = Setting::find(1);

        if ($setting) {
            $setting->no_hp = $request->input('no_hp');
            $setting->alamat = $request->input('alamat');
            $setting->keterangan_kios = $request->input('keterangan_kios');
            $setting->google_maps = $request->input('google_maps');
            $setting->save();
        }
        return back();
    }
}
