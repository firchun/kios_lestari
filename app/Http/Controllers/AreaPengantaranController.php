<?php

namespace App\Http\Controllers;

use App\Models\AreaPengantaran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AreaPengantaranController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Data area dan harga pengantaran'
        ];
        return view('admin.area.index', $data);
    }
    public function getAreaDataTable()
    {
        $area = AreaPengantaran::orderByDesc('id');

        return DataTables::of($area)
            ->addColumn('action', function ($area) {
                return view('admin.area.components.actions', compact('area'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|string|max:20',
        ]);

        $customerData = [
            'nama' => $request->input('nama'),
            'harga' => $request->input('harga'),
        ];

        if ($request->filled('id')) {
            $customer = AreaPengantaran::find($request->input('id'));
            if (!$customer) {
                return response()->json(['message' => 'area not found'], 404);
            }

            $customer->update($customerData);
            $message = 'data updated successfully';
        } else {
            AreaPengantaran::create($customerData);
            $message = 'data created successfully';
        }

        return response()->json(['message' => $message]);
    }
    public function destroy($id)
    {
        $customers = AreaPengantaran::find($id);

        if (!$customers) {
            return response()->json(['message' => 'data not found'], 404);
        }

        $customers->delete();

        return response()->json(['message' => 'data deleted successfully']);
    }
    public function edit($id)
    {
        $customer = AreaPengantaran::find($id);

        if (!$customer) {
            return response()->json(['message' => 'data not found'], 404);
        }

        return response()->json($customer);
    }
}
