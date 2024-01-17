<!-- form add Add -->
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
                        <label class="form-label">Program Studi : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select name="fid_program_studi" id="fid_program_studi" class="form-control select2">
                                <option value="">--Pilih Program Studi--</option>
                                @foreach($dt_unitProdi as $row)
                                <option value="{{ $row->id }}">{{ $row->nama_prodi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label class="form-label">Program : <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="program" id="program" placeholder="Masukkan program...">
                                </div>
                                <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label class="form-label">Status & Peringkat : <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="status_peringkat" id="status_peringkat" placeholder="Masukkan status peringkat...">
                                </div>
                                <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                            </div>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label class="form-label">Tahun SK : <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control inputYear" name="tahun_sk" id="tahun_sk" placeholder="Masukkan tahun sk..." autocomplete="off">
                                </div>
                                <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi! | Input Tahun Contoh : <code>2023</code></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <label class="form-label">Tanggal Kedaluarsa : <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control inputDate" name="tanggal_kedaluarsa" id="tanggal_kedaluarsa" placeholder="Masukkan tanggal kedaluarsa..." autocomplete="off">
                                </div>
                                <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi! | Input Tanggal <code>dd/mm/yyyy</code> Contoh : <code>12/04/2023</code></span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">File Sertifikat: <span class="text-danger">*</span></label>
                        <div id="file_sertifikat_view" class="mb-3" style="display: none;"></div>
                        <input id="file_sertifikat" name="file_sertifikat" type="file" class="form-control" accept=".pdf" data-msg-placeholder="Pilih {files}...">
                        <span class="text-mute" style="font-size:12px;"><span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span> | File berekstensi <code>.PDF</code> | maksimal <code>3 MB</code></span>
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