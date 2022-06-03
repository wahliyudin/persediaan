<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ProductOutController extends Controller
{
    public function index()
    {
        return view('admin.product-out.index', [
            'breadcrumbs' => [
                'title' => 'Barang Keluar',
                'path' => [
                    'Barang Keluar' => 0
                ]
            ],
            'product_outs' => Transaction::with('product', 'product.unit', 'product.warehouse')->where(
                'status',
                Transaction::STATUS_OUT
            )->latest()->get()
        ]);
    }

}
