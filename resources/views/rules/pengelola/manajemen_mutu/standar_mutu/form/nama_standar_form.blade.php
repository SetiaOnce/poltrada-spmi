<!-- form  Add -->
<div id="card-form" class="row" style="position: static; zoom: 1;display: none;">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title header-title"></h4>
                </div>
                <hr>

                <form id="form-data"  class="form" onsubmit="return false">
                    @csrf
                    <input type="hidden" name="id" readonly> 
					<input type="hidden" name="methodform_data" readonly>
                    <div class="row mb-3">
                        <label class="form-label">Jenis Standar Mutu : </label>
                        <div class="input-group">
                            <select name="jenis_standar_mutu_id" id="jenis_standar_mutu_id" class="form-control select2" readonly tabindex="-1">
                                <option selected value="{{ $jenis_standar_mutu->id }}">{{ $jenis_standar_mutu->jenis_standar_mutu }}</option>
                            </select>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Tahun : </label>
                        <div class="input-group" id="datepicker5">
                            <input type="text"  class="form-control"  name="tahun" id="tahun" value="{{ $jenis_standar_mutu->tahun }}" readonly>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Lembaga Akreditasi :</label>
                        <div class="input-group">
                            <select name="lembaga_akreditasi_id" id="lembaga_akreditasi_id" class="form-control select2" readonly tabindex="-1">
                                <option selected value="{{ $jenis_standar_mutu->lembaga_akreditasi_id }}">{{ $jenis_standar_mutu->lembaga }}</option>
                            </select>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Unit\Prodi :</label>
                        <div class="input-group">

                            <select name="unit_prodi_id" id="unit_prodi_id" class="form-control select2" readonly tabindex="-1">
                                <option selected value="{{ $jenis_standar_mutu->unit_prodi_id }}">{{ $jenis_standar_mutu->prodi }}</option>
                            </select>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Nama Standar Mutu : </label>
                        <div class="input-group">
                            <input type="text"  class="form-control" name="nama_standar_mutu" id="nama_standar_mutu" placeholder="Masukkan nama standar mutu...">
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Data Dukung : </label>
                        <div class="input-group">
                            <textarea id="data_dukung" name="data_dukung"></textarea>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Keterangan : </label>
                        <div class="form-group">
                            <textarea id="keterangan" name="keterangan" class="form-control" placeholder="Masukkan keterangan..."></textarea>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Jenis Indikator : </label>
                        <div class="input-group">
                            <input type="text"  class="form-control" name="jenis_indikator" id="jenis_indikator" placeholder="Masukkan jenis indikator...">
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Bobot Nilai : </label>
                        <div class="input-group">
                            <input type="text" onkeypress="return hanyaAngka(event)" class="form-control" name="bobot_nilai" id="bobot_nilai" placeholder="Masukkan bobot nilai...">
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