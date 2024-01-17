@extends('layouts.admin')
@section('konten')

@section('title')
    Admin Data SDM SPMI | PTDI-STTD
@stop

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Data SDM</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="ri-home-3-fill"></i></a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Masterisasi</a></li>
                    <li class="breadcrumb-item active">Data Sdm</li>
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
                    <h4 class="card-title">Halaman Data SDM</h4>
                    
                    <button onclick="_sincronisasi()" id="btn-sinkron" data-bs-original-title="Sinkronisasi Data SDM" data-bs-placement="top" data-bs-toggle="tooltip" class="btn btn-success btn-sm"><i class="ri-cast-fill align-middle me-1"></i> Sinkronisasi</button>
                </div>
                <hr>

                <div class="table-responsive">
                    <table class="table table-bordered datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="table-secondary">
                            <tr>
                                <th>NO</th>
                                <th>NAMA</th>
                                <th>ALAMAT</th>
                                <th>EMAIL</th>
                                <th>JENIS&nbsp;KELAMIN</th>
                                <th>TANGGAL&nbsp;LAHIR</th>
                                <th>NO&nbsp;TELEPON</th>
                                <th>FOTO</th>
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
    @include('rules.admin.masterisasi.data_sdm.script');
@stop
@endsection
