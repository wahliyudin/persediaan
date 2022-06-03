<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'breadcrumbs' => [
                'title' => 'Dashboard',
                'path' => [
                    'Dashboard' => 0
                ]
            ],
            'total_barang_masuk' => Transaction::where('status', Transaction::STATUS_IN)->sum('jumlah'),
            'total_barang_keluar' => Transaction::where('status', Transaction::STATUS_OUT)->sum('jumlah'),
            'total_barang_semua_gudang' => Product::count(),
            'products' => Product::with('unit', 'type', 'warehouse')->where('stock', '<', 20)->get(),
            'warehouses' => Warehouse::withCount('products')->get()
        ]);
    }
}
