<!--  Modal Add -->
<div class="modal fade bs-example-modal-lg" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="headeTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="row">
                    <div class="col-md-12">
                        <form id="form-data" class="form" onsubmit="return false">
                            @csrf
                            <input type="hidden" name="id" readonly> 
					        <input type="hidden" name="methodform_data" readonly>
                            <div class="mb-3">
                                <label class="form-label">Nama Jenis Produk : </label>
                                <div class="input-group">
                                    <input type="text" name="nama_jenis_produk" class="form-control" id="nama_jenis_produk" autocomplete="off" placeholder="Masukkan jenis produk...">
                                </div>
                                <span class="text-danger">*)</span><span class="text-mute" style="font-size:12px;"> Harus diisi!</span>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger btn-sm waves-effect" data-bs-dismiss="modal">Tutup</button>
                                <button id="btn-save" class="btn btn-primary btn-sm waves-effect" type="submit"><i class="ri-save-fill align-middle"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
               </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Add -->

<!--  Modal Sub Jenis -->
<div class="modal fade bs-example-modal-lg" id="modalSubJenis" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jenisProduk"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="row">
                    <div class="col-md-12">
                        <form id="form-sub-jenis" class="form" onsubmit="return false" style="position: static; zoom: 1;display: none;">
                            @csrf
                            <input type="hidden" name="id" readonly> 
					        <input type="hidden" name="methodform_data" readonly>
					        <input type="hidden" name="jenis_produk_id" readonly>
                            <div class="mb-3">
                                <label class="form-label"><span id="info-method" class="text-info"></span> Sub Jenis Produk : </label>
                                <div class="input-group">
                                    <input type="text" name="sub_jenis_produk" class="form-control" id="sub_jenis_produk" autocomplete="off" placeholder="Masukkan Sub jenis produk...">
                                </div>
                                <span class="text-danger">*)</span><span class="text-mute" style="font-size:12px;"> Harus diisi!</span>
                            </div>
                            <div class="mb-3">
                                <button id="btn-save" class="btn btn-primary btn-sm waves-effect" type="submit"><i class="ri-save-fill align-middle"></i> Simpan</button>
                            </div>
                        </form>
                        <div class="mb-2 d-sm-flex align-items-center justify-content-between">
                            <h4 class="card-title"></h4>
                            <button id="tambah-data" onclick="_addSubJenis()" data-bs-original-title="Tambah Data Baru" data-bs-placement="top" data-bs-toggle="tooltip" class="btn btn-info btn-sm"><i class="ri-add-fill align-middle me-1"></i> Tambah</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>NO</th>
                                        <th>SUB JENIS PRODUK</th>
                                        <th>OPSI</th>
                                    </tr>
                                </thead>
                                <tbody id="subJenisProduk">

                                </tbody>
                            </table>
                        </div>
                    </div>
               </div>
               <!-- <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm waves-effect" data-bs-dismiss="modal">Tutup</button>
                </div> -->
            </div>
        </div>
    </div>
</div>
<!-- End Sub Jenis-->

