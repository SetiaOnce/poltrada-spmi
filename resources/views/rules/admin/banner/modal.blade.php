<!--  Modal Add -->
<div class="modal fade bs-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="headeTitle">Input Konten Banner Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="_tutup()"></button>
            </div>
            <div class="modal-body">
               <div class="row">
                    <div class="col-md-12">
                        <form id="form-data" class="form">
                            @csrf
                            <input type="hidden" name="id" id="id" readonly> 
					        <input type="hidden" name="methodform_data" id="methodform_data" readonly>
                            <div class="mb-3">
                                <label class="form-label">File Banner : <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="file" name="file_banner" class="form-control" id="file_banner">
                                </div>
                                <span class="text-danger">*)</span><span class="text-mute" style="font-size:12px;"> Harus diisi! </span>|
                                <span class="text-mute" style="font-size:12px;">File berekstensi <strong style="color:#D23369;">.JPG, .JPEG, .PNG</strong> | maksimal <strong style="color:#D23369;">2 MB</strong> | Ukuran Ideal: 1255pixel x 457pixel</span>
                            </div>
                            <div class="mb-3">
                                <img id="showImage" class="img-thumbnail" alt="200x200" width="500" src="{{ asset('img/no-image.png') }}" data-holder-rendered="true">
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