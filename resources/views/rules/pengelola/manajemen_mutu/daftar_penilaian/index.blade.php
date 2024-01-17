@extends('layouts.pengelola')
@section('konten')

@section('title')
    Daftar Penilaian SPM
@stop

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Data Daftar Penilaian</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="ri-home-3-fill"></i></a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Manajemen Mutu</a></li>
                    <li class="breadcrumb-item active">Daftar Penilaian</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

@include('rules.pengelola.manajemen_mutu.daftar_penilaian.form')

<div id="card-table" class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Halaman Manajemen Daftar Penilaian</h4>
                    
                    <button onclick="_addData()" data-bs-original-title="Tambah Data Baru" data-bs-placement="top" data-bs-toggle="tooltip" class="btn btn-info btn-sm"><i class="ri-add-fill align-middle me-1"></i> Tambah</button>
                </div>
                <hr>

                <div class="table-responsive">
                    <table class="table table-bordered nowrap datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="table-secondary">
                            <tr>
                                <th>NO</th>
                                <th>TAHUN</th>
                                <th>LEMABAGA&nbsp;AKREDITASI</th>
                                <th>NILAI&nbsp;MUTU</th>
                                <th>KETERANGAN</th>
                                <th>OPSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <tr>
                                <td>2017</td>
                                <td>Contoh Lemabaga Akreditasi 1</td>
                                <td>Contoh Nilai Mutu 1</td>
                                <td align="center">100</td>
                                <td>Politeknik Transportasi Darat Indonesia-STTD Bersama Pemerintah Kabupaten Majalengka, Prov Jawa Barat melaksanakan Diklat...</td>
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
    @include('rules.pengelola.manajemen_mutu.daftar_penilaian.script')
@stop

@endsection