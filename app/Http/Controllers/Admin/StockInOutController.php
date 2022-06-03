<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StockInOutController extends Controller
{
    public function index()
    {
        return view('admin.stock-in-out.index');
    }
}
