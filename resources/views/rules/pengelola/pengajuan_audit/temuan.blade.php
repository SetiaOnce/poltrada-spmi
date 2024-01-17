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

                    <dt class="col-sm-2"><strong>Tanggal Input</strong></dt>
                    <dd class="col-sm-10" id="daftar_tgl_input"></dd>
                </dl> 
                <hr>

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