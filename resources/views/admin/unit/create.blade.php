<div class="modal fade" id="modal-store">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="row" action="{{ route('admin.satuan.store') }}" method="POST">
                    @csrf
                    <div class="form-group col-md-12">
                        <label>Nama</label>
                        <input type="text" id='name' required name="name" class="form-control">
                    </div>
                    <div class="form-group col-md-12">
                        <button type="submit" class="btn btn-primary float-right">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
