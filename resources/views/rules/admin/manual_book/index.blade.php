@extends('layouts.admin')
@section('konten')

@section('title')
    Admin Manual Book SPM
@stop

<!-- start page title -->
<!-- halaman title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Manual Book</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="ri-home-3-fill"></i></a></a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Manajemen Konten</a></li>
                    <li class="breadcrumb-item active">Manual Book</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end halaman title -->

<div id="card-table" class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Halaman Manajemen Data Manual Book</h4>
                    
                    <button onclick="_addData()" data-bs-original-title="Tambah Data Baru" data-bs-placement="top" data-bs-toggle="tooltip" class="btn btn-info btn-sm"><i class="ri-add-fill align-middle me-1"></i> Tambah</button>
                </div>
                <hr>

                <div class="table-responsive">
                    <table class="table table-bordered nowrap datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="table-secondary">
                            <tr>
                                <th>NO</th>
                                <th>FILE MANUAL</th>
                                <th>LEVEL</th>
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

@include('rules.admin.manual_book.modal')

@section('js')
    @include('rules.admin.manual_book.script')
@stop

@endsection