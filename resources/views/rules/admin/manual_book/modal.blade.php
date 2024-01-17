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
                                <label class="form-label">Level : </label>
                                <div class="input-group">
                                    <select name="level_id" id="level_id" class="form-select" aria-label="Default select example">
                                        <option selected="" value="">-- Pilih Level --</option>
                                        <option value="1">ADMINISTRATOR</option>
                                        <option value="2">PENGELOLA</option>
                                        <option value="3">UNIT/PRODI</option>
                                        <option value="4">ASESOR</option>
                                    </select>
                                </div>
                                <span class="text-danger">*)</span><span class="text-mute" style="font-size:12px;"> Harus diisi!</span>
                            </div>
                            <div class="row mb-3">
                                <label class="form-label">File Manual : <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="file" class="form-control" name="file_manual" id="file_manual" accept="application/pdf">
                                </div>
                                <span class="text-mute" style="font-size:12px;"><span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span> | File berekstensi <strong style="color:#D23369;">.PDF</strong> | maksimal <strong style="color:#D23369;">3 MB</strong></span>
                            </div>
                            <div class="row mb-3">
                                <label class="form-label"></label>
                                <div class="input-group">
                                    <a href="javascript:void(0);" onclick="previewPdf()" id="showPdf" style="position: static; zoom: 1;display: none;" data-bs-original-title="Lihat File Pdf" data-bs-placement="top" data-bs-toggle="tooltip">
                                        <img  src="{{ asset('img/pdf-image.jpg') }}" alt="avatar-4" class=" avatar-md"> <br>
                                        *) <span class="text-mute" style="font-size:12px;">Klik untuk melihat priview</span>
                                    </a>
                                </div>
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

<!-- Modal Priview Pdf -->
<div class="modal fade bs-example-modal-xl" id="modalShow" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="myLargeModalLabel">Priview Pdf</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <embed id="PriviewPdf" type="application/pdf" src="" width="100%" height="500"></embed>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Priview Pdf -->
