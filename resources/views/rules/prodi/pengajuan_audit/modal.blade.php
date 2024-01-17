<!--  Modal Add -->
<div class="modal fade bs-example-modal-lg" id="modalAddData" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h6 class="modal-title">Tambah Data Pendukung
            </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="_closemodal()"></button>
            </div>
            <div class="modal-body">
               <div class="row">
                    <div class="col-lg-12">
                        <table  class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="table-secondary" width="25%">Jenis Standar Mutu :</th>
                                    <th id="title_jenis_standar_mutu"> Tata Cara Penulisan Tugas Akhir</th>
                                </tr>
                            </thead>
                        </table>

                        <form id="form-dokumen-pendukung" class="form" onsubmit="return false">
                        @csrf
                            <input type="hidden" class="form-control" name="pengajuan_id" id="pengajuan_id" readonly>

                            <div class="row mb-3">
                                <label class="form-label">Nama Dokumen : <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="nama_dokumen" id="nama_dokumen" placeholder="Masukkan nama dokumen...">
                                </div>
                                <span class="text-mute" style="font-size:12px;"><span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span></span>
                            </div>
                            <div class="row mb-3">
                                <label class="form-label">File Permohonan : <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="file" class="form-control" name="file_permohonan" id="file_permohonan" accept="application/pdf">
                                </div>
                                <span class="text-mute" style="font-size:12px;"><span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span> | File berekstensi <strong style="color:#D23369;">.PDF</strong> | maksimal <strong style="color:#D23369;">3 MB</strong></span>
                            </div>
                            <div class="mt-3 mb-4">
                                <button id="btn-dokumen-pendukung" class="btn btn-primary btn-sm waves-effect" type="submit"><i class="ri-save-fill align-middle"></i> Simpan</button>
                            </div>
                        </form>

                        <div class="table-responsive">
                            <table id="PendukungTable" class="table table-bordered mb-0">
                                <thead class="table-info">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Dokumen</th>
                                        <th>File Pendukung</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody id="data_pendukung">
                                </tbody>
                            </table>
                        </div>
                    </div>
               </div>
            </div>
        </div>
    </div>
</div>