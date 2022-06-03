<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\Type;
use App\Models\Unit;
use App\Models\Warehouse;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.product.index', [
            'breadcrumbs' => [
                'title' => 'Barang',
                'path' => [
                    'Master Data' => route('admin.products.index'),
                    'Barang' => 0
                ]
            ],
            'products' => Product::with('unit', 'type')->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product.create', [
            'breadcrumbs' => [
                'title' => 'Tambah Barang',
                'path' => [
                    'Master Data' => route('admin.products.index'),
                    'Data Barang' => route('admin.products.index'),
                    'Tambah Barang' => 0
                ]
            ],
            'units' => Unit::latest()->get(['id', 'name']),
            'types' => Type::latest()->get(['id', 'name']),
            'warehouses' => Warehouse::latest()->get(['id', 'name'])
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'price' => 'required',
                "unit_id" => "required",
                "type_id" => "required",
                "warehouse_id" => "required"
            ]);
            $data = $request->all();
            $data['price'] = replaceRupiah($data['price']);

            Product::create($data);

            return redirect()->route('admin.products.index')->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return back()->with('error', $e->getMessage());
        }

        return view('admin.product.edit', [
            'breadcrumbs' => [
                'title' => 'Edit Barang',
                'path' => [
                    'Master Data' => route('admin.products.index'),
                    'Data Barang' => route('admin.products.index'),
                    'Edit Barang' => 0
                ]
            ],
            'product' => Product::with('unit', 'type', 'warehouse')->find($id),
            'units' => Unit::latest()->get(['id', 'name']),
            'types' => Type::latest()->get(['id', 'name']),
            'warehouses' => Warehouse::latest()->get(['id', 'name'])
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return back()->with('error', $e->getMessage());
        }
        try {
            $data = $request->all();
            if (isset($data['price'])) {
                $data['price'] = replaceRupiah($data['price']);
            }

            Product::find($id)->update($data);

            return redirect()->route('admin.products.index')->with('success', 'Data berhasil diubah');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}
