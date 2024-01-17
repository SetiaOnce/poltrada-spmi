@extends('layouts.pengelola')
@section('konten')

@section('title')
    Manajemen Survey SPM
@stop

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <a href="javascript:history.go(-1);" id="btn-kembali" class="btn btn-danger btn-sm waves-effect" data-bs-original-title="Kembali Ke Halaman Sebelumnya" data-bs-placement="top" data-bs-toggle="tooltip"><i class="ri-delete-back-2-fill align-middle"></i> Kembali</a>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="ri-home-3-fill"></i></a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Manajemen Survey</a></li>
                    <li class="breadcrumb-item active">Data Pertanyaan Survey</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

@include('rules.pengelola.manajemen_survey.pertanyaan_survey.form')

<div id="card-table" class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Halaman Manajemen Data Pertanyaan Survey</h4>
                    
                    <button onclick="_addData()" data-bs-original-title="Tambah Data Baru" data-bs-placement="top" data-bs-toggle="tooltip" class="btn btn-info btn-sm"><i class="ri-add-fill align-middle me-1"></i> Tambah</button> 
                </div>
                <hr>

                <div class="border rounded border-secondary p-2 border-dashed mb-2">
                    <div class="row justify-content-center">
                        <div class="col-md-2">
                            <strong>Jenis Survey</strong>
                        </div>
                        <div class="col-md-10">
                            <p class="fw-bold"><span class="fw-bolder mr-2">: {{ $namaSurvey->nama_jenis_survey }}</span></p>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-2">
                            <strong>Nama Survey</strong>
                        </div>
                        <div class="col-md-10">
                            <p class="fw-bold"><span class="fw-bolder mr-2">: {{ $namaSurvey->nama_survey }}</span></p>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-2">
                            <strong>Tahun Survey</strong>
                        </div>
                        <div class="col-md-10">
                            <p class="fw-bold"><span class="fw-bolder mr-2">: {{ $namaSurvey->tahun_survey }}</span></p>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="table-secondary">
                            <tr>
                                <th>NO</th>
                                <th>PERTANYAAN&nbsp;SURVEY</th>
                                <th>JENIS</th>
                                <th>OPSI</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            
            </div>
        </div>
    </div>
</div>

@section('js')
      @include('rules.pengelola.manajemen_survey.pertanyaan_survey.script')
@stop

@endsection