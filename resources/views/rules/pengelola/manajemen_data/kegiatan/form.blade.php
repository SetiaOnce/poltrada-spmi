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
                        <label class="form-label">Jenis Kegiatan : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select name="jenis_akreditasi_id" id="jenis_akreditasi_id" class="form-control select2">
                                <option value="">--Pilih Jenis Akreditasi--</option>
                                @foreach($jenis_akreditasi as $row)
                                <option value="{{ $row->id }}">{{ $row->nama_jenis_akreditasi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Judul Kegiatan : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="judul_kegiatan" id="judul_kegiatan" placeholder="Masukkan judul kegiatan...">
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Deskripsi Kegiatan : <span class="text-danger">*</span></label>
                        <div class="form-group">
                            <textarea id="deskripsi_kegiatan" name="deskripsi_kegiatan"></textarea>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Foto Kegiatan : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="file" class="form-control" name="foto_kegiatan" id="foto_kegiatan" accept="image/jpg, image/jpeg, image/png" >
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span> | File berekstensi <strong style="color:#D23369;">.JPG, .JPEG, .PNG</strong> | maksimal <strong style="color:#D23369;">1 MB</strong> | Ukuran Ideal: 1080pixel x 1080pixel</span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label"></label>
                        <div class="input-group">
                            <img id="showImage" class="img-fluid" alt="img-2" src="{{ asset('img/no-image2.png') }}"  style="border-style: dashed; background: #edede9; width:150px;">
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