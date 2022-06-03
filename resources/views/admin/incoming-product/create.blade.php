@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-default">
                    <div class="card-body">
                        <form action="{{ route('panitia.payment') }}" method="post" class="align-items-end">
                            @csrf
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Akun Kas</label>
                                        <select name="account_id" required class="form-control select2" style="width: 100%;">
                                            <option selected="selected" disabled>-- pilih --</option>
                                            @foreach ($accounts as $account)
                                                <option value="{{ $account->id }}">{{ $account->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Siswa</label>
                                        <select name="student_id" required class="student_id form-control select2"
                                            style="width: 100%;">
                                            <option selected="selected" disabled>-- pilih --</option>
                                            @foreach ($students as $student)
                                                <option value="{{ $student->id }}">{{ $student->identity->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Jenis Pembayaran</label>
                                        <select name="type_of_payment_id" required
                                            class="tipe-pembayaran form-control select2" style="width: 100%;">
                                            <option selected="selected" disabled>-- pilih --</option>
                                            @foreach ($type_of_payments as $type_of_payment)
                                                <option value="{{ $type_of_payment->id }}">{{ $type_of_payment->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row col-md-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tanggal</label>
                                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                                <input type="text" required name="tanggal"
                                                    class="form-control datetimepicker-input {{ $errors->has('tanggal') ? ' is-invalid' : '' }}"
                                                    data-target="#reservationdate" value="">
                                                <div class="input-group-append" data-target="#reservationdate"
                                                    data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                            @error('tanggal')
                                                <p class="invalid-feedback">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>No Cek</label>
                                            <input type="text" required readonly name="payment_number"
                                                value="{{ $payment_number }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Jumlah Tagihan</label>
                                    <input type="text" name="billing" readonly class="billing form-control" id="rupiah1">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Jumlah Pembayaran</label>
                                    <input type="text" required class="form-control jumlah_pembayaran" name="payment"
                                        id="rupiah2">
                                    <!-- /.input group -->
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Kembalian</label>
                                    <input type="text" name="change" value="Rp. 0" readonly class="change form-control">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Keterangan</label>
                                        <input type="text" name="description" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary float-right">Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@include('layouts.inc.tosatr')
@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <style>
        .select2-container .select2-selection--single {
            height: calc(2.25rem + 4px) !important;
        }

    </style>
@endpush
@push('script')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

        })
    </script>
    <script>
        $('#reservationdate').datetimepicker({
            format: 'L'
        });
        $('[data-mask]').inputmask()

        $('.student_id').change(function(e) {
            e.preventDefault();
            const id = e.target.value;
            const id_tipe = $('.tipe-pembayaran').val();
            getBilling(id_tipe, id);
        });

        $('.tipe-pembayaran').change(function(e) {
            e.preventDefault();
            const id_tipe = e.target.value;
            const id = $('.student_id').val();
            getBilling(id_tipe, id);
        });

        function getBilling(id_tipe, id) {
            if (id_tipe && id) {
                $.ajax({
                    url: 'http://ppdb-angel.loc/api/tipe-pembayaran/' + id_tipe + '/siswa/' + id,
                    type: 'get',
                    success: function(response) {
                        if (response.billing - response.total_payment == 0) {
                            $('.jumlah_pembayaran').attr('readonly', true);
                        } else {
                            $('.jumlah_pembayaran').attr('readonly', false);
                        }
                        $('.billing').val(formatRupiah(String(response.billing - response
                            .total_payment), 'Rp. '));
                    }
                });
            }
        }

        function escapeRegExp(string) {
            return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); // $& means the whole matched string
        }

        function replaceFormatRupiah(str) {
            return str.replace(new RegExp(escapeRegExp('.'), 'g'), '').replace('Rp ', '');
        }

        $('.jumlah_pembayaran').keyup(function(e) {
            e.preventDefault();
            var change = parseInt(replaceFormatRupiah(e.target.value)) - parseInt(replaceFormatRupiah($(
                '.billing').val()));
            var a = parseInt(replaceFormatRupiah($('.billing').val()));
            var b = parseInt(replaceFormatRupiah(e.target.value));
            var c = parseInt(replaceFormatRupiah($('.change').val()));
            if (a >= b) {
                $('.change').val('Rp. 0');
            } else {
                $('.change').val(formatRupiah(String(change), 'Rp. '));
            }
        });
    </script>
    <script type="text/javascript">
        var rupiah1 = document.getElementById('rupiah1');
        var rupiah2 = document.getElementById('rupiah2');
        rupiah1.addEventListener('keyup', function(e) {
            // tambahkan 'Rp.' pada saat ketik nominal di form kolom input
            // gunakan fungsi formatRupiah() untuk mengubah nominal angka yang di ketik menjadi format angka
            rupiah1.value = formatRupiah(this.value, 'Rp. ');
        });
        rupiah2.addEventListener('keyup', function(e) {
            // tambahkan 'Rp.' pada saat ketik nominal di form kolom input
            // gunakan fungsi formatRupiah() untuk mengubah nominal angka yang di ketik menjadi format angka
            rupiah2.value = formatRupiah(this.value, 'Rp. ');
        });
        /* Fungsi formatRupiah */
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
    </script>
@endpush
