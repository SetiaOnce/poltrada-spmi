<!--  Modal Add -->
<div class="modal fade bs-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="headeTitle"></h5>
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
                                <label class="form-label">Nama Jenis Survey : </label>
                                <div class="input-group">
                                    <input type="text" name="nama_jenis_survey" class="form-control" id="nama_jenis_survey" placeholder="Masukkan jenis survey">
                                </div>
                                <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Keterangan : </label>
                                <div class="input-group">
                                    <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Masukkan jenis survey"></textarea>
                                </div>
                                <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi! | Maksimal <span class="text-danger">255</span> Karakter</span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gambar : <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="file" name="gambar" id="gambar" class="form-control">
                                </div>
                                <span class="text-danger">*)</span><span class="text-mute" style="font-size:12px;"> Harus diisi! </span>|
                                <span class="text-mute" style="font-size:12px;">File berekstensi <strong style="color:#D23369;">.JPG, .JPEG, .PNG</strong> | maksimal <strong style="color:#D23369;">2 MB</strong> | Ukuran Ideal: 226pixel x 221pixel</span>
                            </div>
                            <div class="mb-3">
                                <img id="showImage" class="img-thumbnail" alt="200x200" width="150" src="{{ asset('img/no-image.png') }}" data-holder-rendered="true">
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