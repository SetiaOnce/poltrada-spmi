@extends('layouts.pengelola')
@section('konten')

@section('title')
    Standar Mutu SPM
@stop

@section('css')
    <style>
        select[readonly]
        {
            pointer-events: none;
        }
    </style>
@stop
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <a href="javascript:history.go(-1);" id="btn-kembali" class="btn btn-danger btn-sm waves-effect" data-bs-original-title="Kembali Ke Manajemen Jenis Standar Mutu" data-bs-placement="top" data-bs-toggle="tooltip"><i class="ri-delete-back-2-fill align-middle"></i> Kembali</a>

            <div class="page-title-right" style="float: right;">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="ri-home-3-fill"></i></a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Manajemen Mutu</a></li>
                    <li class="breadcrumb-item active">Nama Standar Mutu</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

@include('rules.pengelola.manajemen_mutu.standar_mutu.form.nama_standar_form')

<div id="card-table" class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Halaman Manajemen Nama Standar Mutu</h4>
                    
                    <button onclick="_addData()" data-bs-original-title="Tambah Data Baru" data-bs-placement="top" data-bs-toggle="tooltip" class="btn btn-info btn-sm"><i class="ri-add-fill align-middle me-1"></i> Tambah</button>
                </div>
                <hr>

                <div class="table-responsive">
                    <table class="table table-bordered datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="table-secondary">
                            <tr class="text-center">
                                <th style="width: 50px;">NO</th>
                                <th>LEMBAGA AKREDITASI</th>
                                <th>JENIS&nbsp;STANDAR MUTU</th>
                                <th>NAMA&nbsp;STANDAR MUTU</th>
                                <th>BOBOT&nbsp;NILAI</th>
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
    @include('rules.pengelola.manajemen_mutu.standar_mutu.script.nama_standar_script')
@stop

@endsection