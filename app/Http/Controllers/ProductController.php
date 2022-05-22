<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.product.index', [
            'breadcrumbs' => [
                'title' => 'Dashboard',
                'path' => [
                    'Dashboard' => 0
                ]
                ],
                'products' => Product::with('unit', 'type')->latest()->get()
        ]);
    }
}
