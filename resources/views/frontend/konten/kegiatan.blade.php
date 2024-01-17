<div class="row scroll-row" style="margin-top: 10px;">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="section-title-heading text-center">
                    <h3 class="wow fadeInDown" data-wow-delay=".3s">KEGIATAN</h3>
                </div>
            </div>
            <div class="panel-body wow fadeIn" data-wow-delay=".3s">

                <!-- sliders konten -->
                <div id="kegiatan-carousel" class="owl-carousel owl-theme owl-theme-post">
                    
                    @foreach($data_kegiatan as $kegiatan)
                    <div class="item">
                        <div class="single-blog-post">
                            <div class="featured-image">
                                <img class="img-responsive" src="{{ asset($kegiatan->foto_kegiatan) }}" alt="gambar-1">
                            </div>
                            <div class="white-box">
                                <div class="text-muted">
                                    <span class="pull-left"><i class="fa fa-calendar fa-fw"></i>{{ $kegiatan->created_at }}</span>
                                </div>
                                <div class="body-post">
                                    <h3 class="m-t-20 m-b-20">{{ Str::limit($kegiatan->judul_kegiatan, 70) }}</h3>
                                    <p>{!! Str::limit($kegiatan->deskripsi_kegiatan, 200) !!}</p>
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
                    <!-- <div class="item">
                        <div class="single-blog-post">
                            <div class="featured-image">
                                <img class="img-responsive" src="{{ asset('img/kegiatan/kegiatan2.jpg') }}" alt="gambar-1">
                            </div>
                            <div class="white-box">
                                <div class="text-muted">
                                    <span class="pull-left"><i class="fa fa-calendar fa-fw"></i>
                                        20 MEI 2022 13:30:05</span>
                                </div>
                                <div class="body-post">
                                    <h3 class="m-t-20 m-b-20">Pelaksanaan Apel Pagi Taruna/i Angkatan XLII PTDI-STTD</h3>
                                    <p>Pelaksanaan Apel Pagi Taruna/i Angkatan XLII yang pimpin langsung oleh Direktur PTDI-STTD, Bapak Ahmad Yani, ATD. MT.</p>
                                </div>
                                <div class="footer-post text-right">
                                    <a href="{{ route('detail.kegiatan', 'Penandatangan-kerjasama-antara-PTDI-STTD-dengan-Kabupaten-Jember-jawa-timur') }}"
                                        class="details button-detail m-t-15">
                                        <i class="mdi mdi-near-me"></i> Selengkapnya
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="single-blog-post">
                            <div class="featured-image">
                                <img class="img-responsive" src="{{ asset('img/kegiatan/kegiatan3.jpg') }}" alt="gambar-1">
                            </div>
                            <div class="white-box">
                                <div class="text-muted">
                                    <span class="pull-left"><i class="fa fa-calendar fa-fw"></i>
                                        30 JUNI 2022 07:06:32</span>
                                </div>
                                <div class="body-post">
                                    <h3 class="m-t-20 m-b-20">Kegiatan Pekan Ilmiah Perguruan Tinggi Kedinasan (PIPTK) Tahun 2022</h3>
                                    <p>Dalam rangka memeriahkan kegiatan rutin tahunan Pekan Ilmiah Perguruan Tinggi Kedinasan (PIPTK) salah satu kegiatannya adalah....</p>
                                </div>
                                <div class="footer-post text-right">
                                    <a href="{{ route('detail.kegiatan', 'Penandatangan-kerjasama-antara-PTDI-STTD-dengan-Kabupaten-Jember-jawa-timur') }}"
                                        class="details button-detail m-t-15">
                                        <i class="mdi mdi-near-me"></i> Selengkapnya
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="single-blog-post">
                            <div class="featured-image">
                                <img class="img-responsive" src="{{ asset('img/kegiatan/kegiatan4.jpg') }}" alt="gambar-1">
                            </div>
                            <div class="white-box">
                                <div class="text-muted">
                                    <span class="pull-left"><i class="fa fa-calendar fa-fw"></i>
                                    10 APRIL 2022 20:42:53</span>
                                </div>
                                <div class="body-post">
                                    <h3 class="m-t-20 m-b-20">Nota Kesepahaman Bersama antara PTDI - STTD dengan PT. Celebes Railway Indonesia</h3>
                                    <p>Dalam implementasi Tri Dharma Perguruan Tinggi, telah dilakukan Penandatanganan Nota Kesepahaman Bersama antara....</p>
                                </div>
                                <div class="footer-post text-right">
                                    <a href="{{ route('detail.kegiatan', 'Penandatangan-kerjasama-antara-PTDI-STTD-dengan-Kabupaten-Jember-jawa-timur') }}"
                                        class="details button-detail m-t-15">
                                        <i class="mdi mdi-near-me"></i> Selengkapnya
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div> -->

                </div>
                <!-- end sliders konten -->
                
                <!-- button -->
                <div class="text-center">
                    <a href="{{ route('semua.kegiatan') }}" class="button button-5"
                        title="Lihat Semua Kegiatan Pelayanan">
                        <i class="mdi mdi-layers fa-fw"></i> Lihat Semua Kegiatan
                    </a>
                </div>
                <!-- end button -->

            </div>
        </div>
    </div>
</div>