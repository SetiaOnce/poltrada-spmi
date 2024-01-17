@extends('layouts.admin')
@section('konten')

@section('title')
    Admin Manajemen Konten SPM
@stop
<!-- halaman title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Banner</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="ri-home-3-fill"></i></a></a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Manajemen Konten</a></li>
                    <li class="breadcrumb-item active">Banner</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end halaman title -->

<!-- Table -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Halaman Pengaturan Konten Banner</h4>

                    <button onclick="addData()" data-bs-original-title="Tambah Data Baru" data-bs-placement="top" data-bs-toggle="tooltip" class="btn btn-info btn-sm"><i class="ri-add-fill align-middle me-1"></i> Tambah</button>

                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered nowrap datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="table-secondary">
                            <tr>
                                <th>No</th>
                                <th>BANNER</th>
                                <th>STATUS</th>
                                <th>OPSI</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                        </tbody>
                    </table>
                </div>
            
            </div>
        </div>
    </div>
</div>
<!-- End Table -->

@include('rules.admin.banner.modal')

@section('js')
    @include('rules.admin.banner.script');
@stop

@endsection