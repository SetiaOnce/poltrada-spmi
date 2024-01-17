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
                                <label class="form-label">Jenjang :</label>
                                <div class="input-group">
                                    <select name="jenjang" id="jenjang" class="form-control select2">
                                        <option value="">--Pilih Jenjang--</option>
                                        <option value="D3">D3</option>
                                        <option value="D4">D4</option>
                                        <option value="S1">S1</option>
                                        <option value="S2">S2</option>
                                        <option value="Unit">Unit</option>
                                    </select>
                                </div>
                                <span class="text-danger">*)</span><span class="text-mute" style="font-size:12px;"> Harus diisi!</span>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Unit Prodi :</label>
                                <div class="input-group">
                                    <input type="text" name="unit_prodi" class="form-control" id="unit_prodi" autocomplete="off" placeholder="Masukkan nama prodi...">
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