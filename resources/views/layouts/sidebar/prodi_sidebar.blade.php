<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidebar -->
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>
                <li>
                    <a href="{{ url('/prodi_dashboard') }}" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-animation"></i>
                        <span>Manajemen Data</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{ route('prodi.porduk.index') }}">Produk</a></li>
                        <li><a href="{{ route('prodi.peraturan.index') }}">Peraturan</a></li>
                        <li><a href="{{ route('prodi.kegiatan.index') }}">Kegiatan</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('prodi.porduk.nilai.mutu.index') }}" class="waves-effect">
                        <i class="ri-honour-fill"></i>
                        <span>Target Nilai Mutu</span>
                    </a>
                </li>

                {{-- <li>
                    <a href="{{ route('prodi.periode.evaluasi.index') }}" class="waves-effect">
                        <i class="ri-keyboard-box-fill"></i>
                        <span>Periode Evaluasi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('prodi.pengajuan.audit.index') }}" class="waves-effect">
                        <i class="mdi mdi-arrange-send-backward"></i>
                        <span>Pengajuan Audit</span>
                    </a>
                </li> --}}
            </ul>
        </div>
        <!-- End Sidebar -->
    </div>
</div>