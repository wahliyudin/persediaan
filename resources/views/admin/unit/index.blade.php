@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Satuan</h3>
                        <button class="btn btn-sm btn-primary float-right" onclick="tambahUnit()"><i
                                class="fas fa-plus mr-2"></i>
                            Tambah
                            Data</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="unit" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
    @include('admin.unit.modal')
@endsection
@include('layouts.inc.datatables')
@include('layouts.inc.toastr')
@push('script')
    <script type="text/javascript">
        var table;
        setTimeout(function() {
            tableUnit();
        }, 500);
        var ajaxError = function(jqXHR, xhr, textStatus, errorThrow, exception) {
            if (jqXHR.status === 0) {
                toastr.error('Not connect.\n Verify Network.', 'Error!');
            } else if (jqXHR.status == 400) {
                toastr.warning(jqXHR['responseJSON'].message, 'Peringatan!');
            } else if (jqXHR.status == 404) {
                toastr.error('Requested page not found. [404]', 'Error!');
            } else if (jqXHR.status == 500) {
                toastr.error('Internal Server Error [500].' + jqXHR['responseJSON'].message, 'Error!');
            } else if (exception === 'parsererror') {
                toastr.error('Requested JSON parse failed.', 'Error!');
            } else if (exception === 'timeout') {
                toastr.error('Time out error.', 'Error!');
            } else if (exception === 'abort') {
                toastr.error('Ajax request aborted.', 'Error!');
            } else {
                toastr.error('Uncaught Error.\n' + jqXHR.responseText, 'Error!');
            }
        };

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // function to retrieve DataTable server side
        function tableUnit() {
            $('#unit').dataTable().fnDestroy();
            table = $('#unit').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('api.units.index') }}",
                    type: "post",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ],
                pageLength: 10,
                lengthMenu: [
                    [10, 20, 50, -1],
                    [10, 20, 50, 'All']
                ]
            });
        }


        // Add Data
        function tambahUnit() {
            $('#modal-store').modal('show');
            $('#name').val('');
            $('#btn-store-unit').prop('disabled', false);
        }

        function storeUnit() {
            let name = $('#name').val();

            if (!name) {
                toastr.warning('Nama unit tidak boleh kosong!', 'Peringatan!');
                return false;
            }

            $('#btn-store-unit').prop('disabled', true);
            var type = 'POST';
            var url = "{{ route('api.units.store') }}";
            $.ajax({
                url: url,
                type: type,
                data: $('#form-unit').serialize(),
                success: function(data) {
                    $('#modal-store').modal('hide');
                    toastr.success(data.message, 'Berhasil!');
                    table.ajax.reload();
                },
                error: ajaxError,
                complete: function() {
                    $('#btn-store-unit').prop('disabled', false);
                },
            });
        }

        // Edit Data
        $('body').on('click', '.edit', function(e) {
            e.preventDefault();
            editUnit($(this).attr('id'))
        });

        function editUnit(id) {
            $.ajax({
                url: "{{ env('APP_URL') }}/api/units/" + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(resp) {
                    $('#modal-update').modal('show');
                    $('#unit_id').val(resp.data.id);
                    $('#name_update').val(resp.data.name);
                    $('#btn-update-unit').prop('disabled', false);
                },
                error: ajaxError,
            });
        }

        function updateUnit() {
            let name = $('#name_update').val();
            if (!name) {
                toastr.warning('Nama unit tidak boleh kosong!', 'Peringatan!');
                return false;
            }

            let id = $('#unit_id').val();
            $('#btn-update-unit').prop('disabled', true);
            $.ajax({
                url: "{{ env('APP_URL') }}/api/units/" + id + "/update",
                type: 'PUT',
                data: $('#form-update-unit').serialize(),
                success: function(resp) {
                    $('#modal-update').modal('hide');
                    toastr.success(resp.message, 'Berhasil!');
                    table.ajax.reload();
                },
                error: ajaxError,
                complete: function() {
                    $('#btn-update-unit').prop('disabled', false);
                },
            });

        }

        // delete
        $('body').on('click', '.delete', function(e) {
            e.preventDefault();
            deleteUnit($(this).attr('id'))
        });

        function deleteUnit(id) {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Unit akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus Sekarang!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ env('APP_URL') }}/api/units/" + id + "/destroy",
                        type: 'DELETE',
                        success: function(resp) {
                            toastr.success(resp.message, 'Berhasil!');
                            table.ajax.reload();
                        },
                        error: ajaxError,
                    });
                }
            })
        }
    </script>
@endpush
