@extends('layouts.pengelola')
@section('konten')

@section('title')
    Standar Mutu SPM
@stop
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Daftar Standar Mutu</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="ri-home-3-fill"></i></a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Manajemen Mutu</a></li>
                    <li class="breadcrumb-item active">Daftar Standar Mutu</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
<div class="alert alert-primary alert-dismissible fade show d-flex align-items-center" role="alert">
    <i class="mdi mdi-bullhorn-outline me-2 fs-1"></i>
    <div class="description fw-bolder">
        *Untuk melakukan menambahan data daftar standar mutu silahkan click tombol tambah.
        <br>
        *Untuk mendata Jenis Standar Mutu yang ada pada standar mutu click tombol tambah yang ada pada list.
    </div>
</div>
@include('rules.pengelola.manajemen_mutu.standar_mutu.form.daftar_standar_form')

<div id="card-table" class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Halaman Manajemen Daftar Standar Mutu</h4>
                    
                    <button onclick="_addData()" data-bs-original-title="Tambah Data Baru" data-bs-placement="top" data-bs-toggle="tooltip" class="btn btn-info btn-sm"><i class="ri-add-fill align-middle me-1"></i> Tambah</button>
                </div>
                <hr>

                <div class="table-responsive">
                    <table class="table table-bordered datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="table-secondary">
                            <tr class="text-center">
                                <th>NO</th>
                                <th>TAHUN</th>
                                <th>LEMBAGA&nbsp;AKREDITASI</th>
                                <th>UNIT/PRODI</th>
                                <th>NAMA&nbsp;STANDAR</th>
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

@section('js')
    @include('rules.pengelola.manajemen_mutu.standar_mutu.script.daftar_standar_script')
@stop

@endsection