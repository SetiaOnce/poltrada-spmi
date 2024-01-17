@extends('layouts.prodi')
@section('konten')

@section('title')
    Pengajuan Audit SPMI | PTDI-STTD
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
            <h4 class="mb-sm-0 ">Pengajuan Audit</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="ri-home-3-fill"></i></a></li>
                    <li class="breadcrumb-item active">Pengajuan Audit</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<!-- end page title -->
<div class="alert alert-primary alert-dismissible fade show d-flex align-items-center" role="alert">
    <i class="mdi mdi-bullhorn-outline me-4 fs-1"></i>
    <div class="description fw-bolder">
        *Untuk melakukan pengimputan permohonan audit click tombol tambah.
        <br>
		*Jika permohonan telah berhasil diinput selanjutnya upload dokumen pendukung nya.
        <br>
        *Click tombol ajukan jika permohonan sudah lengkap.	
        <br>
        *History Pengajuan dapat dimonitoring jika permohonan sudah diajukan.	
    </div>
</div>

@include('rules.prodi.pengajuan_audit.detail')
@include('rules.prodi.pengajuan_audit.form')
@include('rules.prodi.pengajuan_audit.modal')

<div id="card-table" class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Halaman Manajemen Data Pengajuan Audit</h4>
                    
                    <button onclick="_addData()" data-bs-original-title="Tambah Data Baru" data-bs-placement="top" data-bs-toggle="tooltip" class="btn btn-info btn-sm"><i class="ri-add-fill align-middle me-1"></i> Tambah</button>
                </div>
                <hr>

                <div class="table-responsive">
                    <table class="table table-bordered nowrap datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="table-secondary">
                            <tr>
                                <th>NO</th>
                                <th>TAHUN</th>
                                <th>NAMA&nbsp;LEMBAGA</th>
                                <th>JENIS&nbsp;STANDAR MUTU</th>
                                <th>TANGGAL&nbsp;INPUT</th>
                                <th>STATUS</th>
                                <th>#</th>
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
      @include('rules.prodi.pengajuan_audit.script')
@stop

@endsection