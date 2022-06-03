<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Type;

class TypeController extends Controller
{
    public function index()
    {
        return view('admin.type.index', [
            'breadcrumbs' => [
                'title' => 'Jenis Barang',
                'path' => [
                    'Master Data' => route('admin.jenis.index'),
                    'Jenis Barang' => 0
                ]
            ]
        ]);
    }

}
