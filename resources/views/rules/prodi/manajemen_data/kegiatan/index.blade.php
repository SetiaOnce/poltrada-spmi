@extends('layouts.prodi')
@section('konten')

@section('title')
    Prodi  Kegiatan SPM
@stop

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Data Kegiatan</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="ri-home-3-fill"></i></a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Manajemen Data</a></li>
                    <li class="breadcrumb-item active">Kegiatan</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

@include('rules.prodi.manajemen_data.kegiatan.form')

<div id="card-table" class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Halaman Manajemen Data Kegiatan</h4>
                </div>
                <hr>

                <div class="table-responsive">
                    <table class="table table-bordered datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="table-secondary">
                            <tr>
                                <th>NO</th>
                                <th>JENIS&nbsp;KEGIATAN</th>
                                <th>JUDUL&nbsp;KEGIATAN</th>
                                <th>FOTO&nbsp;KEGIATAN</th>
                                <th>OPSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- <tr>
                                <td>1</td>
                                <td>Contoh Jenis Kegiatan 1</td>
                                <td>Contoh Judul Kegiatan 1</td>
                                <td>Politeknik Transportasi Darat Indonesia-STTD Bersama Pemerintah Kabupaten Majalengka, Prov Jawa Barat melaksanakan Diklat...</td>
                                <td align="center">
                                    <a class="image-popup-vertical-fit" href="{{ asset('img/kegiatan/kegiatan1.jpg') }}"  data-bs-original-title="Lihat Foto" data-bs-placement="top" data-bs-toggle="tooltip">
                                        <img src="{{ asset('img/kegiatan/kegiatan1.jpg') }}" alt="avatar-4" class="avatar-md" width="140">
                                    </a>
                                </td>
                                <td align="center" class="d-sm-flex">
                                    <button onclick="_viewData(1)" class="waves-effect waves-light btn btn-sm btn-success btn-circle me-1" data-bs-original-title="Lihat Data" data-bs-placement="top" data-bs-toggle="tooltip">
                                    <span class="mdi mdi-eye"></span></button>
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
    @include('rules.prodi.manajemen_data.kegiatan.script')
@stop

@endsection