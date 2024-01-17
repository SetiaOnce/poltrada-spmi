<!-- form  Add -->
<div id="card-form" class="row" style="position: static; zoom: 1;display: none;">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title header-title"></h4>
                </div>
                <hr>
                <form id="form-data"  class="form" onsubmit="return false">
                    @csrf
                    <input type="hidden" name="id" readonly> 
					<input type="hidden" name="methodform_data" readonly>
                    <div class="row d-flex justfy-content-between">
                        <div class="col-md-4">
                            <div class="row mb-3">
                                <label class="form-label">Tahun : </label>
                                <div class="input-group" id="datepicker5">
                                   <input type="text" name="tahun" id="tahun" class="form-control" data-provide="datepicker" data-date-container='#datepicker5'data-date-format="yyyy" data-date-min-view-mode="2" data-date-autoclose="true" placeholder="Pilih Tahun..." autocomplete="off">
                                   <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                </div><!-- input-group -->
                                <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row mb-3">
                                <label class="form-label">Jenis Akreditasi :</label>
                                <div class="input-group">
                                    <select name="fid_jenis_akreditasi" id="fid_jenis_akreditasi" class="form-control select2">
                                        <option value="">--Pilih Jenis Akreditasi--</option>
                                        @foreach($jenis_akreditasi as $row)
                                        <option value="{{ $row->id }}">{{ $row->nama_jenis_akreditasi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Dasar Kegiatan : </label>
                        <div class="input-group">
                            <input type="text"  class="form-control" name="dasar_kegiatan" id="dasar_kegiatan" placeholder="Masukkan dasar kegiatan...">
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Timeline Akreditasi : <span class="text-danger">*</span></label>
                        <div id="timeline_akreditasi_view" class="mb-3" style="display: none;"></div>
                        <input id="timeline_akreditasi" name="timeline_akreditasi" type="file" class="form-control" accept=".pdf" data-msg-placeholder="Pilih {files}...">
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

<!-- form  Add file -->
<div id="card-form-file" class="row" style="position: static; zoom: 1;display: none;">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title header-title"></h4>
                    <div class="btn">
                        <button onclick="_closeForm()" class="btn btn-danger btn-sm waves-effect" type="button"><i class="ri-delete-back-2-fill align-middle"></i> Kembali</button>
                        <button onclick="_addFileSrc()" data-bs-original-title="Tambah File Baru" data-bs-placement="top" data-bs-toggle="tooltip" class="btn btn-info btn-sm"><i class="ri-add-fill align-middle me-1"></i> Tambah File</button>
                    </div>
                </div>
                <hr>
                <div id="formfile-src" style="display: none;">
                    <form id="form-file" class="form" onsubmit="return false">
                        @csrf
                        <input type="hidden" name="idp_akreditasi" readonly> 
                        <div class="row mb-3">
                            <label class="form-label">Jenis File :</label>
                            <div class="input-group">
                                <select name="jenis_file" id="jenis_file" class="form-control select2">
                                    <option value="">--Pilih Jenis File--</option>
                                    <option value="Data LKSP">Data LKSP</option>
                                    <option value="Data LED">Data LED</option>
                                    <option value="Instrumen Akreditasi">Instrumen Akreditasi</option>
                                </select>
                            </div>
                            <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label">Nama File : </label>
                            <div class="input-group">
                                <input type="text"  class="form-control" name="nama_file" id="nama_file" placeholder="Masukkan nama file...">
                            </div>
                            <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label">File : <span class="text-danger">*</span></label>
                            <div id="file_akreditasi_view" class="mb-3" style="display: none;"></div>
                            <input id="file_akreditasi" name="file_akreditasi" type="file" class="form-control" accept=".pdf" data-msg-placeholder="Pilih {files}...">
                            <span class="text-mute" style="font-size:12px;"><span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span> | File berekstensi <code>.PDF</code> | maksimal <code>3 MB</code></span>
                        </div>
                        <div class="row justify-content-end d-flex align-middle align-items-center">
                            <div class="col-md-4 justify-content-end">
                                <button onclick="_closeAddFileSrc()" class="btn btn-secondary btn-sm waves-effect" type="button"><i class="mdi mdi-window-close align-middle"></i> Batal</button>
                                <button id="btn-save-file" class="btn btn-primary btn-sm waves-effect" type="submit"><i class="ri-save-fill align-middle"></i> Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row mt-4" id="headerAkreditasi"></div>
                <div class="row justify-content-end d-flex align-middle align-items-center">
                    Filter 
                    <div class="col-md-4">
                        <div class="input-group">
                            <select name="filterJenisFile" id="filterJenisFile" class="form-control select2">
                                <option value="">SEMUA</option>
                                <option value="Data LKSP">Data LKSP</option>
                                <option value="Data LED">Data LED</option>
                                <option value="Instrumen Akreditasi">Instrumen Akreditasi</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="table-responsive mt-3">
                    <table id="dt-fileAkreditasi" class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="table-secondary">
                            <tr class="text-center">
                                <th>NO</th>
                                <th>JENIS FILE</th>
                                <th>NAMA FILE</th>
                                <th>FILE</th>
                                <th>OPSI</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end form -->