<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::with('unit', 'type', 'warehouse')->oldest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="d-flex align-item-center"> <a
                            href="' . route('admin.products.edit', Crypt::encrypt($row->id)) . '"
                        class="btn btn-success btn-sm mr-2">Ubah</a> <a href="javascript:(0);"
                        id="' . Crypt::encrypt($row->id) . '" class="delete btn btn-danger btn-sm">Hapus</a> </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function destroy($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $product = Product::find($id);

            if (!$product) {
                throw new Exception('Data barang tidak ditemukan!', 400);
            }

            $product->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Menghapus data barang',
            ]);
        } catch (\Exception $th) {
            $th->getCode() == 400 ?? $code = 500;
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], $code);
        }
    }

    public function getProduct($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $product = Product::with('unit', 'warehouse')->find($id);

            if (!$product) {
                throw new Exception('Data barang tidak ditemukan!', 400);
            }

            return response()->json([
                'status' => 'success',
                'data' => $product,
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
