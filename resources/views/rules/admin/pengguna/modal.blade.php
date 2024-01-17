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
                        <label class="form-label">Level : </label>
                        <div class="input-group">
                            <select name="level" id="level" class="form-select" aria-label="Default select example">
                                <option selected="" value="disable">-- Pilih Level Pengguna --</option>
                                <option value="1">ADMINISTRATOR</option>
                                <option value="2">PENGELOLA</option>
                                <option value="3">UNIT/PRODI</option>
                                <option value="4">AUDITOR</option>
                            </select>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row mb-3" id="add_unit_prodi" style="position: static; zoom: 1;display: none;">
                        <label class="form-label">Unit/Prodi : </label>
                        <div class="input-group">
                            <select name="unit_prodi_id" id="unit_prodi_id" class="form-select" aria-label="Default select example">
                                <option selected="" value="disable">-- Pilih Unit/Prodi --</option>
                                @foreach($data_unit_prodi as $unit_prodi)
                                <option value="{{ $unit_prodi->id }}">{{ $unit_prodi->jenjang }} | {{ $unit_prodi->nama_unit_prodi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <label class="form-label">Nama : </label>
                            <div class="">
                            <select name="nama_lengkap" id="nama_lengkap" class="form-control select2">
                                <option selected="" value="disable">-- Pilih Nama Pengguna --</option>
                                @foreach($data_nama_sdm as $row)
                                    <option value="{{ $row->id }}">{{ $row->dataNama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Email : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="email" name="email" class="form-control" id="email" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">No Whatsapp : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" name="no_whatsapp" class="form-control" id="no_whatsapp" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Alamat : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <textarea required="" name="alamat" id="alamat" class="form-control" rows="5" readonly></textarea>
                        </div>
                    </div>
                    <!-- <div class="row mb-3">
                        <label class="form-label">Foto : </label>
                        <div class="input-group">
                            <input type="file" name="foto" class="form-control" id="foto">
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span> | File berekstensi <strong style="color:#D23369;">.JPG, .JPEG, .PNG</strong> | maksimal <strong style="color:#D23369;">1 MB</strong> | Ukuran Ideal: 256pixel x 256pixel</span>
                    </div> -->
                    <div class="row mb-3">
                        <label class="form-label">Foto : </label>
                        <input type="hidden" name="foto" class="form-control" id="foto" readonly>
                        <div class="input-group">
                            <img id="showImage" src="{{ asset('new_backend/assets/images/users/avatar-4.jpg') }}" alt="avatar-4" class="rounded-circle avatar-md">
                        </div>
                    </div>
                    <div class="row mb-3">
                     <label class="form-label">Password : </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text lihat-password" onclick="showPassword()"><i class="mdi mdi-eye"></i></span>
                            </div>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan password..." autocomplete="off">
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi! | Minimal <span class="text-danger">6</span> Karakter</span>
                    </div>
                    <div class="row mb-3">
                     <label class="form-label">Konfirmasi Password : </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text lihat-password" onclick="showPassword2()"><i class="mdi mdi-eye"></i></span>
                            </div>
                            <input type="password" class="form-control" name="konfirmasi_password" id="konfirmasi_password" placeholder="Masukkan konfirmasi password..." autocomplete="off">
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi! </span>
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
<!-- end form add data -->