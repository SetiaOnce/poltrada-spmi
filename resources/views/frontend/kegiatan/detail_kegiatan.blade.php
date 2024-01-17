@extends('layouts.frontend')
@section('konten')

@section('title')
    DETAIL KEGIATAN SPM
@stop

@section('css')
    <style>
        .breadcrumb__wrap {
            background-image:
            linear-gradient(to bottom, rgba(245, 246, 252, 0.52), rgba(13, 71, 161, 0.93)),
            url('{{ asset($profile_app->banner_detail) }}');
            background-position: center;
        }
    </style>
@stop

@include('frontend.konten.banner')

<div class="container-fluid">

<div class="row" style="margin-top: 10px;">
    <div class="col-md-12">
        <b>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" data-toggle="tooltip" data-placement="right" title="Anda Akan Diarahkan Ke Halaman Beranda">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('semua.kegiatan') }}" data-toggle="tooltip" data-placement="right" title="Anda Akan Diarahkan Ke Halaman Semua Kegiatan">Kegiatan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail Kegiatan</li>
            </ol>
        </nav>
        </b>
    </div>
</div>

<div class="row"data-scroll-index="5">
    <!-- .col -->
    <div class="col-sm-12 col-sm-offset-0">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="title-text-post">{{ $detail_kegiatan->judul_kegiatan }}</h3>
                <div class="text-muted text-center" style="font-weight: normal;">
                    <small class="m-r-15" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Dipublikasi pada {{ $detail_kegiatan->created_at }}">
                        <i class="fa fa-calendar fa-fw"></i> {{ $detail_kegiatan->created_at }}
                    </small>
                    <small class="m-r-15" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Telah dilihat sebanyak 100x">
                        <i class="fa fa-eye fa-fw"></i> {{ $detail_kegiatan->view }}x dilihat
                    </small>
                </div>
            </div>
            <div class="panel-wrapper collapse in">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-10 m-b-30 col-sm-offset-1">
                            <img src="{{ asset($detail_kegiatan->foto_kegiatan) }}" class="img-responsive img-rounded" width="600%"/>
                        </div>
                        <div class="col-sm-12">
                            <p style="text-align: justify;">
                            {!! $detail_kegiatan->deskripsi_kegiatan !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <div class="row">
                    <div class="col-sm-2 m-t-15 wow fadeIn" data-wow-delay=".5s">        
                        <a href="javascript:history.go(-1);" class="btn btn-block btn-outline btn-danger"><i class="mdi mdi-backspace-outline"></i> Kembali</a>
                    </div>
                    <div class="col-sm-6 m-b-15 wow fadeIn" data-wow-delay=".5s">
                        <span style="display: block;" class="m-b-5"><b>Share : </b></span>

                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('detail.kegiatan', $detail_kegiatan->id) }}" class="btn btn-facebook waves-effect btn-sm waves-light btn-share" social="facebook" target="_blank">
                            <i class="fa fa-facebook"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?text={{ route('detail.kegiatan', $detail_kegiatan->id) }}" class="btn btn-twitter waves-effect btn-sm waves-light btn-share" social="twitter" target="_blank">
                            <i class="fa fa-twitter"></i>
                        </a>
                        <a href="https://wa.me/?text={{ route('detail.kegiatan', $detail_kegiatan->id) }}" class="btn btn-success waves-effect btn-sm waves-light btn-share" social="whatsapp" target="_blank">
                            <i class="mdi mdi-whatsapp" style="line-height: 0px;"></i>
                        </a>
                        <a href="https://www.instagram.com/ptdi.sttd.official?u={{ route('detail.kegiatan', $detail_kegiatan->id) }}" class="btn btn-danger waves-effect btn-sm waves-light btn-share" social="whatsapp" target="_blank">
                            <i class="mdi mdi-instagram" style="line-height: 0px;"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-10 col-sm-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="title-text-post text-muted" style="font-size: 17px;">Kegiatan Lainnya</h3>
            </div>
            <div class="panel-wrapper collapse in">
           
            <div id="kegiatan-lainnya" class="owl-carousel owl-theme owl-theme-post">

                    @foreach($semua_kegiatan as $row)
                    <div class="item active">
                        <div class="kegiatan-lain">
                            <div class="featured-image2">
                                <img class="img-responsive" src="{{ asset($row->foto_kegiatan) }}" alt="gambar-1">
                            </div>
                            <div class="white-box">
                                <div class="text-muted">
                                    <h5>{{ Str::limit($row->judul_kegiatan, 20) }}<a href="{{ route('detail.kegiatan', $row->id) }}">Selengkapnya</a></h5>
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

@include('frontend.konten.providers')

</div>

@include('layouts.footer.frontend_footer')

@endsection