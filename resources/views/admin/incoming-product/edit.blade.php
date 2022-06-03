@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <form action="{{ route('admin.incoming-product.update', Crypt::encrypt($incoming_product->id)) }}"
                        method="post">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="invoice">Invoice</label>
                                    <input type="text" name="invoice" class="form-control" readonly
                                        value="{{ old('invoice', $incoming_product->invoice) }}" id="invoice">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Tanggal</label>
                                    <div class="input-group date" id="tanggal" data-target-input="nearest">
                                        <input type="text" required name="tanggal"
                                            class="form-control datetimepicker-input {{ $errors->has('tanggal') ? ' is-invalid' : '' }}"
                                            data-target="#tanggal"
                                            value="{{ \Carbon\Carbon::make($incoming_product->tanggal)->format('d/m/Y') }}">
                                        <div class="input-group-append" data-target="#tanggal" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                    @error('tanggal')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Barang</label>
                                    <select name="product_id" disabled class="product_id form-control select2"
                                        style="width: 100%;">
                                        <option selected="selected" disabled>-- pilih --</option>
                                        @foreach ($products as $product)
                                            <option {{ $incoming_product->product->id == $product->id ? 'selected' : '' }}
                                                value="{{ Crypt::encrypt($product->id) }}">{{ $product->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="nama_barang">Nama Barang</label>
                                    <input type="text" class="form-control" readonly
                                        value="{{ old('nama_barang', $incoming_product->product->name) }}"
                                        id="nama_barang">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="satuan">Satuan</label>
                                    <input type="text" class="form-control" readonly
                                        value="{{ old('satuan', $incoming_product->product->unit->name) }}" id="satuan">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="gudang">Gudang</label>
                                    <input type="text" class="form-control" readonly
                                        value="{{ old('gudang', $incoming_product->product->warehouse->name) }}"
                                        id="gudang">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="stok_barang">Stok Barang</label>
                                    <input type="text" class="form-control" readonly
                                        value="{{ old('stok_barang', $incoming_product->product->stock - $incoming_product->jumlah) }}"
                                        id="stok_barang">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="stok_masuk">Stok Masuk</label>
                                    <input type="text" class="form-control" name="stok_masuk"
                                        value="{{ old('stok_masuk', $incoming_product->jumlah) }}" id="stok_masuk">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="total_stok">Total Stok</label>
                                    <input type="text" class="form-control" name="total_stok" readonly
                                        value="{{ old('total_stok', $incoming_product->product->stock - $incoming_product->jumlah + $incoming_product->jumlah) }}"
                                        id="total_stok">
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary float-right">Submit</button>
                        </div>
                    </form>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
@endsection
@include('layouts.inc.toastr')
@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <style>
        .select2-container .select2-selection--single {
            height: 38px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100% !important;
        }

    </style>
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endpush
@push('script')
    <!-- bs-custom-file-input -->
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script>
        $(function() {
            bsCustomFileInput.init();
            //Initialize Select2 Elements
            $('.select2').select2()
        });

        $('#tanggal').datetimepicker({
            format: 'L'
        });
        $('[data-mask]').inputmask()

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka satuan ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        $('.product_id').change(function(e) {
            e.preventDefault();
            const id = e.target.value;
            if (id) {
                $.ajax({
                    url: '{{ env('APP_URL') }}/api/products/' + id,
                    type: 'GET',
                    success: function(response) {
                        console.log(response.data);
                        $('#nama_barang').val(response.data.name);
                        $('#satuan').val(response.data.unit.name);
                        $('#gudang').val(response.data.warehouse.name);
                        $('#stok_barang').val(response.data.stock);
                    }
                });
            }
        });

        $('#stok_masuk').keyup(function(e) {
            if (e.target.value) {
                $('#total_stok').val(parseInt($('#stok_barang').val()) + parseInt(e.target.value));
            } else {
                $('#total_stok').val(0);
            }
        });
    </script>
@endpush
