@extends('layouts.pengelola')
@section('konten')

@section('title')
    Manajemen Hasil SPM
@stop

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Hasil Survey</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="ri-home-3-fill"></i></a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Manajemen Survey</a></li>
                    <li class="breadcrumb-item active">Hasil Survey</li>
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
                    <h4 class="card-title">Halaman Data Hasil Survey</h4>
                    
                    <!-- <button onclick="_addData()" data-bs-original-title="Tambah Data Baru" data-bs-placement="top" data-bs-toggle="tooltip" class="btn btn-info btn-sm"><i class="ri-add-fill align-middle me-1"></i> Tambah</button>  -->
                </div>
                <hr>

                <div class="table-responsive">
                    <table class="table table-bordered datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="table-secondary">
                            <tr>
                                <th>NO</th>
                                <th>JENIS&nbsp;SURVEY</th>
                                <th>NAMA&nbsp;SURVEY</th>
                                <th>TAHUN&nbsp;SURVEY</th>
                                <th>JUMLAH&nbsp;RESPONDEN</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <tr>
                                <td>1</td>
                                <td>Contoh Hasil Survey</td>
                                <td align="center" class="d-sm-flex">
                                    <a href="" class="waves-effect waves-light btn btn-sm btn-success btn-circle me-1" data-bs-original-title="Lihat Data" data-bs-placement="top" data-bs-toggle="tooltip">
                                    <span class="mdi mdi-eye"></span></a>
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
      @include('rules.pengelola.manajemen_survey.hasil_survey.script')
@stop

@endsection