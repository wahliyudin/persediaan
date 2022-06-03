@extends('layouts.admin.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tipe Barang</h3>
                        <button class="btn btn-sm btn-primary float-right" onclick="tambahType()"><i
                                class="fas fa-plus mr-2"></i>
                            Tambah
                            Data</button>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="type" class="table table-bordered table-striped">
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
    @include('admin.type.modal')
@endsection
@include('layouts.inc.datatables')
@include('layouts.inc.toastr')
@push('script')
    <script type="text/javascript">
        var table;
        setTimeout(function() {
            tableType();
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
        function tableType() {
            $('#type').dataTable().fnDestroy();
            table = $('#type').DataTable({
                responsive: true,
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('api.types.index') }}",
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
        function tambahType() {
            $('#modal-store').modal('show');
            $('#name').val('');
            $('#btn-store-type').prop('disabled', false);
        }

        function storeType() {
            let name = $('#name').val();

            if (!name) {
                toastr.warning('Nama type tidak boleh kosong!', 'Peringatan!');
                return false;
            }

            $('#btn-store-type').prop('disabled', true);
            var type = 'POST';
            var url = "{{ route('api.types.store') }}";
            $.ajax({
                url: url,
                type: type,
                data: $('#form-type').serialize(),
                success: function(data) {
                    $('#modal-store').modal('hide');
                    toastr.success(data.message, 'Berhasil!');
                    table.ajax.reload();
                },
                error: ajaxError,
                complete: function() {
                    $('#btn-store-type').prop('disabled', false);
                },
            });
        }

        // Edit Data
        $('body').on('click', '.edit', function(e) {
            e.preventDefault();
            editType($(this).attr('id'))
        });

        function editType(id) {
            $.ajax({
                url: "{{ env('APP_URL') }}/api/types/" + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(resp) {
                    $('#modal-update').modal('show');
                    $('#type_id').val(resp.data.id);
                    $('#name_update').val(resp.data.name);
                    $('#btn-update-type').prop('disabled', false);
                },
                error: ajaxError,
            });
        }

        function updateType() {
            let name = $('#name_update').val();
            if (!name) {
                toastr.warning('Nama type tidak boleh kosong!', 'Peringatan!');
                return false;
            }

            let id = $('#type_id').val();
            $('#btn-update-type').prop('disabled', true);
            $.ajax({
                url: "{{ env('APP_URL') }}/api/types/" + id + "/update",
                type: 'PUT',
                data: $('#form-update-type').serialize(),
                success: function(resp) {
                    $('#modal-update').modal('hide');
                    toastr.success(resp.message, 'Berhasil!');
                    table.ajax.reload();
                },
                error: ajaxError,
                complete: function() {
                    $('#btn-update-type').prop('disabled', false);
                },
            });

        }

        // delete
        $('body').on('click', '.delete', function(e) {
            e.preventDefault();
            deleteType($(this).attr('id'))
        });

        function deleteType(id) {
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
                        url: "{{ env('APP_URL') }}/api/types/" + id + "/destroy",
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
