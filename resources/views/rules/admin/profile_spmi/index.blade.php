@extends('layouts.admin')
@section('konten')

@section('title')
    Admin Manajemen Konten SPM
@stop
<!-- halaman title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Profile SPMI</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="ri-home-3-fill"></i></a></a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Manajemen Konten</a></li>
                    <li class="breadcrumb-item active">Profile SPMI</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end halaman title -->

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h6 class="text-dark" style="font-size: 13px;"><i class="mdi mdi-bullhorn-outline align-middle me-2 mdi-36px text-primary"></i> Halaman ini berfungsi untuk melakukan manajemen konten Profile SPMI</h6>
            </div>
        </div>
    </div>
</div>

<!-- Profile Visi Misi -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Profile Visi Misi SPMI : <span class="text-danger">*</span></h4>
                </div>
                <hr>
                <form id="profile_visi_misi" class="form">
                @csrf
                    <textarea id="visi_misi" name="visi_misi">{{ $profile_spmi->visi_misi }}</textarea>

                    <div class="mt-3" style="float: right;">
                        <button id="save_visi_misi" class="btn btn-primary btn-sm waves-effect" type="submit"><i class="ri-save-fill align-middle"></i> Simpan</button>
                    </div>
                </form>
            
            </div>
        </div>
    </div>
</div>
<!-- End Profile Visi Misi -->

<!-- Profile Fungsi Dan Tuga -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Profile Fungsi dan Tugas : <span class="text-danger">*</span></h4>
                </div>
                <hr>
                <form id="profile_fungsi_tugas" class="form">
                @csrf
                    <textarea id="fungsi_tugas" name="fungsi_tugas">{{ $profile_spmi->fungsi_tugas }}</textarea>
                    <div class="mt-3" style="float: right;">
                        <button id="save_fugsi_tugas" class="btn btn-primary btn-sm waves-effect" type="submit"><i class="ri-save-fill align-middle"></i> Simpan</button>
                    </div>
                </form>
            
            </div>
        </div>
    </div>
</div>
<!-- End Fungsi Dan Tuga -->

<!-- Profile Struktur Organisasi -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Profile Struktur Organisasi : <span class="text-danger">*</span></h4>
                </div>
                <hr>
                <form id="profile_struktur_organisasi">
                    <div class="mb-3">
                        <label class="form-label">Gambar Struktur : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="file" name="gambar_struktur" class="form-control" id="gambar_struktur">
                        </div>
                        *) <span class="text-mute" style="font-size:12px;">File berekstensi <strong style="color:#D23369;">.JPG, .JPEG, .PNG</strong> | maksimal <strong style="color:#D23369;">2 MB</strong> | Ukuran Ideal: 975pixel x 563pixel</span>
                    </div>
                    <div class="mb-3">
                        <a onclick="showImage()"  href="javascript:void(0);">
                            <img id="showImage" class="img-fluid" alt="img-2" src="{{ asset($profile_spmi->struktur_organisasi) }}"  width="145" style="border-style: dashed;"><br>
                            *) <span class="text-mute" style="font-size:12px;">Klik gambar untuk melihat priview</span>
                        </a>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="5" placeholder="Masukkan deskripsi...">{{ $profile_spmi->deskrip_struktur }}</textarea>
                        </div>
                    </div>
                    <div class="mt-3" style="float: right;">
                        <button id="save_struktur" class="btn btn-primary btn-sm waves-effect" type="button"><i class="ri-save-fill align-middle"></i> Simpan</button>
                    </div>
                </form>
            
            </div>
        </div>
    </div>
</div>
<!-- End Struktur Organisasi -->
@include('rules.admin.profile_spmi.modal')

@section('js')

@include('rules.admin.profile_spmi.script');

@stop

@endsection