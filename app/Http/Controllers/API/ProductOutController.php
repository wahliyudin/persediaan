<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ProductOutController extends Controller
{
    public function destroy($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
        }
        try {

            $product_out = Transaction::find($id);

            if (!$product_out) {
                throw new Exception('Data barang keluar tidak ditemukan!', 400);
            }
            $product = Product::find($product_out->product_id);
            $product->update(['stock' => $product->stock + $product_out->jumlah]);
            $product_out->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Menghapus data barang keluar',
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
