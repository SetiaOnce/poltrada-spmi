@php
    $logo = App\Models\ProfileApp::find(1)->first(['logo_header_panjang', 'logo_header_kecil']);

    $data_inbox = App\Models\Inbox::select(
        'spm_inbox.id',
        'spm_inbox.pengajuan_id',
        'spm_inbox.is_read',
        'spm_inbox.created_at',
        'group_unit_kerja.unit_kerja',
        'spm_daftar_standar_mutu.tahun',
        'spm_data_lembaga_akreditasi.nama_lembaga',
        'spm_jenis_standar_mutu.jenis_standar_mutu',
    )
    ->join("group_unit_kerja", "group_unit_kerja.id", "=" , "spm_inbox.unit_prodi_id")
    ->join("spm_pengajuan_audit", "spm_pengajuan_audit.id", "=" , "spm_inbox.pengajuan_id")
    ->join("group_pegawai", "group_pegawai.id", "=" , "spm_inbox.user_id")
    ->join("spm_jenis_standar_mutu", "spm_jenis_standar_mutu.id", "=" , "spm_pengajuan_audit.jenis_standar_mutu_id")
    ->join("spm_daftar_standar_mutu", "spm_daftar_standar_mutu.id", "=" , "spm_jenis_standar_mutu.daftar_standar_mutu_id")
    ->join("spm_data_lembaga_akreditasi", "spm_data_lembaga_akreditasi.id", "=" , "spm_daftar_standar_mutu.lembaga_akreditasi_id")
    ->where("spm_inbox.user_id", session()->get('pegawaiId'))
    ->orderBy('spm_inbox.is_read', 'ASC')
    ->orderBy('spm_inbox.created_at', 'DESC')
    ->get();

    $data_dot = App\Models\Inbox::Where('user_id', session()->get('pegawaiId'))->where('is_read', 0)->first();
@endphp
<style>
    .color-backgorund{
        background: #E9F8F9
    }
</style>

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
            <div class="dropdown d-inline-block">
                <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="ri-notification-3-line"></i>
                    @if(!is_null($data_dot))
                    <span class="noti-dot"></span>
                    @endif
                </button>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                    aria-labelledby="page-header-notifications-dropdown">
                    <div class="p-3">
                        <div class="row align-items-center">
                            <div class="col">
                                <h6 class="m-0"> Notifikasi </h6>
                            </div>
                        </div>
                    </div>
                    <div data-simplebar style="max-height: 230px;">
                        @foreach($data_inbox as $inbox)
                        @php
                            if($inbox->is_read == 0){
                                $color = 'color-backgorund';
                            }else{
                                $color = '';
                            }
                        @endphp
                        <a href="javascript:void(0)" onclick="_statusChance('{{ $inbox->id }}')" class="text-reset notification-item">
                            <div class="d-flex {{ $color }}">
                                <div class="flex-1">
                                    <h6 class="mb-1"> {{ $inbox->unit_kerja }}</h6>
                                    <div class="font-size-12 text-muted">
                                        <p class="mb-1">{{ $inbox->tahun }} | {{ $inbox->nama_lembaga }} | {{ $inbox->jenis_standar_mutu }}</p>
                                        <p class="mb-0"><i class="mdi mdi-clock-outline align-middle me-1"></i>{{ Carbon\Carbon::parse($inbox->created_at)->format('d M Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach
                        @if(empty($inbox))
                            <div class="alert alert-warning" role="alert">
                                <p>Belum Ada Pengajuan Masuk...</p>
                            </div>
                        @endif
                        
                    </div>
                    <div class="p-2 border-top">
                        <div class="d-grid">
                        @if(empty($inbox))
                        @else
                        <a class="btn btn-sm btn-link font-size-14 text-center" onclick="_lihatSemua()" href="javascript:void(0)">
                                <i class="mdi mdi-arrow-right-circle me-1"></i> Lihat Semua..
                            </a>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
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

<script type="text/javascript">
    function _statusChance(data_id){
        var url = '{{ route("pengelola.status.inbox.change", ":data_id") }}';
            url = url.replace(':data_id', data_id);
        $.ajax({
            url: url,
            type: "GET",
            dataType: "JSON",
            cache: false,
            success:function(response){
                if (response.success) {
                    window.location.href = "{{ route('pengelola.pengajuan.audit.index') }}"
                }
            },error:function(response){
                Swal.fire({
                    icon:'warning',
                    title: 'Opps!',
                    text: 'server error!'
                });
            }
        });
    }

    function _lihatSemua(){
        $.ajax({
            url: '{{ route("pengelola.inbox.lihat.semua") }}',
            type: "GET",
            dataType: "JSON",
            cache: false,
            success:function(response){
                if (response.success) {
                    window.location.href = "{{ route('pengelola.pengajuan.audit.index') }}"
                }
            },error:function(response){
                Swal.fire({
                    icon:'warning',
                    title: 'Opps!',
                    text: 'server error!'
                });
            }

        });
    }
</script>