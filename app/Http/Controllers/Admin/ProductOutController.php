<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ProductOutController extends Controller
{
    public function index()
    {
        return view('admin.product-out.index', [
            'breadcrumbs' => [
                'title' => 'Barang Keluar',
                'path' => [
                    'Master Data' => route('admin.product-out.index'),
                    'Barang Keluar' => 0
                ]
            ],
            'product_outs' => Transaction::with('product', 'product.unit', 'product.warehouse')->where(
                'status',
                Transaction::STATUS_OUT
            )->latest()->get()
        ]);
    }

    public function create()
    {
        return view('admin.product-out.create', [
            'breadcrumbs' => [
                'title' => 'Tambah Barang Keluar',
                'path' => [
                    'Barang Keluar' => route('admin.product-out.index'),
                    'Tambah Barang Keluar' => 0
                ]
            ],
            'products' => Product::latest()->get(),
            'invoice' => generateInvoiceOut()
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
                'jumlah' => $request->stok_keluar,
                'status' => Transaction::STATUS_OUT
            ]);
            Product::find($product_id)->update(['stock' => $request->total_stok]);

            return redirect()->route('admin.product-out.index')->with('success', 'Data berhasil ditambahkan');
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

        return view('admin.product-out.edit', [
            'breadcrumbs' => [
                'title' => 'Edit Barang Keluar',
                'path' => [
                    'Barang Keluar' => route('admin.product-out.index'),
                    'Edit Barang Keluar' => 0
                ]
            ],
            'products' => Product::latest()->get(),
            'product_out' => Transaction::with('product', 'product.unit', 'product.warehouse')->find($id)
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
                'jumlah' => $request->stok_keluar
            ]);
            Product::find($transaction->product_id)->update(['stock' => $request->total_stok]);

            return redirect()->route('admin.product-out.index')->with('success', 'Data berhasil diubah');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
