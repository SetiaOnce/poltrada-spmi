@extends('layouts.frontend')
@section('konten')

@section('title')
Akreditasi SPM
@stop

@include('frontend.konten.banner')

<div class="container-fluid">

  <div class="row" style="margin-top: 10px;">
    <div class="col-md-12">
      <b>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" data-toggle="tooltip" data-placement="right" title="Anda Akan Diarahkan Ke Halaman Beranda" style="color: #1C82AD;">Beranda</a></li>
            <li class="breadcrumb-item active" aria-current="page">Akreditasi</li>
          </ol>
        </nav>
      </b>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="panel-group" id="accordion">
        @foreach ($data_jenis_akreditasi as $jenisakreditasi)
          @php
              $dataAkreditasi = App\Models\DataAkreditasi::where('fid_jenis_akreditasi', $jenisakreditasi->id)->orderBy('tahun', 'DESC')->get();
              $id = App\Models\DataJenisAkreditasi::orderBy('nama_jenis_akreditasi', 'ASC')->first()->id;
              if($jenisakreditasi->id == $id){
                  $in = 'in';
              }else{
                  $in = '';
              }
          @endphp
          <div class="panel panel-default">
              <div class="panel-heading">
              <h5 class="panel-title" style="cursor: pointer;" href="#collapse{{ $jenisakreditasi->id }}">
                  <span data-toggle="collapse" data-parent="#accordion" style="cursor: pointer;" href="#collapse{{ $jenisakreditasi->id }}" data-placement="top" title="Klik Untuk Lihat Detail"><strong style="font-size:13px;">{{ strtoupper($jenisakreditasi->nama_jenis_akreditasi) }}</strong></span>
              </h5>
              </div>
              <div id="collapse{{ $jenisakreditasi->id }}" class="panel-collapse collapse {{ $in }}">
                  <div class="panel-body">
                  {{-- Tahun --}}
                  <div class="panel-group" id="accordions">
                      @foreach ($dataAkreditasi as $akreditasi)     
                        @php
                        $dataLkps = App\Models\FileAkreditasi::orderBy('id', 'DESC')->whereFidAkreditasi($akreditasi->id)->whereIsLkps(1)->get();
                        $dataLed = App\Models\FileAkreditasi::orderBy('id', 'DESC')->whereFidAkreditasi($akreditasi->id)->whereIsLed(1)->get();
                        $dataInstrumen = App\Models\FileAkreditasi::orderBy('id', 'DESC')->whereFidAkreditasi($akreditasi->id)->whereIsInstrumenAkreditasi(1)->get();
                        @endphp               
                        <div class="panel panel-default">
                            <div class="panel-heading">
                              <h5 class="panel-title" style="cursor: pointer;" href="#collapsetahun{{ $akreditasi->id }}">
                                  <span data-toggle="collapse" data-parent="#accordions" style="cursor: pointer;" href="#collapsetahun{{ $akreditasi->id }}" data-placement="top" title="Klik Untuk Lihat Detail"><strong style="font-size:13px;">FILE AKREDITASI TAHUN {{ strtoupper($akreditasi->tahun) }}</strong></span>
                              </h5>
                            </div>
                            <div id="collapsetahun{{ $akreditasi->id }}" class="panel-collapse collapse">
                                <div class="panel-body">
                                  <div style="padding: 5px;">
                                      <div class="row justify-content-center">
                                          <div class="col-md-2">
                                              <strong>Jenis Akreditasi</strong>
                                          </div>
                                          <div class="col-md-10">
                                              <p class="fw-bold"><span class="fw-bolder mr-2">: {{ $akreditasi->jenisakreditasi->nama_jenis_akreditasi }}</span></p>
                                          </div>
                                      </div>
                                      <div class="row justify-content-center" >
                                          <div class="col-md-2">
                                          <strong>Dasar Akreditasi</strong>
                                          </div>
                                          <div class="col-md-10">
                                              <p class="fw-bold"><span class="fw-bolder mr-2">: {{ $akreditasi->dasar_kegiatan }}</span></p>
                                          </div>
                                      </div>
                                      <div class="row justify-content-center">
                                          <div class="col-md-2">
                                              <strong>Timeline Akreditasi</strong>
                                          </div>
                                          <div class="col-md-10">
                                          <p class="fw-bold"><span class="fw-bolder mr-2"><a href="{{ asset('pdf/data-akreditasi/'.$akreditasi->timeline_akreditasi) }}" title="Lihat File Timeline Akreitasi" class="btn btn-danger btn-sm" target="_blank">File Timeline Akreditasi</a></span></p>
                                          </div>
                                      </div>
                                      <div class="row justify-content-center">
                                          <div class="col-md-2">
                                              <strong>Data LKPS</strong>
                                          </div>
                                          <div class="col-md-10">
                                          @foreach ($dataLkps as $lkps)
                                              <p class="fw-bold"><span class="fw-bolder mr-2"><a href="{{ asset('pdf/data-akreditasi/'.$lkps->file) }}" title="{{ $lkps->nama_file }}"  target="_blank">{{ $lkps->nama_file }}</a></span></p>
                                          @endforeach
                                          @if (count($dataLkps) < 1)
                                              <p class="fw-bold"><span class="fw-bolder mr-2 text-danger"> : <i>Masih kosongg...</i></span></p>
                                          @endif
                                          </div>
                                      </div>
                                      <div class="row justify-content-center">
                                          <div class="col-md-2">
                                              <strong>Data LED</strong>
                                          </div>
                                          <div class="col-md-10">
                                          @foreach ($dataLed as $led)
                                              <p class="fw-bold"><span class="fw-bolder mr-2"><a href="{{ asset('pdf/data-akreditasi/'.$led->file) }}" title="{{ $lkps->nama_file }}"  target="_blank">{{ $lkps->nama_file }}</a></span></p>
                                          @endforeach
                                          @if (count($dataLed) < 1)
                                              <p class="fw-bold"><span class="fw-bolder mr-2 text-danger"> : <i>Masih kosongg...</i></span></p>
                                          @endif
                                          </div>
                                      </div>
                                      <div class="row justify-content-center">
                                          <div class="col-md-2">
                                              <strong>Instrumen Akreditasi</strong>
                                          </div>
                                          <div class="col-md-10">
                                          @foreach ($dataInstrumen as $instrumen)
                                              <p class="fw-bold"><span class="fw-bolder mr-2"><a href="{{ asset('pdf/data-akreditasi/'.$instrumen->file) }}" title="{{ $instrumen->nama_file }}" target="_blank">{{ $instrumen->nama_file }}</a></span></p>
                                          @endforeach
                                          @if (count($dataInstrumen) < 1)
                                              <p class="fw-bold"><span class="fw-bolder mr-2 text-danger"> : <i>Masih kosongg...</i></span></p>
                                          @endif
                                          </div>
                                      </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                      @endforeach
                      @if (count($dataAkreditasi) < 1)
                          <p class="fw-bold"><span class="fw-bolder mr-2 text-danger"><i>Data Akreditasi Masih kosongg...</i></span></p>
                      @endif
                  </div>

                  </div>
              </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>

@include('frontend.konten.providers')
</div>

@include('layouts.footer.frontend_footer')

@section('js')
@include('frontend.akreditasi.script');
@stop

@endsection