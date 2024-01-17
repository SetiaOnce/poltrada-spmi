@extends('layouts.pengelola')
@section('konten')

@section('title')
    Data Auditor SPM
@stop
@section('css')
    <style>
        select[readonly]
        {
            pointer-events: none;
        }
    </style>
@stop

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <a href="javascript:history.go(-1);" id="btn-kembali" class="btn btn-danger btn-sm waves-effect" data-bs-original-title="Kembali Ke Periode Evaluasi" data-bs-placement="top" data-bs-toggle="tooltip"><i class="ri-delete-back-2-fill align-middle"></i> Kembali</a>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="ri-home-3-fill"></i></a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Manajemen Mutu</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Periode Evaluasi</a></li>
                    <li class="breadcrumb-item active">Auditor</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div id="card-detail" class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="fw-bolder d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title"> Detail Periode Evaluasi </h4>
                </div>
                <dl class="row mb-0">
                    <dt class="col-sm-2"><strong>Tahun</strong></dt>
                    <dd class="col-sm-10">: {{ $periode_evaluasi->tahun_evaluasi }}</dd>

                    <dt class="col-sm-2"><strong>Nama Lembaga</strong></dt>
                    <dd class="col-sm-10">: {{ $periode_evaluasi->nama_lembaga }}</dd>

                    <dt class="col-sm-2"><strong>Jenis Standar Mutu</strong></dt>
                    <dd class="col-sm-10">: {{ $periode_evaluasi->jenis_standar_mutu }}</dd>

                    <dt class="col-sm-2"><strong>Periode Evaluasi</strong></dt>
                    <dd class="col-sm-10">: {{ $periode_awal }} - {{ $periode_akhir }}</dd>
                </dl>
            
            </div>
        </div>
    </div>
</div>
@include('rules.pengelola.manajemen_mutu.periode_evaluasi.asesor.form')

<div id="card-table" class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Halaman Manajemen Data Auditor</h4>
                    
                    <button onclick="_addData()" data-bs-original-title="Tambah Data Baru" data-bs-placement="top" data-bs-toggle="tooltip" class="btn btn-info btn-sm"><i class="ri-add-fill align-middle me-1"></i> Tambah</button>
                </div>
                <hr>

                <div class="table-responsive">
                    <table class="table table-bordered datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="table-secondary">
                            <tr>
                                <th>NO</th>
                                <th>JENIS&nbsp;STANDAR MUTU</th>
                                <th>NAMA&nbsp;AUDITOR</th>
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
    @include('rules.pengelola.manajemen_mutu.periode_evaluasi.asesor.script')
@stop

@endsection