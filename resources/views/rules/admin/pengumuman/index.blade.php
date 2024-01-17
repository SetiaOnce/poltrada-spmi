@extends('layouts.admin')
@section('konten')

@section('title')
    Admin Manajemen Konten SPM
@stop
<!-- halaman title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Pengumuman</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="ri-home-3-fill"></i></a></a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Manajemen Konten</a></li>
                    <li class="breadcrumb-item active">Pengumuman</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end halaman title -->

<!-- Profile Pengumuman -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Halaman Pengaturan Pengumuman</h4>
                </div>
                <hr>

                <div class="table-responsive">
                    <table  class="table table-bordered datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="table-secondary">
                            <tr>
                                <th>NO</th>
                                <th>FOTO&nbsp;PENGUMUMAN</th>
                                <th>KETERANGAN</th>
                                <th>STATUS</th>
                                <th>#</th>
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
<!-- End Pengumuman -->

@include('rules.admin.pengumuman.modal')

@section('js')
    @include('rules.admin.pengumuman.script')
@stop

@endsection