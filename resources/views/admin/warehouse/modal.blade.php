<div class="modal fade" id="modal-store">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Data Gudang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-warehouse">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Nama">
                        <span class="text-danger" id="nameError"></span>
                    </div>
                    <button type="button" onclick="storeWarehouse()" class="btn btn-primary"
                        id="btn-store-warehouse">Simpan</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<div class="modal fade" id="modal-update">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Data Gudang</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-update-warehouse">
                    @csrf
                    <input type="hidden" class="d-none" name="warehouse_id" id="warehouse_id" readonly>
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" name="name_update" id="name_update"
                            placeholder="Nama">
                        <span class="text-danger" id="nameError"></span>
                    </div>
                    <button type="button" onclick="updateWarehouse()" class="btn btn-primary"
                        id="btn-update-warehouse">Update</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
