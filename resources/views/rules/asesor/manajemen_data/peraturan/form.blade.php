<!-- form add Add -->
<div id="card-form" class="row" style="position: static; zoom: 1;display: none;">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title header-title"></h4>
                </div>
                <hr>

                <form id="form-data" class="form" onsubmit="return false">
                    @csrf
                    <input type="hidden" name="id" readonly> 
					<input type="hidden" name="methodform_data" readonly>
                    <div class="row mb-3">
                        <label class="form-label">Jenis Peraturan : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select name="jenis_peraturan_id" id="jenis_peraturan_id" class="form-control select2">
                                <option value="">--Pilih Jenis Peraturan--</option>
                                <option value="AK">Jenis Peraturan 1</option>
                                <option value="HI">Jenis Peraturan 2</option>
                                <option value="HI">Jenis Peraturan 3</option>
                                <option value="HI">Jenis Peraturan 4</option>
                                <option value="HI">Jenis Peraturan 5</option>
                            </select>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Nama Peraturan : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="nama_peraturan" id="nama_peraturan" placeholder="Masukkan nama peraturan...">
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">File Pdf : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="file" class="form-control" name="file_peraturan" id="file_peraturan" accept="application/pdf">
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span> | File berekstensi <strong style="color:#D23369;">.PDF</strong> | maksimal <strong style="color:#D23369;">2 MB</strong></span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label"></label>
                        <div class="input-group">
                            <a href="javascript:void(0);" onclick="previewPdf()" id="showPdf" style="position: static; zoom: 1;display: none;" data-bs-original-title="Lihat File Pdf" data-bs-placement="top" data-bs-toggle="tooltip">
                                <img  src="{{ asset('img/pdf-image.jpg') }}" alt="avatar-4" class=" avatar-md"> <br>
                                <!-- *) <span class="text-mute" style="font-size:12px;">Klik untuk melihat priview</span> -->
                            </a>
                        </div>
                    </div>

                    <div class="mt-3" style="float: right;">
                        <button onclick="_closeForm()" class="btn btn-danger btn-sm waves-effect" type="button"><i class="ri-delete-back-2-fill align-middle"></i> Kembali</button>
                        <button id="btn-save" class="btn btn-primary btn-sm waves-effect" type="button"><i class="ri-save-fill align-middle"></i> Simpan</button>
                    </div>
                    
                </form>
            
            </div>
        </div>
    </div>
</div>
<!-- end form -->

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