@php
    $logo = App\Models\ProfileApp::find(1)->first(['logo_header_panjang', 'logo_header_kecil']);
@endphp

<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex">
            <!-- LOGO -->
            <div class="navbar-brand-box">
                <a href="javascript: void(0);" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{ asset($logo->logo_header_kecil) }}" alt="logo-sm-light" height="28">
                    </span>
                    <span class="logo-lg">
                        <img src="{{ asset($logo->logo_header_panjang) }}" alt="logo-light" height="30">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="ri-menu-2-line align-middle"></i>
            </button>

        </div>

        <div class="d-flex">

            <div class="dropdown d-none d-lg-inline-block ms-1">
                <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                    <i class="ri-fullscreen-line"></i>
                </button>
            </div>

            <div class="dropdown d-inline-block user-dropdown">
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{ session()->get('foto') }}"
                        alt="UserProfile">
                    <span class="d-none d-xl-inline-block ms-1">{{ session()->get('nama') }}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{ url('profile') }}"><i class="ri-user-line align-middle me-1"></i> Profile</a>
                    <a class="dropdown-item" href="{{ route('pengelola.download.manual.book') }}" data-bs-original-title="Download Manual Book" data-bs-placement="left" data-bs-toggle="tooltip"><i class="mdi mdi-download align-middle me-1"></i> Manual Book</a>

                    <a  class="dropdown-item text-danger" href="{{ url('logout') }}"><i class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>    
                </div>
            </div>

        </div>
    </div>
</header>