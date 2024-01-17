<!--  Modal Add -->
<div class="modal fade bs-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="headeTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="_tutup()"></button>
            </div>
            <div class="modal-body">
               <div class="row">
                    <div class="col-md-12">
                        <form id="form-data" class="form" onsubmit="return false">
                            @csrf
                              <input type="hidden" name="id" readonly> 
                              <input type="hidden" name="methodform_data" readonly>
                            <div class="mb-3">
                                <label class="form-label">Keterangan : <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <textarea name="keterangan" id="keterangan" class="form-control"  placeholder="Masukkan foto pengumuman..."></textarea>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Foto Pengumuman : <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="file" name="foto_pengumuman" class="form-control" id="foto_pengumuman">
                                </div>
                                <span class="text-danger">*)</span><span class="text-mute" style="font-size:12px;"> Harus diisi! </span>|
                                <span class="text-mute" style="font-size:12px;">File berekstensi <strong style="color:#D23369;">.JPG, .JPEG, .PNG</strong> | maksimal <strong style="color:#D23369;">2 MB</strong> | Ukuran Ideal: 2000pixel x 2000pixel</span>
                            </div>
                            <div class="mb-3">
                                <img id="showImage" class="img-thumbnail" alt="200x200" width="300" src="{{ asset('img/no-image.png') }}" data-holder-rendered="true">
                            </div>
                            <div class="modal-footer">
                                <button type="button" onclick="_tutup()" class="btn btn-danger btn-sm waves-effect" data-bs-dismiss="modal">Tutup</button>
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