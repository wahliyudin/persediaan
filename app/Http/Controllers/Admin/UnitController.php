<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Unit;

class UnitController extends Controller
{
    public function index()
    {
        return view('admin.unit.index', [
            'breadcrumbs' => [
                'title' => 'Satuan',
                'path' => [
                    'Master Data' => route('admin.satuan.index'),
                    'Satuan' => 0
                ]
            ],
            'units' => Unit::latest()->get()
        ]);
    }

    public function destroy(Unit $unit)
    {
        try {
            $unit->delete();
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
        return back()->with('success', 'Data berhasil dihapus');
    }
}
