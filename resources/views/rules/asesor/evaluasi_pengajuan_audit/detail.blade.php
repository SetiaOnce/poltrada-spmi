<!-- detail pengajuan -->
<div id="card-detail" class="row" style="position: static; zoom: 1;display: none;">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Detail Pengajuan Audit</h4>
                </div>
                <hr>

                <dl class="row mb-0">
                    <dt class="col-sm-2"><strong>Tahun</strong></dt>
                    <dd class="col-sm-10" id="detail_tahun">: 2023</dd>

                    <dt class="col-sm-2"><strong>Nama Lembaga</strong></dt>
                    <dd class="col-sm-10" id="detail_nama_lembaga">: LAM-PTKes</dd>

                    <dt class="col-sm-2"><strong>Jenis Standar Mutu</strong></dt>
                    <dd class="col-sm-10" id="detail_jenis_standar_mutu">: Contoh Jenis Standar Mutu</dd>

                    <dt class="col-sm-2"><strong>Unit / Prodi</strong></dt>
                    <dd class="col-sm-10" id="detail_unit_prodi">: D4 | Teknologi Rekayasa Otomotif</dd>

                    <dt class="col-sm-2"><strong>Periode Awal</strong></dt>
                    <dd class="col-sm-10" id="detail_per_awal"></dd>

                    <dt class="col-sm-2"><strong>Periode Akhir</strong></dt>
                    <dd class="col-sm-10" id="detail_per_akhir"></dd>

                    <dt class="col-sm-2"><strong>Tanggal Input</strong></dt>
                    <dd class="col-sm-10" id="detail_tgl_input"></dd>

                    <dt class="col-sm-2 "><strong>Auditor Yang Bertugas</strong></dt>
                    <dd class="col-sm-10 " id="detail_asesor"> </dd>

                </dl>
                <hr>
                <h4 class="card-title mt-3">-Dokumen Pendukung</h4>
                <div class="table-responsive">
                    <table id="PendukungTable" class="table table-bordered mb-0">
                        <thead class="table-info">
                            <tr>
                                <th>No</th>
                                <th>Nama Dokumen</th>
                                <th>File Pendukung</th>
                            </tr>
                        </thead>
                        <tbody id="data_pendukung">
                        </tbody>
                    </table>
                </div>
                <hr>
                <h4 class="card-title mt-3">-Daftar Temuan</h4>
                <div class="table-responsive">
                    <table id="TemuanTabel" class="table table-bordered mb-0">
                        <thead class="table-info">
                            <tr>
                                <th>No</th>
                                <th>Auditor</th>
                                <th>Temuan</th>
                            </tr>
                        </thead>
                        <tbody id="detail_daftar_temuan">
                        </tbody>
                    </table>
                </div>
                <hr>
                <h4 class="card-title mt-3">-Daftar Rekomendasi</h4>
                <div class="table-responsive">
                    <table id="RekomendasiTabel" class="table table-bordered mb-0">
                        <thead class="table-info">
                            <tr>
                                <th>No</th>
                                <th>Auditor</th>
                                <th>Rekomendasi</th>
                                <th>Tanggal Akhir</th>
                            </tr>
                        </thead>
                        <tbody id="detail_daftar_rekomendasi">
                        </tbody>
                    </table>
                </div>
                <hr>
                <h4 class="card-title mt-3">-Laporan Akhir</h4>
                <dl class="row mb-0">
                    <dt class="col-sm-2"><strong>Tanggal Pembahasan</strong></dt>
                    <dd class="col-sm-10" id="detail_tanggal_pembahasan">: </dd>

                    <dt class="col-sm-2"><strong>File Pembahasan</strong></dt>
                    <dd class="col-sm-10" id="detail_file_pembahasan">: </dd>

                    <dt class="col-sm-2"><strong>Resume Pembahasan</strong></dt>
                    <dd class="col-sm-10" id="detail_resume_pembahsan">: </dd>

                </dl>  
                
                <hr>
                <div class="mt-3" style="float: left;">
                    <button onclick="_closeForm()" class="btn btn-danger btn-sm waves-effect" type="button"><i class="ri-delete-back-2-fill align-middle"></i> Kembali</button>
                </div>
            
            </div>
        </div>
    </div>
</div>

<!-- end detail pengajuan -->