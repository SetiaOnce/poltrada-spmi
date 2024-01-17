@extends('layouts.asesor')
@section('konten')

@section('title')
    Periode Evaluasi SPM
@stop

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Periode Evaluasi</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="ri-home-3-fill"></i></a></li>
                    <li class="breadcrumb-item active">Periode Evaluasi</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
@include('rules.asesor.periode_evaluasi.modal')
<div id="card-table" class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">Halaman Periode Evaluasi</h4>
                </div>
                <hr>
                <div class=" d-sm-flex align-items-center mb-3 justify-content-between">
                    <div class="col-md-2 ">
                        <span class="me-3"></span>
                    </div>
                    <div class="col-md-2 ">
                        <span class="me-3"></span>
                    </div>
                    <div class="col-md-2 ">
                        <span class="me-3"></span>
                    </div>
                    <div class="col-md-2 ">
                        <span class="me-3"></span>
                    </div>
                    <span class="">Filter Data: </span>
                    <div class="col-md-3 d-sm-flex align-items-center">
                        <div class="input-group" id="datepicker5">
                            <input type="text" name="filter_tahun" id="filter_tahun" class="form-control form-control-sm" data-provide="datepicker" data-date-container='#datepicker5'data-date-format="yyyy" data-date-min-view-mode="2" data-date-autoclose="true" placeholder="Filter Tahun..." autocomplete="off">
                            <span class="input-group-text" data-bs-original-title="Reset" data-bs-placement="top" data-bs-toggle="tooltip" onclick="_resetFilter()" style="cursor: pointer;"><i class="fa fas fa-undo-alt"></i></span>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="table-secondary">
                            <tr>
                                <th class="text-center" style="font-size: 13px;">NO</th>
                                <th class="text-center" style="font-size: 13px;">#</th>
                                <th class="text-center" style="font-size: 13px;">TAHUN</th>
                                <th class="text-center" style="font-size: 13px;">NAMA LEMBAGA</th>
                                <th class="text-center" style="font-size: 13px;">NAMA STANDAR MUTU</th>
                                <th class="text-center" style="font-size: 13px;">JENIS STANDAR MUTU</th>
                                <th class="text-center" style="font-size: 13px;">PERIODE EVALUASI DIRI AWAL</th>
                                <th class="text-center" style="font-size: 13px;">PERIODE EVALUASI DIRI AKHIR</th>
                                <th class="text-center" style="font-size: 13px;">PERIODE VISITASI AWAL</th>
                                <th class="text-center" style="font-size: 13px;">PERIODE VISITASI AKHIR</th>
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
    @include('rules.asesor.periode_evaluasi.script')
@stop

@endsection