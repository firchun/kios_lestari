<?php

namespace App\Http\Controllers;

use App\Models\Pengantaran;
use Illuminate\Http\Request;

class PengantaranController extends Controller
{
    public function store(Request $request)
    {

        $pengantaranData = [
            'id_pesanan' => $request->input('id_pesanan'),
            'nama_pengantar' => $request->input('nama_pengantar'),
            'keterangan' => $request->input('keterangan'),
        ];

        if ($request->filled('id_pengantaran')) {
            $Pengantaran = Pengantaran::find($request->input('id_pengantaran'));
            if (!$Pengantaran) {
                return response()->json(['message' => 'Pengantaran not found'], 404);
            }
            $pengantaranUpdate = [
                'sampai' => $request->input('sampai'),
            ];

            $Pengantaran->update($pengantaranUpdate);
            $message = 'Pengantaran updated successfully';
        } else {
            Pengantaran::create($pengantaranData);
            $message = 'Pengantaran created successfully';
        }

        return response()->json(['message' => $message]);
    }
    public function pesanan($id)
    {
        $Pengantaran = Pengantaran::where('id_pesanan', $id)->first();

        // if (!$Pengantaran) {
        //     return response()->json(['message' => 'Pengantaran not found'], 404);
        // }

        return response()->json($Pengantaran);
    }
}
