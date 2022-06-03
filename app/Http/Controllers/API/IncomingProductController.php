<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class IncomingProductController extends Controller
{
    public function destroy($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {

        }
        try {

            $incoming_product = Transaction::find($id);

            if (!$incoming_product) {
                throw new Exception('Data barang masuk tidak ditemukan!', 400);
            }
            $product = Product::find($incoming_product->product_id);
            $product->update(['stock' => $product->stock - $incoming_product->jumlah]);
            $incoming_product->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Menghapus data barang masuk',
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
