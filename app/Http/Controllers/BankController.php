<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BankController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data Rekening Bank',
        ];
        return view('admin.bank.index', $data);
    }
    public function getBankDataTable()
    {
        $Bank = Bank::orderByDesc('id');

        return DataTables::of($Bank)
            ->addColumn('action', function ($Bank) {
                return view('admin.bank.components.actions', compact('Bank'));
            })

            ->rawColumns(['action'])
            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_bank' => 'required|string|max:255',
            'nama_pemilik' => 'required|string|max:20',
            'no_rekening' => 'required|string',
        ]);

        $BankData = [
            'nama_bank' => $request->input('nama_bank'),
            'nama_pemilik' => $request->input('nama_pemilik'),
            'no_rekening' => $request->input('no_rekening'),
        ];

        if ($request->filled('id')) {
            $Bank = Bank::find($request->input('id'));
            if (!$Bank) {
                return response()->json(['message' => 'Bank not found'], 404);
            }

            $Bank->update($BankData);
            $message = 'Bank updated successfully';
        } else {
            Bank::create($BankData);
            $message = 'Bank created successfully';
        }

        return response()->json(['message' => $message]);
    }
    public function destroy($id)
    {
        $Bank = Bank::find($id);

        if (!$Bank) {
            return response()->json(['message' => 'Bank not found'], 404);
        }

        $Bank->delete();

        return response()->json(['message' => 'Bank deleted successfully']);
    }
    public function edit($id)
    {
        $Bank = Bank::find($id);

        if (!$Bank) {
            return response()->json(['message' => 'Bank not found'], 404);
        }

        return response()->json($Bank);
    }
}
