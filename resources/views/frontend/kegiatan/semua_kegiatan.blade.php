@extends('layouts.frontend')
@section('konten')

@section('title')
    Semua Kegiatan SPM
@stop

@section('css')
    <!-- <style>
        .breadcrumb__wrap {
            background-image:
            linear-gradient(to bottom, rgba(245, 246, 252, 0.52), rgba(13, 71, 161, 0.93)),
            url('{{ asset($profile_app->banner_detail) }}');
            background-position: center;
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
                    <li class="breadcrumb-item active" aria-current="page">Semua Kegiatan</li>
                </ol>
            </nav>
            </b>
        </div>
    </div>

    <div class="row scroll-row" data-scroll-index="5">
        <div class="col-md-12">
            <div class="panel panel-default">
                <!-- <div class="panel-heading">
                    <div class="section-title-heading text-center">
                        <h3 class="wow fadeInDown" data-wow-delay=".3s">SEMUA KEGIATAN</h3>
                    </div>
                </div> -->
                <div class="panel-body wow fadeIn" data-wow-delay=".3s">
                    <!-- Blog-component -->
                    @foreach($data_kegiatan as $kegiatan)
                    <div class="col-md-4">
                        <div class="single-blog-post">
                            <div class="featured-image">
                                <img class="img-responsive" src="{{ asset($kegiatan->foto_kegiatan) }}" alt="gambar-{{ $kegiatan->id }}">
                            </div>
                            <div class="white-box">
                                <div class="text-muted">
                                    <span class="pull-left"><i class="fa fa-calendar fa-fw"></i>
                                    {{ $kegiatan->created_at }}</span>
                                </div>
                                <div class="body-post">
                                    <h3 class="m-t-20 m-b-20">{{ $kegiatan->judul_kegiatan }}</h3>
                                    <p>{!! Str::limit($kegiatan->deskripsi_kegiatan, 150) !!}</p>
                                </div>
                                <div class="footer-post text-right">
                                    <a href="{{ route('detail.kegiatan', $kegiatan->id) }}" class="details button-detail m-t-15">
                                        <i class="mdi mdi-near-me"></i> Selengkapnya
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
                <div class="text-center m-b-20">
                    {{ $data_kegiatan->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>
    </div>
    @include('frontend.konten.providers')
</div>


@include('layouts.footer.frontend_footer')

@endsection