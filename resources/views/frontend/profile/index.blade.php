@extends('layouts.frontend')
@section('konten')

@section('title')
Profile SPM 
@stop

@section('css')
<!-- <style>
.visi-misi{
    text-align: justify;
    font-family: Inter, sans-serif;
}

.visi-misi p{
    text-align: justify;
    font-family: Inter, sans-serif;
}

.visi-misi ol li{
    font-family: Inter, sans-serif;
}
.breadcrumb__wrap {
    background-image:
    linear-gradient(to bottom, rgba(245, 246, 252, 0.52), rgba(13, 71, 161, 0.93)),
    url('{{ asset($profile_app->banner_detail) }}');
    background-position: center;
    /* background-image: url('img/STTD.jpg');  */
}
</style> -->
@stop


@include('frontend.konten.banner')
<div class="container-fluid">

<div class="row" style="margin-top: 10px;">
    <div class="col-md-12">
        <b>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" data-toggle="tooltip" data-placement="right" title="Anda Akan Diarahkan Ke Halaman Beranda">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </nav>
        </b>
    </div>
</div>

<div class="row scroll-row">
    <div class="col-md-12">
        <div class="panel panel-default">

            <div class="panel-body">
                <ul class="nav nav-pills m-b-30 ">
                    <li class="active"> 
                        <a href="#navpills-1" data-toggle="tab" aria-expanded="false">
                            <i class="mdi mdi-bookmark-multiple"></i> VISI MISI</a> 
                    </li>
                    <li class="">
                        <a href="#navpills-2" id="list-legalitas" data-toggle="tab" aria-expanded="false">
                        <i class="mdi mdi-book-education"></i> FUNGSI & TUGAS
                        </a> 
                    </li>
                    <li> 
                        <a href="#navpills-3" data-toggle="tab" aria-expanded="true">
                            <i class="mdi mdi-clipboard-account-outline"></i> STRUKTUR ORGANISASI
                        </a> 
                    </li>
                </ul>
                <div class="tab-content br-n pn wow fadeIn" data-wow-delay=".3s">
                    <div id="navpills-1" class="tab-pane active">
                        <div class="row">
                            <div class="col-md-12" >
                                <h3 class="m-b-10 m-t-0 box-title"></h3>
                                <p class="m-b-0 m-t-0 visi-misi">
                                    {!! $profile_spmi->visi_misi !!}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div id="navpills-2" class="tab-pane">
                        <div class="row">
                            <div class="col-md-12">
                                <!-- <h3 class="m-b-15 m-t-0 box-title">FUNGSI DAN TUGAS</h3> -->
                                <p class="m-b-0 m-t-0 visi-misi">
                                    {!! $profile_spmi->fungsi_tugas !!}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div id="navpills-3" class="tab-pane">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-sm-12 m-b-30 col-sm-offset-0">
                                    <img src="{{ asset($profile_spmi->struktur_organisasi) }}" class="img-responsive img-rounded" width="100%"/>
                                    <div class="card visi-misi">
                                        <div class="alert alert-primary" role="alert">
                                            <p>{{ $profile_spmi->deskrip_struktur }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('frontend.konten.providers')
</div>

@include('layouts.footer.frontend_footer')

@endsection
