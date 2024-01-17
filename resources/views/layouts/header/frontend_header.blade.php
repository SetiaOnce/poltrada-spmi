@php
    $route = Route::current()->getName();
    $logo = App\Models\ProfileApp::find(1)->first(['logo_header_panjang', 'logo_header_kecil']);
@endphp

<nav class="navbar navbar-default navbar-static-top m-b-0 visible-xs">
    <div class="navbar-header">
        <div class="top-left-part">
            <a class="logo" href="javascript: void(0);">
                <b><img src="{{ asset($logo->logo_header_panjang) }}" alt="home" class="light-logo" /></b>
            </a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li>
                <a href="javascript:void(0)" class="open-close waves-effect waves-light visible-xs">
                    <i class="mdi mdi-menu"></i>
                </a>
            </li>
        </ul>
    </div>
</nav>

<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav">
        <div class="">
            <div class="top-left-part hidden-xs" style="margin-left: 50px;">
                <a class="logo" href="javascript: void(0);">
                    <b><img src="{{ asset($logo->logo_header_panjang) }}" alt="home" class="light-logo" style="height:40px !important;" /></b>
                </a>
            </div>
            <div class="sidebar-head">
                <h3><span class="fa-fw open-close">
                    <i class="ti-menu hidden-xs"></i><i class="mdi mdi-close visible-xs"></i></span> <span class="hide-menu">MENU</span>
                </h3>
            </div>
            <ul class="nav" id="side-menu">

                <li class="list-nav">
                    <a href="{{ route('home') }}" class="waves-effect {{ ($route == 'home')? 'activee' : '' }}" style="align-items: center; font-size: 13px; display:flex; color:#fff;">
                        <i class="mdi mdi-home" data-icon="v"></i> <span class="hide-menu"> BERANDA </span>
                    </a>
                </li>

                <li class="list-nav">
                    
                    <a href="{{ url('profilespmi') }}" class="waves-effect {{ ($route == 'profilespmi')? 'activee' : '' }}" style="align-items: center; font-size: 13px; display:flex;">
                        <i class="mdi mdi-information-variant" data-icon="v"></i> <span class="hide-menu"> PROFILE SPMI</span>
                    </a>
                    
                </li>
                
                <li class="list-nav">
                    <a href="{{ route('semua.kegiatan') }}" class="waves-effect {{ ($route == 'semua.kegiatan')? 'activee' : '' }}{{ ($route == 'detail.kegiatan')? 'activee' : '' }}" style="align-items: center; font-size: 13px; display:flex;">
                        <i class="mdi mdi-calendar-month" data-icon="v"></i> <span class="hide-menu"> KEGIATAN</span>
                    </a>
                </li>

                <li class="list-nav">
                    <a href="{{ route('produk.index') }}"  class="waves-effect {{ ($route == 'produk.index')? 'activee' : '' }}" style="align-items: center; font-size: 13px; display:flex;">
                        <i class="mdi mdi-layers" data-icon="v"></i> <span class="hide-menu"> PRODUK</span>
                    </a>
                </li>

                <li class="list-nav">
                    <a href="{{ route('akreditasi.index') }}" class="waves-effect {{ ($route == 'akreditasi.index')? 'activee' : '' }}" style="align-items: center; font-size: 13px; display:flex;">
                        <i class="mdi mdi-inbox-full" data-icon="v"></i> <span class="hide-menu"> AKREDITASI</span>
                    </a>
                    <!-- <ul class="nav nav-second-level">
                        <li class="list-nav">
                            <a href="">
                                <i class="mdi mdi-checkbox-multiple-marked-circle-outline fa-fw"></i><span class="hide-menu">Penerimaan Taruna</span>
                            </a> 
                        </li>
                        <li class="list-nav">
                            <a href="">
                                <i class="mdi mdi-checkbox-multiple-marked-circle-outline fa-fw"></i><span class="hide-menu">Pelaks.Perkuliahan</span>
                            </a> 
                        </li>
                    </ul> -->
                </li>

                <li class="list-nav">
                    <a href="{{ route('survey.index') }}"  class="waves-effect {{ ($route == 'survey.index')? 'activee' : '' }}" style="align-items: center; font-size: 13px; display:flex; color:#fff;">
                        <i class="mdi mdi-chat-processing-outline" data-icon="v"></i> <span class="hide-menu"> SURVEY</span>
                    </a>
                </li>
                
                <li class="list-nav">
                    <a href="{{ url('auth_login') }}" class="waves-effect" style="align-items: center; font-size: 13px; display:flex;">
                        @auth
                        <i class="mdi mdi-login" data-icon="v"></i> <span class="hide-menu"> Dashboard</span>
                        @else
                        <i class="mdi mdi-login" data-icon="v"></i> <span class="hide-menu"> Login</span>
                        @endauth
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>