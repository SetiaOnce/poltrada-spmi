<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!--- Sidebar -->
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ url('/pengelola_dashboard') }}" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-stack-fill"></i>
                        <span>Masterisasi</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('pengelola-data-unit-prodi.index') }}">Data Unit & Prodi</a></li>
                        <li><a href="{{ route('pengelola-data-jenis-produk.index') }}">Data Jenis Produk</a></li>
                        {{-- <li><a href="{{ route('pengelola-data-jenis-peraturan.index') }}">Data Jenis Peraturan</a></li> --}}
                        <li><a href="{{ route('pengelola-data-jenis-survey.index') }}">Data Jenis Survey</a></li>
                        <li><a href="{{ route('pengelola-data-jenis-akreditasi.index') }}">Data Jenis Akreditasi</a></li>
                        <li><a href="{{ route('pengelola-lembaga-akreditasi.index') }}">Data Lembaga Akreditasi</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-layout-2-fill"></i>
                        <span>Manajemen Konten</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('banner.index') }}">Banner</a></li>
                        <li><a href="{{ route('profile-spmi.index') }}">Profile SPMI</a></li>
                        <li><a href="{{ route('profile-app.index') }}">Profile App</a></li>
                        <li><a href="{{ route('link-app.index') }}">Link App</a></li>
                        <li><a href="{{ route('pengumuman.index') }}">Pengumuman</a></li>
                        <li><a href="{{ route('manual-book.index') }}">Manual Book</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-animation"></i>
                        <span>Manajemen Data</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('pengelola.produk.index') }}">Produk</a></li>
                        <li><a href="{{ route('pengelola.statusakreditasi.index') }}">Status Akreditasi</a></li>
                        <li><a href="{{ route('pengelola.kegiatan.index') }}">Kegiatan</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('data-akreditasi.index') }}" class="waves-effect">
                        <i class="ri-layout-2-fill"></i>
                        <span>Data Akreditasi</span>
                    </a>
                </li>
                
                {{-- <li>
                    <a href="{{ route('periode-evaluasi.index') }}" class="waves-effect">
                        <i class="ri-keyboard-box-fill"></i>
                        <span>Periode Evaluasi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pengelola.pengajuan.audit.index') }}" class="waves-effect">
                        <i class="ri-layout-2-fill"></i>
                        <span>Pengajuan Audit</span>
                    </a>
                </li> --}}
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="ri-bar-chart-line"></i>
                        <span>Manajemen Survey</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('link-survey-external.index') }}">Link Survey External</a></li>
                        <li><a href="{{ route('jenis-sruvey.index') }}">Nama Survey</a></li>
                        {{-- <li><a href="{{ route('pertanyaan-survey.index') }}">Pertanyaan Survey</a></li> --}}
                        <li><a href="{{ route('even-survey.index') }}">Even Survey</a></li>
                        <li><a href="{{ route('hasil-survey.index') }}">Hasil Survey</a></li>
                    </ul>
                </li>

                <!-- <li>
                    <a id="logout" href="javascript:void(0);" class="waves-effect text-danger">
                        <i class="ri-shut-down-line text-danger"></i>
                        <span>Logout</span>
                    </a>
                </li> -->

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>