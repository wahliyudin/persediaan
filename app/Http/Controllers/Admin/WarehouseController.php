<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.warehouse.index', [
            'breadcrumbs' => [
                'title' => 'Data Gudang',
                'path' => [
                    'Master Data' => route('admin.gudang.index'),
                    'Data Gudang' => 0
                ]
            ]
        ]);
    }

}
