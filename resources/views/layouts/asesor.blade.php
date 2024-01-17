@php
    $logo = App\Models\ProfileApp::find(1)->first(['logo_header_panjang', 'logo_header_kecil', 'logo_aplikasi']);
@endphp
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>@yield('title')</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset($logo->logo_aplikasi) }}">

        <!-- jquery.vectormap css -->
        <link href="{{ asset('new_backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />
        <!-- DataTables -->
        <link href="{{ asset('new_backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('new_backend/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('new_backend/assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="{{ asset('new_backend/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />  
        <!-- Bootstrap Css -->
        <link href="{{ asset('new_backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('new_backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('new_backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
        <!-- Sweet Alert -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
        <!-- lightbox -->
        <link href="{{ asset('new_backend/assets/libs/magnific-popup/magnific-popup.css') }}" rel="stylesheet" type="text/css" />
        <!-- Toaster -->
        <link rel="stylesheet" type="text/css" href="{{ asset('new_backend/assets/libs/toastr/build/toastr.min.css') }}">
        <!-- advance form -->
        <link href="{{ asset('new_backend/assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('new_backend/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
        <link href="{{ asset('new_backend/assets/libs/spectrum-colorpicker2/spectrum.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('new_backend/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet">
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
        @yield('css')

    </head>

    <body data-topbar="dark">
        
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    <i class="ri-loader-line spin-icon"></i>
                </div>
            </div>
        </div>
        <!-- Begin page -->
        <div id="layout-wrapper">
            <!-- Header -->
            @include('layouts.header.asesor_header')
            <!-- End Header -->

            <!-- Sidebar -->
            @include('layouts.sidebar.asesor_sidebar')
            <!-- End Sidebar -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">
                        
                        <!-- main konten -->
                        @yield('konten')
                        <!-- end main konten -->
                        
                    </div>
                    
                </div>
            <!-- ============================================================== -->
            <!-- End right Content here -->
            <!-- ============================================================== -->
               
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

        <!-- apexcharts -->
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
        <!--tinymce Editor js-->
        <script src="{{ asset('new_backend/assets/libs/tinymce/tinymce.min.js') }}"></script>
        <script src="{{ asset('new_backend/assets/js/pages/form-editor.init.js') }}"></script>
        <!-- lightbox init js-->
        <script src="{{ asset('new_backend/assets/libs/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ asset('new_backend/assets/js/pages/lightbox.init.js') }}"></script>
        <!-- toastr plugin -->
        <script src="{{ asset('new_backend/assets/libs/toastr/build/toastr.min.js') }}"></script>
        <!-- toastr init -->
        <script src="{{ asset('new_backend/assets/js/pages/toastr.init.js') }}"></script>
        <script src="{{ asset('new_backend/assets/js/blockui.js') }}"></script>
        <!-- App js -->
        <script src="{{ asset('new_backend/assets/js/app.js') }}"></script>
        <!-- form advance -->
        <script src="{{ asset('new_backend/assets/libs/select2/js/select2.min.js') }}"></script>
        <script src="{{ asset('new_backend/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('new_backend/assets/libs/spectrum-colorpicker2/spectrum.min.js') }}"></script>
        @if(Session::has('message'))
        <script>
            Swal.fire({
                icon:'warning',
                title: 'Maaf',
                html: 'Untuk Saat ini Manual Book Belum Tersedia'
            });
        </script>
        @endif
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
        @yield('js')

    </body>

</html>