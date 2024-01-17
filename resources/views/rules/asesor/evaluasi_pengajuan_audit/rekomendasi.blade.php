<!-- detail rekomendasi -->
<div id="card-rekomendasi" class="row" style="position: static; zoom: 1;display: none;">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Daftar Rekomendasi</h4>
                </div>
                <hr>

                <dl class="row mb-0">
                    <dt class="col-sm-2"><strong>Tahun</strong></dt>
                    <dd class="col-sm-10" id="rek_tahun">: </dd>

                    <dt class="col-sm-2"><strong>Nama Lembaga</strong></dt>
                    <dd class="col-sm-10" id="rek_nama_lembaga">:</dd>

                    <dt class="col-sm-2"><strong>Jenis Standar Mutu</strong></dt>
                    <dd class="col-sm-10" id="rek_jenis_standar_mutu">: </dd>

                    <dt class="col-sm-2"><strong>Unit / Prodi</strong></dt>
                    <dd class="col-sm-10" id="rek_unit_prodi">: </dd>

                    <dt class="col-sm-2"><strong>Periode Awal</strong></dt>
                    <dd class="col-sm-10" id="rek_per_awal"></dd>

                    <dt class="col-sm-2"><strong>Periode Akhir</strong></dt>
                    <dd class="col-sm-10" id="rek_per_akhir"></dd>

                    <dt class="col-sm-2"><strong>Tanggal Input</strong></dt>
                    <dd class="col-sm-10" id="rek_tgl_input">: </dd>

                </dl>

                <hr>
                <form id="form-rekomendasi" class="form" onsubmit="return false" style="position: static; zoom: 1;display: none;">
                    @csrf
                    <input type="hidden" name="id" readonly> 
					<input type="hidden" name="methodform_data" readonly>
					<input type="hidden" name="rek_pengajuan_id" id="rek_pengajuan_id" readonly>
					<input type="hidden" name="rek_asesor_id" id="rek_asesor_id" readonly>
                    <div class="row mb-3">
                        <label class="form-label">Rekomendasi : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="rekomendasi" id="rekomendasi" placeholder="Masukkan rekomendasi..."></input>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Tanggal Akhir </label>
                        <div class="input-group" id="datepicker2">
                            <input type="text" name="tanggal_akhir" id="tanggal_akhir" class="form-control" placeholder="Tahun-Bulan-Tanggal" data-date-format="yyyy-mm-dd" data-date-container='#datepicker2' data-provide="datepicker" data-date-autoclose="true" autocomplete="off">
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi! | Contoh input 2023-01-01</span>
                    </div>

                    <div class="mb-3">
                        <button id="rek-btn-save" class="btn btn-primary btn-sm waves-effect" type="submit"><i class="ri-save-fill align-middle"></i> Simpan</button>
                    </div>
                    
                </form>

                <h4 class="card-title mt-3">-Daftar Rekomendasi</h4>
                <div class="row mb-3">
                    <div class="table-responsive">
                        <table id="RekomendasiTable" class="table table-bordered mb-0">
                            <thead class="table-info">
                                <tr>
                                    <th>No</th>
                                    <th>Rekomendasi</th>
                                    <th>Tanggal Akhir</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody id="daftar_rekomendasi">
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <hr>
                <div class="mt-3" style="float: left;">
                    <button onclick="_closeForm()" class="btn btn-danger btn-sm waves-effect" type="button"><i class="ri-delete-back-2-fill align-middle"></i> Kembali</button>
                </div>
            
            </div>
        </div>
    </div>
</div>

<!-- end rekomendasi -->