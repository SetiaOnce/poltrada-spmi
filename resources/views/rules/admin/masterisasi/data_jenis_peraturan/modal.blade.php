<!--  Modal Add -->
<div class="modal fade bs-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="headeTitle">Input Konten Banner Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="row">
                    <div class="col-md-12">
                        <form id="form-data" class="form" onsubmit="return false">
                            @csrf
                            <input type="hidden" name="id" readonly> 
					        <input type="hidden" name="methodform_data" readonly>
                            <div class="mb-3">
                                <label class="form-label">Nama Jenis Peraturan : </label>
                                <div class="input-group">
                                    <input type="text" name="nama_jenis_peraturan" class="form-control" id="nama_jenis_peraturan" placeholder="Masukkan jenis peraturan...">
                                </div>
                                <span class="text-danger">*)</span><span class="text-mute" style="font-size:12px;"> Harus diisi!</span>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger btn-sm waves-effect" data-bs-dismiss="modal">Tutup</button>
                                <button id="btn-save" class="btn btn-primary btn-sm waves-effect" type="submit"><i class="ri-save-fill align-middle"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
               </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Add -->