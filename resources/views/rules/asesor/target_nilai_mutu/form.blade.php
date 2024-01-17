<!-- form Add -->
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
                        <label class="form-label">Tahun : </label>
                        <div class="input-group" id="datepicker5">
                           <input type="text" name="tahun" id="tahun" class="form-control" data-provide="datepicker" data-date-container='#datepicker5'data-date-format="yyyy" data-date-min-view-mode="2" data-date-autoclose="true" placeholder="Pilih Tahun..." autocomplete="off">
                           <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Lembaga Akreditasi :</label>
                        <div class="input-group">
                            <select name="lembaga_akreditasi_id" id="lembaga_akreditasi_id" class="form-control select2">
                                <option value="">--Pilih Lembaga Akreditasi--</option>
                                @foreach($data_lembaga_akreditasi as $lembaga)
                                <option value="{{ $lembaga->id }}">{{ $lembaga->nama_lembaga }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Unit\Prodi :</label>
                        <div class="input-group">
                            <select name="unit_prodi_id" id="unit_prodi_id" class="form-control select2">
                                <option value="">--Pilih Unit\Prodi--</option>
                                @foreach($data_unit_prodi as $prodi)
                                <option value="{{ $prodi->id }}">{{ $prodi->nama_unit_prodi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Target Nilai :</label>
                        <div class="input-group">
                            <input type="text" name="target_nilai" id="target_nilai" onkeypress="return hanyaAngka(event)" class="form-control" placeholder="Masukkan target nilai...">
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Keterangan :</label>
                        <div class="input-group">
                            <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Masukkan Keterangan..."></textarea>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
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