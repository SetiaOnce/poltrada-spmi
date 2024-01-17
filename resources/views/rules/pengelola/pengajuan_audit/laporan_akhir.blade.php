<!-- detail pengajuan -->
<div id="card-laporan-akhir" class="row" style="position: static; zoom: 1;display: none;">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Laporan Akhir</h4>
                </div>
                <hr>        
                
                <form id="form-laporan-akhir" class="form" onsubmit="return false">
                    @csrf
                    <input type="hidden" name="id" readonly> 
					<input type="hidden" name="methodform_data" readonly>
					<input type="hidden" name="pengajuan_id" readonly>
                    <div class="row mb-3">
                        <label class="form-label">Tanggal Pembahasan : <span class="text-danger">*</span></label>
                        <div class="input-group" id="datepicker2">
                            <input type="text" name="tanggal_pembahasan" id="tanggal_pembahasan" class="form-control" placeholder="Tahun Bulan Tanggal" data-date-format="yyyy-mm-dd" data-date-container='#datepicker2' data-provide="datepicker" data-date-autoclose="true" autocomplete="off">
                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi! |<span class="text-danger"> Tahun-Bulan-Tanggal</span></span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Resume Pembahasan : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <textarea name="resume_pembahasan" id="resume_pembahasan" class="form-control" rows="5"></textarea>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">File Pembahasan : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="file" class="form-control" name="file_pembahasan" id="file_pembahasan" accept="application/pdf">
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span> | File berekstensi <strong style="color:#D23369;">.PDF</strong> | maksimal <strong style="color:#D23369;">2 MB</strong></span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label"></label>
                        <div class="input-group">
                            <a href="javascript:void(0);" id="showPdf" style="position: static; zoom: 1;display: none;" data-bs-original-title="Lihat File Pdf" data-bs-placement="top" data-bs-toggle="tooltip" target="_blank">
                                <img  src="{{ asset('img/pdf-image.jpg') }}" alt="avatar-4" class=" avatar-md"> 
                            </a>
                        </div>
                    </div>

                    <div class="mt-3" style="float: right;">
                        <button onclick="_closeForm()" class="btn btn-danger btn-sm waves-effect" type="button"><i class="ri-delete-back-2-fill align-middle"></i> Kembali</button>
                        <button id="btn-save" class="btn btn-primary btn-sm waves-effect" type="submit"><i class="ri-save-fill align-middle"></i> Simpan</button>
                    </div>
                    
                </form>
            
            </div>
        </div>
    </div>
</div>

<!-- end detail pengajuan -->