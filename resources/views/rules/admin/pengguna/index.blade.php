@php
    $logo = App\Models\ProfileApp::find(1)->first(['logo_header_panjang', 'logo_header_kecil', 'logo_aplikasi']);
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Manajemen Konten SPMI | PTDI-STTD</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset($logo->logo_aplikasi) }}">
    <link href="{{ asset('new_backend/assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('new_backend/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('new_backend/assets/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
    <!-- DataTables -->
    <link href="{{ asset('new_backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('new_backend/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('new_backend/assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{ asset('new_backend/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />  
    <link href="{{ asset('new_backend/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet">
    <!-- Bootstrap Css -->
    <link href="{{ asset('new_backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('new_backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('new_backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body data-topbar="dark">

<!-- <body data-layout="horizontal" data-topbar="dark"> -->

<!-- Begin page -->
<div id="layout-wrapper">


    <!-- Header -->
    @include('layouts.header.admin_header')
    <!-- End Header -->

    <!-- Sidebar -->
    @include('layouts.sidebar.admin_sidebar')
    <!-- End Sidebar -->



<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <!-- halaman title -->
            <!-- <div class="row">
                <div class="col-12">
                <form id="form-data" class="form" onsubmit="return false">
                    @csrf
                    <input type="hidden" name="id" readonly> 
					<input type="hidden" name="methodform_data" readonly>
                    <div class="row mb-3">
                        <label class="form-label">Level : </label>
                        <div class="input-group">
                            <select name="level" id="level" class="form-select" aria-label="Default select example">
                                <option selected="" value="disable">-- Pilih Level Pengguna --</option>
                                <option value="1">ADMINISTRATOR</option>
                                <option value="2">PENGELOLA</option>
                                <option value="3">PRODI</option>
                                <option value="4">ASESOR</option>
                            </select>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Nama : </label>
                        <div class="input-group">
                            <select class="form-control select2">
                                <option selected="" value="disable">-- Pilih Level Pengguna --</option>
                                @foreach($data_nama_sdm as $row)
                                    <option value="{{ $row->id }}">{{ $row->dataNama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi!</span>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Email : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="email" name="email" class="form-control" id="email" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">No Whatsapp : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" name="no_whatsapp" class="form-control" id="no_whatsapp" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Alamat : <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <textarea required="" name="alamat" id="alamat" class="form-control" rows="5" readonly></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="form-label">Foto : </label>
                        <input type="hidden" name="foto" class="form-control" id="foto" readonly>
                        <div class="input-group">
                            <img id="showImage" src="{{ asset('new_backend/assets/images/users/avatar-4.jpg') }}" alt="avatar-4" class="rounded-circle avatar-md">
                        </div>
                    </div>
                    <div class="row mb-3">
                     <label class="form-label">Password : </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text lihat-password" onclick="showPassword()"><i class="mdi mdi-eye"></i></span>
                            </div>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan password..." autocomplete="off">
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi! | Minimal <span class="text-danger">6</span> Karakter</span>
                    </div>
                    <div class="row mb-3">
                     <label class="form-label">Konfirmasi Password : </label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text lihat-password" onclick="showPassword2()"><i class="mdi mdi-eye"></i></span>
                            </div>
                            <input type="password" class="form-control" name="konfirmasi_password" id="konfirmasi_password" placeholder="Masukkan konfirmasi password..." autocomplete="off">
                        </div>
                        <span class="text-mute" style="font-size:12px;"><span class="text-danger">*)</span> Harus diisi! </span>
                    </div>
                    <div class="mt-3" style="float: right;">
                        <button onclick="_closeForm()" class="btn btn-danger btn-sm waves-effect" type="button"><i class="ri-delete-back-2-fill align-middle"></i> Kembali</button>
                        <button id="btn-save" class="btn btn-primary btn-sm waves-effect" type="submit"><i class="ri-save-fill align-middle"></i> Simpan</button>
                    </div>
                </form>
                </div>
            </div> -->

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Pengguna</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="ri-home-3-fill"></i></a></a></li>
                                <li class="breadcrumb-item active">Pengguna</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end halaman title -->

            <!-- Pengunna -->
            <div id="card-table" class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class=" d-sm-flex align-items-center justify-content-between">
                                <h4 class="card-title">Halaman Pengaturan Data Pengguna</h4>
                                
                                <button onclick="_addData()" data-bs-original-title="Tambah Data Baru" data-bs-placement="top" data-bs-toggle="tooltip" class="btn btn-info btn-sm"><i class="ri-add-fill align-middle me-1"></i> Tambah</button>
                            </div>
                            <hr>

                            <div class="table-responsive">
                                <table>
                                    <table class="table table-bordered nowrap datatable" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th>NO</th>
                                                <th>NAMA</th>
                                                <th>LEVEL</th>
                                                <th>EMAIL</th>
                                                <th>NO.WHATSAPP</th>
                                                <th>FOTO</th>
                                                <th>OPSI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </table>
                            </div>
                        
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Pengunna -->

            @include('rules.admin.pengguna.modal')

        </div> <!-- container-fluid -->
    </div>

    <!-- footer -->
    @include('layouts.footer.admin_footer')
    <!-- end footer -->
</div>
<!-- end main content-->

</div>
<!-- END layout-wrapper -->


<!-- JAVASCRIPT -->
<script src="{{ asset('new_backend/assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('new_backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('new_backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('new_backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('new_backend/assets/libs/node-waves/waves.min.js') }}"></script>

<script src="{{ asset('new_backend/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<!-- jquery.vectormap map -->
<script src="{{ asset('new_backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('new_backend/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}"></script>
<!-- Required datatable js -->
<script src="{{ asset('new_backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('new_backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- Datatable init js -->
<script src="{{ asset('new_backend/assets/js/pages/datatables.init.js') }}"></script>
<!-- Responsive examples -->
<script src="{{ asset('new_backend/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('new_backend/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('new_backend/assets/js/pages/dashboard.init.js') }}"></script>
<!-- Validate -->
<script src="{{ asset('new_backend/assets/js/validate.min.js') }}"></script>
<!-- Alert -->
<script src="{{ asset('new_backend/assets/js/alert.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- custom js -->
<script src="{{ asset('new_backend/assets/js/custom.js') }}"></script>
<!-- Sweet Alert -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<!-- toastr plugin -->
<script src="{{ asset('new_backend/assets/libs/toastr/build/toastr.min.js') }}"></script>
<!-- toastr init -->
<script src="{{ asset('new_backend/assets/js/pages/toastr.init.js') }}"></script>
<script src="{{ asset('new_backend/assets/libs/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('new_backend/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('new_backend/assets/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
<script src="{{ asset('new_backend/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
<script src="{{ asset('new_backend/assets/libs/admin-resources/bootstrap-filestyle/bootstrap-filestyle.min.js') }}"></script>
<script src="{{ asset('new_backend/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>

<script src="{{ asset('new_backend/assets/js/pages/form-advanced.init.js') }}"></script>

<script src="{{ asset('new_backend/assets/js/app.js') }}"></script>
<script>
    toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": 300,
    "hideDuration": 1000,
    "timeOut": 5000,
    "extendedTimeOut": 1000,
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
    }
</script>

@include('rules.admin.pengguna.script');
</body>
</html>
