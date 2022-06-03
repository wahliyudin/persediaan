@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('admin.product-out.create') }}" class="btn btn-sm btn-primary float-right"><i
                                class="fas fa-plus mr-2"></i> Tambah Barang
                            Keluar</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="product-out" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Invoice</th>
                                    <th>Tanggal</th>
                                    <th>Nama Barang</th>
                                    <th>Satuan</th>
                                    <th>Gudang</th>
                                    <th>Jumlah</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($product_outs as $product_out)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $product_out->invoice }}</td>
                                        <td>{{ $product_out->tanggal }}</td>
                                        <td>{{ $product_out->product->name }}</td>
                                        <td>{{ $product_out->product->unit->name }}</td>
                                        <td>{{ $product_out->product->warehouse->name }}</td>
                                        <td>{{ $product_out->jumlah }}</td>
                                        <td>
                                            <div class="d-flex align-item-center">
                                                <a href="" class="btn btn-sm btn-primary mr-2"><i
                                                        class="fas fa-eye mr-1"></i>
                                                    Detail</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
@endsection
@include('layouts.inc.toastr')
@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush
@push('script')
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script>
        $(function() {
            $("#product-out").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            }).buttons().container().appendTo('#product-out_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush
