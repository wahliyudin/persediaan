<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Warehouse::oldest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm"
        id="' . Crypt::encrypt($row->id) . '">Ubah</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm"
        id="' . Crypt::encrypt($row->id) . '">Hapus</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        try {
            Warehouse::create([
                'name' => $request->name
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Menambahkan data gudang',
            ]);
        } catch (\Exception $th) {
            $th->getCode() == 400 ?? $code = 500;
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], $code);
        }
    }

    public function edit($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $warehouse = Warehouse::find($id);
            if (!$warehouse) {
                throw new Exception('Data gudang tidak ditemukan!', 400);
            }
            $data = [
                'id' => Crypt::encrypt($warehouse->id),
                'name' => $warehouse->name
            ];
            return response()->json([
                'status' => 'success',
                'data' => $data,
            ]);
        } catch (\Exception $th) {
            $th->getCode() == 400 ?? $code = 500;
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], $code);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $id = Crypt::decrypt($id);
            $warehouse = Warehouse::find($id);
            if (!$warehouse) {
                throw new Exception('Data gudang tidak ditemukan!', 400);
            }
            $warehouse->update([
                'name' => $request->name_update,
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Memperbarui data gudang',
            ]);
        } catch (\Exception $th) {
            $th->getCode() == 400 ?? $code = 500;
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], $code);
        }
    }

    public function destroy($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $warehouse = Warehouse::find($id);

            if (!$warehouse) {
                throw new Exception('Data gudang tidak ditemukan!', 400);
            }

            $warehouse->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Menghapus data gudang',
            ]);
        } catch (\Exception $th) {
            $th->getCode() == 400 ?? $code = 500;
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], $code);
        }
    }
}
