<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="twitter:widgets:csp" content="on">
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<meta http-equiv="x-ua-compatible" content="ie=edge" />
	<meta name="theme-color" content="#FF9900">
	<title>@yield('title')</title>

	<link rel="shortcut icon" sizes="16x16 24x24 32x32 48x48 64x64" href="{{ asset($profile_app->logo_aplikasi) }}">
	<!-- Mobile (Android, iOS & others) -->
	<link rel="apple-touch-icon" sizes="57x57" href="{{ asset($profile_app->logo_aplikasi) }}">
	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="{{ asset($profile_app->logo_aplikasi) }}">
	<link rel="apple-touch-icon" sizes="72x72" href="{{ asset($profile_app->logo_aplikasi) }}">
	<link rel="apple-touch-icon" sizes="114x114" href="{{ asset($profile_app->logo_aplikasi) }}">
	<link rel="apple-touch-icon" sizes="120x120" href="{{ asset($profile_app->logo_aplikasi) }}">
	<link rel="apple-touch-icon" sizes="144x144" href="{{ asset($profile_app->logo_aplikasi) }}">
	<link rel="apple-touch-icon" sizes="152x152" href="{{ asset($profile_app->logo_aplikasi) }}">

	<!-- Windows 8 Tiles -->
	<meta name="application-name" content="{{ asset($profile_app->nama_applikasi) }}">
	<meta name="msapplication-TileImage" content="{{ asset($profile_app->logo_aplikasi) }}">
	<meta name="msapplication-TileColor" content="#FF9900">
	<!-- iOS Settings -->
	<meta content="yes" name="apple-mobile-web-app-capable">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

	<meta name="keywords" content="" />
	<meta name="description" content="">
	<meta name="author" content="Yoga Setiawan">
	<meta content="{{ asset($profile_app->nama_aplikasi) }}" name="" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="canonical" href="#" />
	<meta name="robots" content="noodp" />
	<meta property="og:locale" content="id_ID" />
	<meta property="og:type" content="website" />
	<meta property="og:title" content="{{ asset($profile_app->nama_aplikasi) }}" />
	<meta property="og:description" content="" />
	<meta property="og:url" content="#" />
	<meta property="og:site_name" content="{{ asset($profile_app->nama_aplikasi) }}" />
	<meta property="og:image" content="img/logospm.png" />
	<meta property="og:image:width" content="1024" />
	<meta property="og:image:height" content="512" />
	<meta name="twitter:card" content="summary_large_image" />
	<meta name="twitter:description" content="" />
	<meta name="twitter:title" content="{{ asset($profile_app->nama_aplikasi) }}" />
	<meta name="twitter:site" content="#" />
	<meta name="twitter:image" content="{{ asset($profile_app->logo_aplikasi) }}" />
	<meta name="twitter:creator" content="PT. Tricipta Internasional" />
	<meta content="telephone=no" name="format-detection" />
	<meta name="HandheldFriendly" content="true" />
	<!-- Mobile Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
	<meta name="MobileOptimzied" content="width" />
	<meta http-equiv="cleartype" content="on" />
	<!-- Bootstrap Core CSS -->
	<link href="{{ asset('frontend/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
	<!-- page CSS -->
	<!-- <link href="backend/plugins/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet"> -->
	<!-- <link href="backend/plugins/sweetalert/sweetalert.css" rel="stylesheet"> -->
	<link href="{{ asset('backend/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/plugins/bootstrap-file-input/css/fileinput.min.css') }}" rel="stylesheet"/>
	<link href="{{ asset('backend/plugins/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('backend/plugins/custom-select/custom-select.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('backend/plugins/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">
	<link href="{{ asset('backend/plugins/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
	<link href="{{ asset('backend/plugins/owl.carousel/owl.carousel.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('backend/plugins/owl.carousel/owl.theme.default.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('backend/css/animate.css') }}" rel="stylesheet">
	<link href="{{ asset('frontend/style.css') }}" rel="stylesheet">
	<link href="{{ asset('frontend/custom_style.css') }}" rel="stylesheet">
	<link href="{{ asset('backend/css/colors/custom.css') }}" id="theme" rel="stylesheet">
	<link href="{{ asset('backend/plugins/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css">
	<!-- DataTables -->
	<link href="{{ asset('new_backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('new_backend/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('new_backend/assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
	<!-- Responsive datatable examples -->
	<link href="{{ asset('new_backend/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />  
	<link rel="stylesheet" href="{{ asset('backend/plugins/sweetalert/sweetalert2.css') }}">
	<link rel="stylesheet" href="{{ asset('frontend/dist/owl.carousel/assets/vendors/jquery.min.js') }}">
    <link rel="stylesheet" href="{{ asset('frontend/icons/font-awesome/css/font-awesome.min.css') }}">

	<!-- owlcarousel -->
	<link rel="stylesheet" href="{{ asset('frontend/dist/owl.carousel/assets/vendors/jquery.min.js') }}">
	<link rel="stylesheet" href="{{ asset('frontend/dist/owl.carousel/assets/owlcarousel/owl.carousel.js') }}">
	<link rel="stylesheet" href="{{ asset('frontend/dist/owl.carousel/assets/owlcarousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/dist/owl.carousel/assets/owlcarousel/assets/owl.theme.default.min.css') }}">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.1.96/css/materialdesignicons.min.css">
	@yield('css')
</head>

<body class="fix-header content-wrapper"> 

	<div class="preloader">
		<svg class="circular" viewBox="25 25 50 50">
			<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
		</svg>
	</div>
	
	<div id="wrapper">
    	@include('layouts.header.frontend_header')
		<div id="page-wrapper">
            @yield('konten')
        </div>
	</div>

	<a href="javascript:void(0)" class="scroll-to-top"><i class="fa fa-angle-up" aria-hidden="true"></i></a>

	<script src="{{ asset('backend/plugins/jquery/dist/jquery.min.js') }}"></script>
	<script src="{{ asset('frontend/bootstrap/dist/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('backend/plugins/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
	<script src="{{ asset('backend/js/jquery.slimscroll.js') }}"></script>
	<script src="{{ asset('backend/js/waves.js') }}"></script>
	<script src="{{ asset('backend/js/wow.js') }}"></script>
	<script src="{{ asset('backend/js/custom.js') }}"></script>
	<script src="{{ asset('backend/js/jquery.mask.min.js') }}"></script>
	<script src="{{ asset('backend/plugins/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/bootstrap-file-input/js/fileinput.min.js') }}"></script>
	<script src="{{ asset('backend/plugins/bootstrap-file-input/js/locales/id.js') }}"></script>
	<!-- apexcharts -->
	<script src="{{ asset('new_backend/assets/libs/apexcharts/apexcharts.min.js') }}"></script>
	<!-- Required datatable js -->
	<script src="{{ asset('new_backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('new_backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
	<!-- Datatable init js -->
	{{-- <script src="{{ asset('new_backend/assets/js/pages/datatables.init.js') }}"></script> --}}
	<!-- Responsive examples -->
	<script src="{{ asset('new_backend/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
	<script src="{{ asset('new_backend/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
	<!-- <script src="js/cbpFWTabs.js"></script> -->
	<script src="{{ asset('backend/plugins/blockUI/jquery.blockUI.js') }}"></script>
	<script src="{{ asset('backend/js/whatsapp-chat.js') }}"></script>
	<script type="text/javascript" src="{{ asset('frontend/scrollIt_Js/scrollIt.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('backend/plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('backend/plugins/datatables/media/js/dataTables.bootstrap.min.js') }}"></script>
	<script src="{{ asset('backend/plugins/toast-master/js/jquery.toast.js') }}"></script>
	<script src="{{ asset('backend/plugins/owl.carousel/owl.carousel.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('frontend/beranda.js') }}"></script>
	<script src="{{ asset('new_backend/assets/js/blockui.js') }}"></script>
	<!-- owlcarousel -->
	<script src="{{ asset('frontend/dist/owl.carousel/assets/vendors/highlight.js') }}"></script>
    <script src="{{ asset('frontend/dist/owl.carousel/assets/js/app.js') }}"></script>
	
	<script type="text/javascript" src="{{ asset('backend/plugins/sweetalert/sweetalert2.js') }}"></script>
	
	@yield('js')
</body>

</html>