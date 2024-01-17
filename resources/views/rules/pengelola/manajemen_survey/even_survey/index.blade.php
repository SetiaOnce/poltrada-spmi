@extends('layouts.pengelola')
@section('konten')

@section('title')
    Manajemen Survey SPM
@stop

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Even Survey</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="ri-home-3-fill"></i></a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Manajemen Survey</a></li>
                    <li class="breadcrumb-item active">Even Survey</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

@include('rules.pengelola.manajemen_survey.even_survey.form')

<div id="card-table" class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Halaman Manajemen Data Even Survey</h4>
                    
                    <button onclick="_addData()" data-bs-original-title="Tambah Data Baru" data-bs-placement="top" data-bs-toggle="tooltip" class="btn btn-info btn-sm"><i class="ri-add-fill align-middle me-1"></i> Tambah</button> 
                </div>
                <hr>

                <div class="table-responsive">
                    <table class="table table-bordered datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="table-secondary">
                            <tr>
                                <th>NO</th>
                                <th>NAMA&nbsp;SURVEY</th>
                                <th>PERIODE&nbsp;EVALUASI DIRI AWAL</th>
                                <th>PERIODE&nbsp;EVALUASI DIRI AKHIR</th>
                                <th>OPSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <tr>
                                <td>1</td>
                                <td>Contoh Nama Survey 1</td>
                                <td>12 FEBRUARI 2023 02:41:43</td>
                                <td>21 FEBRUARI 2023 02:41:43</td>
                                <td align="center" class="d-sm-flex">
                                    <a href="javascript:void(0)" onclick="_editData()" class="waves-effect waves-light btn btn-sm btn-info btn-circle me-1" data-bs-original-title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip">
                                    <span class="mdi mdi-pencil-box-multiple"></span></a>

                                    <a onclick="_deleteData()" href="javascript:void(0)" class="waves-effect waves-light btn btn-sm btn-danger btn-circle" data-bs-original-title="Hapus Data" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-trash-can-outline"></span></a>
                                </td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            
            </div>
        </div>
    </div>
</div>

@section('js')
      @include('rules.pengelola.manajemen_survey.even_survey.script')
@stop

@endsection