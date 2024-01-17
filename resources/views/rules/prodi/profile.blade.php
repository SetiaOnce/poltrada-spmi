@extends('layouts.prodi')
@section('konten')

@section('title')
    Prodi Dashboard SPMI | PTDI-STTD
@stop

@section('css')
    <style>
        .lihat-password{
            cursor: pointer;
        }
    </style>
@stop
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Profile Saya</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="ri-home-3-fill"></i></a></li>
                    <li class="breadcrumb-item active">Profile</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h6 class="text-dark text-weight-600"><i class="mdi mdi-bullhorn-outline align-middle me-2 mdi-36px text-primary"></i> Untuk melakukan update data silakan masuk ke aplikasi pegawai , klik <a href="https://pegawai.poltradabali.ac.id", target="_blank">Disini</a></h6>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                            <span class="d-block d-sm-none"><i class="fas fa-user-circle"></i></span>
                            <span class="d-none d-sm-block"><i class="fas fa-user-circle align-middle me-2"></i> Profile</span> 
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active" id="home1" role="tabpanel">
                        <div class="user-profile mt-3">
                            <form >
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Foto : </label>
                                            <div class="input-group">
                                                <img id="dataFoto" src="{{ $foto }}" alt="user profile" class="avatar-md rounded-circle" style="border-style: dashed;">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Level : </label>
                                            <div class="input-group">
                                                <input type="text" value="{{ $level }}" class="form-control" disabled>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Nama Lengkap : </label>
                                            <div class="input-group">
                                                <input type="text" value="{{ $nama }}" class="form-control"  disabled>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">UNIT KERJA : </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" value="{{ $unit_kerja }}" disabled>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">NIK : </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" value="{{ $nik }}" disabled>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Email : </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" value="{{ $email }}" disabled>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Telepon : </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" value="{{ $telp }}" disabled>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Alamat : </label>
                                            <div class="input-group">
                                                <textarea class="form-control" cols="50" disabled>{{ $alamat }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection