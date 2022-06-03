@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('admin.incoming-product.create') }}"
                            class="btn btn-sm btn-primary float-right"><i class="fas fa-plus mr-2"></i> Tambah Barang
                            Masuk</a>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="incoming-product" class="table table-bordered table-striped">
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
                                @foreach ($incoming_products as $incoming_product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $incoming_product->invoice }}</td>
                                        <td>{{ $incoming_product->tanggal }}</td>
                                        <td>{{ $incoming_product->product->name }}</td>
                                        <td>{{ $incoming_product->product->unit->name }}</td>
                                        <td>{{ $incoming_product->product->warehouse->name }}</td>
                                        <td>{{ $incoming_product->jumlah }}</td>
                                        <td>
                                            <div class="d-flex align-item-center">
                                                <a href="{{ route('admin.incoming-product.edit', Crypt::encrypt($incoming_product->id)) }}"
                                                    class="btn btn-sm btn-success mr-2">Ubah</a>
                                                <a href="" class="btn btn-sm btn-danger mr-2">Hapus</a>
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
            $("#incoming-product").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
            }).buttons().container().appendTo('#incoming-product_wrapper .col-md-6:eq(0)');
        });
    </script>
@endpush
