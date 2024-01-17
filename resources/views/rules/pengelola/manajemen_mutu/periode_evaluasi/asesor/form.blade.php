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
					<input type="hidden" name="priode_evaluasi_id" id="priode_evaluasi_id" value="{{ $periode_evaluasi->id }}" readonly>
                    <div class="row mb-3">
                        <label class="form-label">Jenis Standar Mutu : </label>
                        <div class="input-group">
                            <select name="jenis_standar_mutu_id" id="jenis_standar_mutu_id" class="form-control select2" readonly tabindex="-1">
                                <option selected value="{{ $periode_evaluasi->jenis_standar_id }}">{{ $periode_evaluasi->jenis_standar_mutu }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Nama Auditor :</label>
                        <div class="input-group">
                            <select name="asesor_id" id="asesor_id" class="form-control select2">
                                <option value="">--Pilih Auditor--</option>
                                @foreach($semua_data_asesor as $row)
                                <option value="{{ $row->id }}">{{ $row->nama }}</option>
                                @endforeach
                            </select>
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
