@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $total_barang_masuk }}</h3>

                        <p>Barang Masuk</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-sign-in-alt"></i>
                    </div>
                    <a href="{{ route('admin.incoming-product.index') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $total_barang_keluar }}</h3>

                        <p>Barang Keluar</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                    <a href="{{ route('admin.product-out.index') }}" class="small-box-footer">More info <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3 style="color: white;">{{ $total_barang_semua_gudang }}</h3>

                        <p style="color: white;">Total Barang Semua Gudang</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <a href="{{ route('admin.products.index') }}" class="small-box-footer"
                        style="color: white !important;">Detail <i class="fas fa-arrow-circle-right"
                            style="color: white;"></i></a>
                </div>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        <table id="product" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jenis</th>
                                    <th>Satuan</th>
                                    <th>Gudang</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->type->name }}</td>
                                        <td>{{ $product->unit->name }}</td>
                                        <td>{{ $product->warehouse->name }}</td>
                                        <td>{{ $product->stock }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                @foreach ($warehouses as $warehouse)
                    <div class="col-lg-12">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3 style="color: white;">{{ $warehouse->products_count }}</h3>

                                <p style="color: white;">Total Barang {{ $warehouse->name }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-boxes"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div><!-- /.container-fluid -->
@endsection
@include('layouts.inc.datatables')
@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
@endpush
@push('script')
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script>
        $(function() {
            $("#product").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            }).buttons().container().appendTo('#product_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush
