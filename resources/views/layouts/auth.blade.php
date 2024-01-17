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
        <!-- Bootstrap Css -->
        <link href="{{ asset('new_backend/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('new_backend/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('new_backend/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
        <!-- Toaster -->
        <link rel="stylesheet" type="text/css" href="{{ asset('new_backend/assets/libs/toastr/build/toastr.min.css') }}">
        <!-- Sweet Alert -->
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">

    </head>

    <body class="auth-body-bg">
        <div class="bg-overlay"></div>
        @yield('konten')
        <!-- end -->

        <!-- JAVASCRIPT -->
        <script src="{{ asset('new_backend/assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('new_backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('new_backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('new_backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('new_backend/assets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('new_backend/assets/js/app.js') }}"></script>
        <!-- toastr plugin -->
        <script src="{{ asset('new_backend/assets/libs/toastr/build/toastr.min.js') }}"></script>
        <!-- toastr init -->
        <script src="{{ asset('new_backend/assets/js/pages/toastr.init.js') }}"></script>
        <!-- Alert -->
        <script src="{{ asset('new_backend/assets/js/alert.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <!-- Sweet Alert -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
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
