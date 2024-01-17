<!-- form  Add -->
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
				    <input type="hidden" name="nama_survey_id" value="{{ $namaSurvey->id }}" readonly>
                    <div class="row mb-3">
                        <label class="form-label">Pertanyaan</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="pertanyaan" id="pertanyaan" placeholder="Masukkan pertanyaan...">
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Jenis </label>
                        <div class="input-group">
                            <select name="jenis" id="jenis" class="form-control select2">
                                <option value="">--Pilih Jenis--</option>
                                <option value="0">Esai</option>
                                <option value="1">Pilihan 1-5</option>
                                <option value="2">Pilihan Ya Tidak</option>
                            </select>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label class="form-label">Jawaban 1</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="pilihan1" id="pilihan1" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label class="form-label">Jawaban 2</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="pilihan2" id="pilihan2" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label class="form-label">Jawaban 3</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="pilihan3" id="pilihan3" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label class="form-label">Jawaban 4</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="pilihan4" id="pilihan4" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label class="form-label">Jawaban 5</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="pilihan5" id="pilihan5" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label class="form-label">Keterangan</label>
                                <div class="input-group">
                                <textarea id="keterangan" name="keterangan" class="form-control" placeholder="Masukkan keterangan..."></textarea>
                                </div>
                            </div>
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