@extends('layouts.pengelola')
@section('konten')

@section('title')
    Pengelola Lembaga Akreditasi SPM
@stop

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Data Lembaga Akreditasi</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="ri-home-3-fill"></i></a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Masterisasi</a></li>
                    <li class="breadcrumb-item active">Data Lembaga Akreditasi</li>
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
                    <h4 class="card-title">Halaman Data Lembaga Akreditasi</h4>
                    
                    <button onclick="_addData()" data-bs-original-title="Tambah Data Baru" data-bs-placement="top" data-bs-toggle="tooltip" class="btn btn-info btn-sm"><i class="ri-add-fill align-middle me-1"></i> Tambah</button>
                </div>
                <hr>

                <div class="table-responsive">
                    <table class="table table-bordered datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="table-secondary">
                            <tr>
                                <th class="text-center">NO</th>
                                <th class="text-center">NAMA LEMBAGA</th>
                                <th class="text-center">ALAMAT</th>
                                <th class="text-center">OPSI</th>
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

@include('rules.pengelola.masterisasi.data_lembaga_akreditasi.modal')

@section('js')
    @include('rules.pengelola.masterisasi.data_lembaga_akreditasi.script');
@stop

@endsection