@extends('layouts.prodi')
@section('konten')

@section('title')
    Prodi Dashboard SPMI | PTDI-STTD
@stop
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Dashboard</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Prodi</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<!-- begin row -->
<div class="row">
    <div class="col-xl-12 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row d-flex justify-content-between">
                    <div class="col-md-2">
                        <img src="{{ session()->get('foto') }}" alt="" class="avatar-lg rounded">
                    </div>
                    <div class="col-md-10">
                        <div class="row justify-content-center" >
                            <div class="col-md-2">
                                <span class="fw-bolder">Nama Lengkap</span>
                            </div>
                            <div class="col-md-10">
                                <p class="fw-bold"><span class="fw-bolder mr-2">: </span>{{ session()->get('nama') }}</p>
                            </div>
                        </div>
                        <div class="row justify-content-center" style="margin-top: -15px">
                            <div class="col-md-2">
                                <span class="fw-bolder">NIK</span>
                            </div>
                            <div class="col-md-10">
                                <p class="fw-bold"><span class="fw-bolder mr-2">: </span>{{ session()->get('nik') }}</p>
                            </div>
                        </div>
                        <div class="row justify-content-center" style="margin-top: -15px">
                            <div class="col-md-2">
                                <span class="fw-bolder">Alamat</span>
                            </div>
                            <div class="col-md-10">
                                <p class="fw-bold"><span class="fw-bolder mr-2">: </span>{{ session()->get('alamat') }}</p>
                            </div>
                        </div>
                        <div class="row justify-content-center" style="margin-top: -15px">
                            <div class="col-md-2">
                                <span class="fw-bolder">Email</span>
                            </div>
                            <div class="col-md-10">
                                <p class="fw-bold"><span class="fw-bolder mr-2">: </span> {{ session()->get('email') }}</p>
                            </div>
                        </div>
                        <div class="row justify-content-center" style="margin-top: -15px">
                            <div class="col-md-2">
                                <span class="fw-bolder">Telepon</span>
                            </div>
                            <div class="col-md-10">
                                <p class="fw-bold"><span class="fw-bolder mr-2">: </span>{{ session()->get('telp') }}</p>
                            </div>
                        </div>
                        <div class="row justify-content-center" style="margin-top: -15px">
                            <div class="col-md-2">
                                <span class="fw-bolder">Unit Kerja</span>
                            </div>
                            <div class="col-md-10">
                                <p class="fw-bold"><span class="fw-bolder mr-2">: </span>{{ session()->get('unit_kerja') }}</p>
                            </div>
                        </div>
                    </div>
                </div>                                     
            </div>
        </div>
    </div>
</div>
<!-- end row -->

<!-- begin row -->
<div class="row">
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Jumlah Produk</p>
                        <h4 class="mb-2">{{ $jumlah_produk }}</h4>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light text-info rounded-3">
                            <i class="mdi mdi-layers font-size-24"></i>  
                        </span>
                    </div>
                </div>                                              
            </div><!-- end cardbody -->
        </div><!-- end card -->
    </div><!-- end col -->
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Jumlah Peraturan</p>
                        <h4 class="mb-2">{{ $jumlah_peraturan }}</h4>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light text-success rounded-3">
                            <i class="mdi mdi-inbox-full font-size-24"></i>  
                        </span>
                    </div>
                </div>                                              
            </div><!-- end cardbody -->
        </div><!-- end card -->
    </div><!-- end col -->
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <p class="text-truncate font-size-14 mb-2">Jumlah Kegiatan</p>
                        <h4 class="mb-2">{{ $jumlah_kegiatan }}</h4>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-light text-info rounded-3">
                            <i class="mdi mdi-calendar-month font-size-24"></i>  
                        </span>
                    </div>
                </div>                                              
            </div><!-- end cardbody -->
        </div><!-- end card -->
    </div><!-- end col -->
</div>
<!-- end row -->

{{-- <div class="row">
    <div class="col-sm-12">
        <div class="card"> 
            <div class="card-body">
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
                    <span class="">Filter Trend: </span>
                    <div class="col-md-3 d-sm-flex align-items-center">
                        <div class="input-group" id="datepicker5">
                            <input type="text" name="filter_tahun" id="filter_tahun" class="form-control form-control-sm" data-provide="datepicker" data-date-container='#datepicker5'data-date-format="yyyy" data-date-min-view-mode="2" data-date-autoclose="true" placeholder="Filter Tahun..." autocomplete="off">
                        </div>
                    </div>
                </div> 
                <div style="cursor: pointer;" id="chart-trend-audit"></div>
            </div>
        </div>
    </div> 
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">LAPORAN HASIL SURVEY</h4>
                <hr>
                <div id="accordion" class="custom-accordion">
                @foreach($data_nama_survey as $nama_survey)
                    <div class="card mb-1 shadow-none">
                        <a href="#collapse{{ $nama_survey->id }}" onclick="_pieChart('{{ $nama_survey->id }}')" class="text-dark" data-bs-toggle="collapse"aria-expanded="false" aria-controls="collapse{{ $nama_survey->id }}">
                            <div class="card-header" id="heading{{ $nama_survey->id }}">
                                <h6 class="m-0">{{ $nama_survey->nama_jenis_survey }} | {{ $nama_survey->tahun_survey }} | {{ $nama_survey->nama_survey }}
                                    <i class="mdi mdi-minus float-end accor-plus-icon"></i>
                                </h6>
                            </div>
                        </a>
                        @php
                        $jml_responden =  \DB::table('spm_data_hasil_survey')
                        ->where('id_nama_survey', $nama_survey->id)
                        ->groupBy('email')
                        ->get()
                        ->count();
                        @endphp

                        <div id="collapse{{ $nama_survey->id }}" class="collapse" aria-labelledby="heading{{ $nama_survey->id }}" data-bs-parent="#accordion">
                            <div class="card-body" id="data-laporan-survey{{ $nama_survey->id }}">
                                <ul class="list-unstyled mb-4">
                                    <li>
                                        <ul class="d-sm-flex align-items-center justify-content-between">
                                            <li><mark>Jumlah Responden : (<b class="text-info" id="jmlh_responden{{ $nama_survey->id }}">{{ $jml_responden }}</b>)</mark></li>
                                            <li><mark>Jumlah Responden Laki-Laki : (<b class="text-info" id="jmlh_laki_laki{{ $nama_survey->id }}"></b>)</mark></li>
                                            <li><mark>Jumlah Responden Perempuan : (<b class="text-info" id="jmlh_perempuan{{ $nama_survey->id }}"></b>)</mark></li>
                                        </ul>
                                    </li>
                                </ul>
                                <section id="default-breadcrumb ">
                                    <div class="row text-center">
                                        <div class="col-sm-4">     
                                            <div id="chart-gender{{ $nama_survey->id }}" class="mt-2 mb-1"></div> 
                                        </div>
                                        <div class="col-sm-4">  
                                            <div id="chart-angkatan{{ $nama_survey->id }}" class="mt-2 mb-1"></div> 
                                        </div>
                                        <div class="col-sm-4">  
                                            <div id="chart-prodi{{ $nama_survey->id }}" class="mt-2 mb-1"></div> 
                                        </div>
                                    </div>  
                                </section>
                                <hr>
                                <div class="col-md-3 mb-2">
                                    <a class="no-print btn btn-danger btn-sm" href="javascript:window.print();"><i class="mdi mdi-file-pdf align-middle me-1"></i> PRINT PDF</a>
                                </div>
                                <h4 class="card-title">Pertanyaan Yang Memiliki Jawaban 1-4</h4>
                                <div class="table-responsive">
                                    <table id="table-jawaban-1-4{{ $nama_survey->id }}"  class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead class="table-info">
                                            <tr style="height: 22px;">
                                                <td class="text-center" style="width: 7.21582%; height: 44px; vertical-align: middle; text-align: center;" colspan="2" rowspan="2"><strong>NO</strong></td>
                                                <td class="text-center" style="width: 60%; height: 44px; vertical-align: middle; text-align: center;" rowspan="2"><strong>PERTANYAAN</strong></td>
                                                <td class="text-center" style="height: 22px; width: 40%;" colspan="4"><strong>JAWABAN</strong></td>
                                                <td class="text-center" style="width: 5%; height: 53px; vertical-align: middle; text-align: center;" rowspan="2">JUMLAH</td>
                                                <td class="text-center" style="width: 30%; vertical-align: middle; text-align: center;" rowspan="2">JUMLAH NILAI PER UNSUR</td>
                                                <td class="text-center" style="width: 11%; vertical-align: middle; text-align: center;" rowspan="2">NRR</td>
                                            </tr>
                                            <tr style="height: 22px;">
                                                <td style="text-align: center; width: 5%; height: 22px;"><strong>1</strong></td>
                                                <td style="text-align: center; width: 5%; height: 22px;"><strong>2</strong></td>
                                                <td style="text-align: center; width: 5%; height: 22px;"><strong>3</strong></td>
                                                <td style="text-align: center; width: 5%; height: 22px;"><strong>4</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody id="data-jawaban-1-4{{ $nama_survey->id }}">
                                            
                                        </tbody>
                                    </table>
                                </div>
                                
                                <h4 class="card-title">Pertanyaan Yang Memiliki Jawaban Ya atau Tidak</h4>
                                <div class="table-responsive">
                                    <table id="table-jawaban-ya-tidak{{ $nama_survey->id }}" class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead class="table-info">
                                            <tr style="height: 22px;">
                                            <td style="width: 7.21582%; height: 44px; vertical-align: middle; text-align: center; align-items:center;" colspan="2" rowspan="2"><strong>NO</strong></td>
                                            <td style="width: 60%; height: 44px; vertical-align: middle; text-align: center;" rowspan="2"><strong>PERTANYAAN</strong></td>
                                            <td style="height: 22px; vertical-align: middle; text-align: center; width: 40%;" colspan="2"><strong>JAWABAN</strong></td>
                                            <td style="vertical-align: middle; text-align: center; width: 36.8661%; height: 22px;" colspan="2"><strong>PERSENTASE</strong></td>
                                            </tr>
                                            <tr style="height: 22px;">
                                            <td style="vertical-align: middle; text-align: center; width: 5%; height: 22px;"><strong>Ya</strong></td>
                                            <td style="vertical-align: middle; text-align: center; width: 5%; height: 22px;"><strong>Tidak</strong></td>
                                            <td style="vertical-align: middle; text-align: center; width: 5%; height: 22px;"><strong>Ya</strong></td>
                                            <td style="vertical-align: middle; text-align: center; width: 5%; height: 22px;"><strong>Tidak</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody id="data-persentase-ya-tidak{{ $nama_survey->id }}">
                                        </tbody>
                                    </table>
                                </div>

                                <h4 class="card-title">Jawaban Terhadap Pertanyaan Esai</h4>
                                <div class="table-responsive">
                                    <table id="table-jawaban-esai{{ $nama_survey->id }}" class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead class="table-info">
                                            <tr>
                                                <th style="width: 7.21582%; height: 44px; text-align: center; align-items:center;">NO</th>
                                                <th>JAWABAN</th>
                                            </tr>
                                        </thead>
                                        <tbody id="jawaban-pertanyaan-esai{{ $nama_survey->id }}">

                                        </tbody>
                                    </table>
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
            </div>
        </div>
    </div>
</div>

<!--  Modal Detail -->
<div class="modal fade bs-example-modal-lg" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>PENGJAUAN AUDIT BULAN <span id="headeBulan" class="text-info"></span> TAHUN <span id="headerTahun" class="text-info"></span></strong></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="TableDetailAudit" class="table table-bordered mb-0">
                                <thead class="table-primary">
                                    <tr>
                                        <th class="text-center">NO</th>
                                        <th class="text-center">TAHUN</th>
                                        <th class="text-center">NAMA LEMBAGA</th>
                                        <th class="text-center">JENIS STANDAR <br> MUTU</th>
                                        <th class="text-center">UNIT PRODI</th>
                                        <th class="text-center">STATUS</th>
                                    </tr>
                                </thead>
                                <tbody id="dataDetailAudit">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
               </div>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Detail --> --}}

@section('js')
@include('rules.prodi.script')
@stop
@endsection