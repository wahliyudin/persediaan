<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class IncomingProductController extends Controller
{
    public function index()
    {
        return view('admin.incoming-product.index', [
            'breadcrumbs' => [
                'title' => 'Barang Masuk',
                'path' => [
                    'Master Data' => route('admin.gudang.index'),
                    'Barang Masuk' => 0
                ]
            ],
            'incoming_products' => Transaction::with('product', 'product.unit', 'product.warehouse')->where(
                'status',
                Transaction::STATUS_IN
            )->latest()->get()
        ]);
    }

    public function create()
    {
        return view('admin.incoming-product.create', [
            'breadcrumbs' => [
                'title' => 'Tambah Barang Masuk',
                'path' => [
                    'Barang Masuk' => route('admin.incoming-product.index'),
                    'Tambah Barang Masuk' => 0
                ]
            ],
            'products' => Product::latest()->get(),
            'invoice' => generateInvoiceIn()
        ]);
    }

    public function store(Request $request)
    {
        try {
            $product_id = Crypt::decrypt($request->product_id);
        } catch (DecryptException $e) {
        }
        try {
            Transaction::create([
                'product_id' => $product_id,
                'invoice' => $request->invoice,
                'tanggal' => Carbon::make($request->tanggal)->format('Y-m-d'),
                'jumlah' => $request->stok_masuk,
                'status' => Transaction::STATUS_IN
            ]);
            Product::find($product_id)->update(['stock' => $request->total_stok]);

            return redirect()->route('admin.incoming-product.index')->with('success', 'Data berhasil ditambahkan');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
        }

        return view('admin.incoming-product.edit', [
            'products' => Product::latest()->get(),
            'incoming_product' => Transaction::with('product', 'product.unit', 'product.warehouse')->find($id)
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
        }

        try {
            $transaction = Transaction::find($id);
            $transaction->update([
                'tanggal' => Carbon::make($request->tanggal)->format('Y-m-d'),
                'jumlah' => $request->stok_masuk
            ]);
            Product::find($transaction->product_id)->update(['stock' => $request->total_stok]);

            return redirect()->route('admin.incoming-product.index')->with('success', 'Data berhasil diubah');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
