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
            ],
            'types' => Type::latest()->get()
        ]);
    }

    public function destroy(Type $type)
    {
        try {
            $type->delete();
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
        return back()->with('success', 'Data berhasil dihapus');
    }
}
