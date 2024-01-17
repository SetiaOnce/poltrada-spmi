@extends('layouts.frontend')
@section('konten')

@section('title')
Produk SPM
@stop

@include('frontend.konten.banner')

<div class="container-fluid">

    <div class="row" style="margin-top: 10px;">
        <div class="col-md-12">
            <b>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" data-toggle="tooltip" data-placement="right" title="Anda Akan Diarahkan Ke Halaman Beranda" style="color: #1C82AD;">Beranda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Produk</li>
                </ol>
            </nav>
            </b>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="panel-group" id="accordion">

                @foreach($data_jenis_produk as $jenis_produk)
                @php
                    $data_sub_produk = App\Models\SubJenisProduk::latest()->where('jenis_produk_id', $jenis_produk->id)->get();
                    $id = App\Models\DataJenisProduk::latest()->first()->id;
                    if($jenis_produk->id == $id){
                        $in = 'in';
                    }else{
                        $in = '';
                    }
                @endphp
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5 class="panel-title">
                            <span data-toggle="collapse" data-parent="#accordion" style="cursor: pointer;" href="#collapse{{ $jenis_produk->id }}" data-placement="left" title="Klik Untuk Lihat Detail"><strong style="font-size:13px;">{{ strtoupper($jenis_produk->nama_jenis_produk) }}</strong></span>

                            <!-- <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $jenis_produk->id }}"><strong style="font-size:13px;">{{ strtoupper($jenis_produk->nama_jenis_produk) }}</strong></a> -->
                        </h5>
                    </div>
                    <div id="collapse{{ $jenis_produk->id }}" class="panel-collapse collapse {{ $in }}">
                        <div class="panel-body">
                            <div class="panel-group" id="accordions">
                                @foreach($data_sub_produk as $sub_produk)
                                @php
                                    $data_produk = App\Models\ManajemenProduk::latest()->where('sub_jenis_produk_id', $sub_produk->id)->get();
                                @endphp
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <span data-toggle="collapse" data-parent="#accordions" style="cursor: pointer;" href="#collapse{{ $sub_produk->id }}{{ $sub_produk->id }}{{ $sub_produk->id }}" data-placement="top" title="Klik Untuk Lihat Detail"><strong style="font-size:13px;">{{ strtoupper($sub_produk->sub_jenis_produk) }}</strong></span>

                                            <!-- <a data-toggle="collapse" data-parent="#accordions" href="#collapse{{ $sub_produk->id }}{{ $sub_produk->id }}"><strong style="font-size:13px;">{{ strtoupper($sub_produk->sub_jenis_produk) }}</strong></a> -->
                                        </h4>
                                    </div>
                                    <div id="collapse{{ $sub_produk->id }}{{ $sub_produk->id }}{{ $sub_produk->id }}" class="panel-collapse collapse ">
                                        <div class="panel-body">
                                            
                                            <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover color-table inverse-table" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center"><strong>NO.</strong></th>
                                                            <th><strong>NAMA PRODUK</strong></th>
                                                            <th class="text-center"><strong></strong> FILE</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($data_produk as $no => $produk)
                                                        <tr>
                                                            <td class="text-center"><strong>{{ $no+1 }}</strong></td>
                                                            <td><strong>{{ $produk->nama_produk }}</strong></td>
                                                            <td align="center">
                                                                <a href="{{ asset($produk->file_pdf) }}" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" title="Lihat Pdf" target="_blank">
                                                                    LIHAT PDF
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        @endforeach
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
                @endforeach

            </div>
        </div>
    </div>
    @include('frontend.konten.providers')
</div>

@include('layouts.footer.frontend_footer')
@section('js')

    @include('frontend.produk.script');
@stop

@endsection