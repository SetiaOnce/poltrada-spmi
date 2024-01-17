@extends('layouts.admin')
@section('konten')

@section('title')
    Admin Jenis Survey SPM
@stop

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Data Jenis Survey</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="ri-home-3-fill"></i></a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Masterisasi</a></li>
                    <li class="breadcrumb-item active">Data Jenis Survey</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div id="card-table" class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Halaman Data Jenis Survey</h4>
                    
                    <button onclick="_addData()" data-bs-original-title="Tambah Data Baru" data-bs-placement="top" data-bs-toggle="tooltip" class="btn btn-info btn-sm"><i class="ri-add-fill align-middle me-1"></i> Tambah</button>
                </div>
                <hr>

                <div class="table-responsive">
                    <table class="table table-bordered datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="table-secondary">
                            <tr>
                                <th>NO</th>
                                <th>NAMA JENIS SURVEY</th>
                                <th>KETERANGAN</th>
                                <th>GAMBAR</th>
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

@include('rules.admin.masterisasi.data_jenis_survey.modal')

@section('js')
    @include('rules.admin.masterisasi.data_jenis_survey.script');
@stop

@endsection