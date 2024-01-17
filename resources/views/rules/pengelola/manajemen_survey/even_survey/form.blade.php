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
                    <div class="row mb-3">
                        <label class="form-label">Nama Survey </label>
                        <div class="input-group">
                            <select name="nama_survey_id" id="nama_survey_id" class="form-control select2">
                                <option value="">--Pilih Nama Survey--</option>
                                @foreach($data_nama_survey as $nama_survey)
                                <option value="{{ $nama_survey->id }}">{{ $nama_survey->nama_jenis_survey }} | {{ $nama_survey->tahun_survey }} | {{ $nama_survey->nama_survey }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Periode Evaluasi Diri Awal </label>
                        <div class="input-group" id="datepicker2">
                            <input type="text" name="priode_evaluasi_diri_awal" id="priode_evaluasi_diri_awal" class="form-control" placeholder="Tahun-Bulan-Tanggal" data-date-format="yyyy-mm-dd" data-date-container='#datepicker2' data-provide="datepicker" data-date-autoclose="true" autocomplete="off">
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi! | Contoh input 2023-01-01</span>
                    </div>

                    <div class="row mb-3">
                        <label class="form-label">Periode Evaluasi Diri Akhir </label>
                        <div class="input-group" id="datepicker2">
                            <input type="text" name="priode_evaluasi_diri_akhir" id="priode_evaluasi_diri_akhir" class="form-control" placeholder="Tahun-Bulan-Tanggal" data-date-format="yyyy-mm-dd" data-date-container='#datepicker2' data-provide="datepicker" data-date-autoclose="true" autocomplete="off">
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi! | Contoh input 2023-01-01</span>
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