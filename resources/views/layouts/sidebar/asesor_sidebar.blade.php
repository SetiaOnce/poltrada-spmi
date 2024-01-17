<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- sidebar -->
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ url('/asesor_dashboard') }}" class="waves-effect">
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
                        <li><a href="{{ route('asesor.porduk.index') }}">Produk</a></li>
                        <li><a href="{{ route('asesor.peraturan.index') }}">Peraturan</a></li>
                        <li><a href="{{ route('asesor.kegiatan.index') }}">Kegiatan</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('asesor.target.nilai.mutu.index') }}" class="waves-effect">
                        <i class="ri-honour-fill"></i>
                        <span>Target Nilai Mutu</span>
                    </a>
                </li>

                {{-- <li>
                    <a href="{{ route('asesor.periode.evaluasi.index') }}" class="waves-effect">
                        <i class="ri-keyboard-box-fill"></i>
                        <span>Periode Evaluasi</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('asesor.evaluasi.audit') }}" class="waves-effect">
                        <i class="ri-edit-box-fill"></i>
                        <span>Evaluasi Pengajuan Audit</span>
                    </a>
                </li> --}}
                

            </ul>
        </div>
        <!-- End Sidebar -->
    </div>
</div>