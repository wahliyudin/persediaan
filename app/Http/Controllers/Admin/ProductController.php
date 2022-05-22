<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.product.index', [
            'breadcrumbs' => [
                'title' => 'Barang',
                'path' => [
                    'Master Data' => route('admin.barang.index'),
                    'Barang' => 0
                ]
            ],
            'products' => Product::with('unit', 'type')->latest()->get()
        ]);
    }

    public function create()
    {
        return view();
    }
}
