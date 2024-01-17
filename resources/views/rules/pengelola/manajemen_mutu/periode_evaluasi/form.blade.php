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
                        <label class="form-label">Jenis Standar Mutu :</label>
                        <div class="input-group">
                            <select name="jenis_standar_mutu_id" id="jenis_standar_mutu_id" class="form-control select2">
                                <option value="">--Pilih Jenis Standar Mutu--</option>
                                @foreach($data_jenis_standar_mutu as $row)
                                <option value="{{ $row->id }}">{{ $row->nama_lembaga }} | {{ $row->jenis_standar_mutu }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Periode Evaluasi Diri Awal : </label>
                        <div class="input-group" id="datepicker2">
                            <input type="text" name="priode_evaluasi_diri_awal" id="priode_evaluasi_diri_awal" class="form-control" placeholder="Tahun Bulan Tanggal" data-date-format="yyyy-mm-dd" data-date-container='#datepicker2' data-provide="datepicker" data-date-autoclose="true" autocomplete="off">
                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi! |<span class="text-danger"> Tahun-Bulan-Tanggal</span></span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Periode Evaluasi Diri Akhir : </label>
                        <div class="input-group" id="datepicker2">
                            <input type="text" name="priode_evaluasi_diri_akhir" id="priode_evaluasi_diri_akhir" class="form-control" placeholder="Tahun Bulan Tanggal" data-date-format="yyyy-mm-dd" data-date-container='#datepicker2' data-provide="datepicker" data-date-autoclose="true" autocomplete="off">
                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi! |<span class="text-danger"> Tahun-Bulan-Tanggal</span></span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Periode Visitasi Awal : </label>
                        <div class="input-group" id="datepicker2">
                            <input type="text" name="priode_visitasi_awal" id="priode_visitasi_awal" class="form-control" placeholder="Tahun Bulan Tanggal" data-date-format="yyyy-mm-dd" data-date-container='#datepicker2' data-provide="datepicker" data-date-autoclose="true" autocomplete="off">
                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi! |<span class="text-danger"> Tahun-Bulan-Tanggal</span></span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Periode Visitasi Akhir : </label>
                        <div class="input-group" id="datepicker2">
                            <input type="text" name="priode_visitasi_akhir" id="priode_visitasi_akhir" class="form-control" placeholder="Tahun Bulan Tanggal" data-date-format="yyyy-mm-dd" data-date-container='#datepicker2' data-provide="datepicker" data-date-autoclose="true" autocomplete="off">
                            <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi! |<span class="text-danger"> Tahun-Bulan-Tanggal</span></span>
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
