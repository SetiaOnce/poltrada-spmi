@extends('layouts.frontend')
@section('konten')

@section('title')
Survey SPM | PTDI-STTD
@stop

@section('css')

@stop

@include('frontend.konten.banner')

<div class="container-fluid">

    <div class="row" style="margin-top: 10px;">
        <div class="col-md-12">
            <b>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" data-toggle="tooltip" data-placement="right" title="Anda Akan Diarahkan Ke Halaman Beranda" style="color: #1C82AD;">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Survey</li>
                </ol>
            </nav>
            </b>
        </div>
    </div>

<div class="row scroll-row">
    <div class="col-md-12">
        <div class="panel panel-default">

            <div class="panel-body"> 
        
                <div class=" d-sm-flex align-items-center" style=" align-items:center; display:flex; margin-bottom:10px; align-items:center;">
                    <h4 class="card-title"><b>
                        @if(!empty($detail_survey))
                            <img style="margin-right: 10px;" src="{{ asset($jenis_survey->gambar) }}" width="50px">  SURVEY {{ strtoupper($jenis_survey->nama_jenis_survey) }}
                        @else
                            BELUM ADA SURVEY YANG DIBUKA
                        @endif
                    </b></h4>
                </div>
                <hr>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-10 m-b-30 col-sm-offset-1">
                                @if(!empty($detail_survey))
                                    @include('frontend.survey.form.form')
                                @else
                                <div class="card">
                                    <div class="alert alert-warning" role="alert">
                                        <p>Saat ini belum ada survey yang dibuka...</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-2 m-t-15 wow fadeIn" data-wow-delay=".5s">        
                        <a href="javascript:history.go(-1);" class="btn btn-block btn-outline btn-danger"><i class="fa fa-arrow-circle-left fa-fw"></i>Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('frontend.konten.providers')
</div>

@include('layouts.footer.frontend_footer')

@section('js')
@include('frontend.survey.script.script')
@endsection

@endsection