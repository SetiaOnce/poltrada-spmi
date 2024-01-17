@extends('layouts.pengelola')
@section('konten')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.0.0/css/fileinput.css" integrity="sha512-ubJcKQg3y4hBwwFsQ8Feb3trEnWF3qhFD77O1/iUHMHA5VoGCfbiA3KQ9/JLOCO33CTocPvyLGnVUG4T3PlqLQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@stop
@section('title')
    Standar Mutu SPM
@stop
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Data Akreditasi</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="ri-home-3-fill"></i></a></li>
                    <li class="breadcrumb-item active">Data Akreditasi</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->
@include('rules.pengelola.data_akreditasi.form')

<div id="card-table" class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Halaman Manajemen Data Akreditasi</h4>
                    <button onclick="_addData()" data-bs-original-title="Tambah Data Baru" data-bs-placement="top" data-bs-toggle="tooltip" class="btn btn-info btn-sm"><i class="ri-add-fill align-middle me-1"></i> Tambah</button>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="table-secondary">
                            <tr class="text-center">
                                <th>NO</th>
                                <th>JENIS AKREDITASI</th>
                                <th>TAHUN</th>
                                <th>DASAR KEGIATAN</th>
                                <th>TIMELINE</th>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.0.0/js/fileinput.min.js" integrity="sha512-z/EXjm2wtdHB91wQ8xQfNwpGFxkV+Umn0mwXZ3YjF5/Zy1LDzG8m4pnwuk/OEaP+nNOAW0My2Y18DP5+GHCNGQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js" integrity="sha512-yDlE7vpGDP7o2eftkCiPZ+yuUyEcaBwoJoIhdXv71KZWugFqEphIS3PU60lEkFaz8RxaVsMpSvQxMBaKVwA5xg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @include('rules.pengelola.data_akreditasi.script')
@stop

@endsection