<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li>
                    <a href="{{ url('/admin_dashboard') }}" class="waves-effect">
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
                        <li><a href="{{ route('data-unit-prodi.index') }}">Data Unit & Prodi</a></li>
                        <li><a href="{{ route('data-jenis-produk.index') }}">Data Jenis Produk</a></li>
                        {{-- <li><a href="{{ route('data-jenis-peraturan.index') }}">Data Jenis Peraturan</a></li> --}}
                        <li><a href="{{ route('data-jenis-survey.index') }}">Data Jenis Survey</a></li>
                        <li><a href="{{ route('data-jenis-kegiatan.index') }}">Data Jenis Kegiatan</a></li>
                        <li><a href="{{ route('data-lembaga-akreditasi.index') }}">Data Lembaga Akreditasi</a></li>
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

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>