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
                        <label class="form-label">Periode Evaluasi :</label>
                        <div class="input-group">
                            <select name="priode_evaluasi_id" id="priode_evaluasi_id" class="form-control select2">
                                <option value="">--Pilih Periode Evaluasi--</option>
                                @foreach($data_priode_evaluasi as $priode_evaluasi)
                                    @if($priode_evaluasi->tahun >= date('Y'))
                                        <option value="{{ $priode_evaluasi->id }}">{{ $priode_evaluasi->tahun }} | {{ $priode_evaluasi->nama_lembaga }} | {{ $priode_evaluasi->jenis_standar }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div id="informasi-data-dukung" class="row" style="position: static; zoom: 1;display: none;">
                        <div class="input-group">
                            <div class="alert alert-info form-control" role="alert">
                                <strong>Data Pendukung Yang Harus dipersiapkan :</strong>
                                <p id="data-pendukung">
                                    
                                </p>
                                <strong>Auditor Yang Bertugas :</strong>
                                <p id="data-asesor">
                                    1. yoga <br>
                                    2. lorem
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Jenis Standar Mutu :</label>
                        <div class="input-group">
                            <select name="jenis_standar_mutu_id" id="jenis_standar_mutu_id" class="form-control select2" readonly tabindex="-1">
                                
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Unit/Prodi : </label>
                        <div class="input-group">
                            <input type="hidden" name="user_id" value="{{ $unit_prodi->pegawaiId }}" readonly>
                            <select name="unit_prodi" id="unit_prodi" class="form-control select2" readonly tabindex="-1">
                                <option selected value="{{ $unit_prodi->id }}">{{ $unit_prodi->unit_kerja }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Tanggal Input : </label>
                        <div class="input-group" id="datepicker2">
                            <input type="text" name="tgl_input" id="tgl_input" class="form-control" placeholder="Tahun-Bulan-Tanggal" data-date-format="yyyy-mm-dd" data-date-container='#datepicker2' data-provide="datepicker" data-date-autoclose="true" autocomplete="off">
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi! | Contoh input 2023-01-01</span>
                    </div>

                    <div class="mt-3 " style="float: right;">
                        <button onclick="_closeForm()" class="btn btn-danger btn-sm waves-effect" type="button"><i class="ri-delete-back-2-fill align-middle"></i> Kembali</button>
                        <button id="btn-save" class="btn btn-primary btn-sm waves-effect" type="submit"><i class="ri-save-fill align-middle"></i> Simpan</button>
                    </div><br><br><br><br><br>
                    
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end form -->