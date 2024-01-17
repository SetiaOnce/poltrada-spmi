@extends('layouts.admin')
@section('konten')

@section('title')
    Admin Manajemen Konten SPM
@stop
<!-- halaman title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Profile Aplikasi</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="ri-home-3-fill"></i></a></a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Manajemen Konten</a></li>
                    <li class="breadcrumb-item active">Profile App SPMI</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end halaman title -->

<!-- Profile Link Aplikasi -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Halaman Pengaturan Profile Aplikasi</h4>
                    
                </div>
                <hr>
                <div class="row">
                    <form id="form-data" class="form">
                    @csrf
                        <div class="row mb-3">
                            <label class="form-label">Nama Aplikasi : 
                            <div class="form-group">
                                <input class="form-control" name="nama_aplikasi" type="text" placeholder="Isi Nama Aplikasi" id="nama_aplikasi" autocomplete="off" value="{{ $profile_app->nama_aplikasi }}">
                            </div>
                            <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label">Footer : 
                            <div class="form-group">
                                <input class="form-control" name="footer" type="text" placeholder="Isi judul footer" id="footer" autocomplete="off" value="{{ $profile_app->footer }}">
                            </div>
                            <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label">Logo Header Panjang : <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="file" name="logo_header_panjang" class="form-control" id="logo_header_panjang">
                            </div>
                            <span class="text-mute" style="font-size:12px;">File berekstensi <strong style="color:#D23369;">.JPG, .JPEG, .PNG</strong> | maksimal <strong style="color:#D23369;">1 MB</strong> | Ukuran Ideal: 641pixel x 91pixel</span>
                        </div>
                        <div class="row mb-3">
                            <div class="input-group">
                                <img id="showImage" class="img-fluid" alt="img-2" src="{{ asset($profile_app->logo_header_panjang) }}"  width="50%" style="border-style: dashed; background: #edede9; width:50%;">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label">Logo Header Kecil : <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="file" name="logo_header_kecil" class="form-control" id="logo_header_kecil">
                            </div>
                            <span class="text-mute" style="font-size:12px;">File berekstensi <strong style="color:#D23369;">.JPG, .JPEG, .PNG</strong> | maksimal <strong style="color:#D23369;">1 MB</strong> | Ukuran Ideal: 119pixel x 91pixel</span>
                        </div>
                        <div class="row mb-3">
                            <div class="input-group">
                                <img id="showImage2" class="img-fluid" alt="img-2" src="{{ asset($profile_app->logo_header_kecil) }}"  style="border-style: dashed; background: #edede9; width:150px;">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label">Logo Aplikasi : <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="file" name="logo_aplikasi" class="form-control" id="logo_aplikasi">
                            </div>
                            <span class="text-mute" style="font-size:12px;">File berekstensi <strong style="color:#D23369;">.JPG, .JPEG, .PNG</strong> | maksimal <strong style="color:#D23369;">1 MB</strong> | Ukuran Ideal: 226pixel x 221pixel</span>
                        </div>
                        <div class="row mb-3">
                            <div class="input-group">
                                <img id="showImage3" class="img-fluid" alt="img-2" src="{{ asset($profile_app->logo_aplikasi) }}"  style="border-style: dashed; background: #edede9; width:150px;">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label">Banner Login : <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="file" name="banner_login" class="form-control" id="banner_login">
                            </div>
                            <span class="text-mute" style="font-size:12px;">File berekstensi <strong style="color:#D23369;">.JPG, .JPEG, .PNG</strong> | maksimal <strong style="color:#D23369;">2 MB</strong> | Ukuran Ideal: 550pixel x 450pixel</span>
                        </div>
                        <div class="row mb-3">
                            <div class="input-group">
                                <img id="showImage5" class="img-fluid" alt="img-2" src="{{ asset($profile_app->banner_login) }}"  width="50%" style="border-style: dashed; background: #edede9; width:50%;">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="form-label">Banner Detail : <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="file" name="banner_detail" class="form-control" id="banner_detail">
                            </div>
                            <span class="text-mute" style="font-size:12px;">File berekstensi <strong style="color:#D23369;">.JPG, .JPEG, .PNG</strong> | maksimal <strong style="color:#D23369;">2 MB</strong> | Ukuran Ideal: 641pixel x 91pixel</span>
                        </div>
                        <div class="row mb-3">
                            <div class="input-group">
                                <img id="showImage4" class="img-fluid" alt="img-2" src="{{ asset($profile_app->banner_detail) }}"  width="50%" style="border-style: dashed; background: #edede9; width:50%;">
                            </div>
                        </div>
                        <div class="mt-3" style="float: right;">
                            <button id="btn-save" class="btn btn-primary btn-sm waves-effect" type="submit"><i class="ri-save-fill align-middle"></i> Simpan</button>
                        </div>
                    </form>
                </div>
            
            </div>
        </div>
    </div>
</div>
<!-- End Link Aplikasi -->


@section('js')
    @include('rules.admin.profile_app.script');
@stop

@endsection