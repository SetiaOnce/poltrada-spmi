<!-- daftar temuan -->
<div id="card-temuan" class="row" style="position: static; zoom: 1;display: none;">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Daftar Temuan</h4>
                </div>
                <hr>

                <dl class="row mb-0">

                    <dt class="col-sm-2"><strong>Tahun</strong></dt>
                    <dd class="col-sm-10" id="daftar_tahun"></dd>

                    <dt class="col-sm-2"><strong>Nama Lembaga</strong></dt>
                    <dd class="col-sm-10" id="daftar_nama_lembaga"></dd>

                    <dt class="col-sm-2"><strong>Jenis Standar Mutu</strong></dt>
                    <dd class="col-sm-10" id="daftar_jenis_standar_mutu"></dd>

                    <dt class="col-sm-2"><strong>Unit / Prodi</strong></dt>
                    <dd class="col-sm-10" id="daftar_unit_prodi"></dd>

                    <dt class="col-sm-2"><strong>Periode Awal</strong></dt>
                    <dd class="col-sm-10" id="daftar_per_awal"></dd>

                    <dt class="col-sm-2"><strong>Periode Akhir</strong></dt>
                    <dd class="col-sm-10" id="daftar_per_akhir"></dd>

                    <dt class="col-sm-2"><strong>Tanggal Input</strong></dt>
                    <dd class="col-sm-10" id="daftar_tgl_input"></dd>
                </dl> 
                <hr>
                <form id="form-temuan" class="form" onsubmit="return false">
                    @csrf
                    <input type="hidden" name="id" readonly> 
					<input type="hidden" name="methodform_data" readonly>
					<input type="hidden" name="pengajuan_id" id="pengajuan_id" readonly>
					<input type="hidden" name="asesor_id" id="asesor_id" readonly>
                    <div class="row mb-3">
                        <label class="form-label">Temuan : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <textarea class="form-control" name="temuan" id="temuan" placeholder="Masukkan temuan..."></textarea>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>

                    <div class="mb-3">
                        <button id="btn-save" class="btn btn-primary btn-sm waves-effect" type="submit"><i class="ri-save-fill align-middle"></i> Simpan</button>
                    </div>
                    
                </form>

                <h4 class="card-title mt-3">-Daftar Temuan</h4>
                <div class="row mb-3">
                    <div class="table-responsive">
                        <table id="PendukungTable" class="table table-bordered mb-0">
                            <thead class="table-info">
                                <tr>
                                    <th>No</th>
                                    <th>Temuan</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody id="daftar_temuan">
                            </tbody>
                        </table>
                    </div>
                </div>

                <hr>
                <div style="float: left;">
                    <button onclick="_closeForm()" class="btn btn-danger btn-sm waves-effect" type="button"><i class="ri-delete-back-2-fill align-middle"></i> Kembali</button>
                </div>
            
            </div>
        </div>
    </div>
</div>

<!-- end daftar temuan -->