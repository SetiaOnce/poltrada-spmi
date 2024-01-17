@extends('layouts.auth')
@section('konten')
@section('title')
    LOGIN - SPMI | PTDI-STTD
@stop

<div class="wrapper-page">
    <div class="container-fluid p-0">
        <div class="card">
            <div class="card-body">

                <div class="text-center">
                    <div class="mb-3">
                        <a href="javascript:void(0);" class="auth-logo">
                            <img src="{{ asset('img/logo-ptdi.png') }}" height="70" class="logo-dark mx-auto">
                            <img src="{{ asset('img/logo-ptdi.png') }}" height="70" class="logo-light mx-auto">
                        </a>
                    </div>
                </div>

                <h5 class="text-center font-size-16"><b>SATUAN PENJAMINAN MUTU</b></h5>
                <h6 class="text-muted text-center font-size-13"><b>POLITEKNIK TRANSPORTASI DARAT BALI</b></h6>
                <hr>
                <!-- <h5 class="text-center font-size-18"><b>LOGIN</b></h5> -->
                <div class="p-3">
                    <form class="form-horizontal">

                        <div class="form-group mb-3 row">
                            <div class="col-12">
                                <input class="form-control" type="email" id="email" placeholder="Email">
                            </div>
                        </div>

                        <div class="form-group mb-3 row">
                            <div class="col-12">
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" placeholder="Password" required="">
                                    <div class="input-group-prepend" style="cursor: pointer;">
                                        <span onclick="showPassword()" class="input-group-text lihat-password"><i class="mdi mdi-eye"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3 text-center row mt-3 pt-1">
                            <div class="col-12">
                                <div class="d-sm-flex align-items-center justify-content-between">
                                    <div class="col-md-5 mb-2">
                                        <a href="{{ route('home') }}" class="btn btn-secondary w-100 waves-effect waves-light"><i class="fas fa-home align-center me-1"></i> Beranda</a>
                                    </div>
                                    <div class="col-md-5 mb-2">
                                        <button id="btn_login" class="btn btn-primary w-100 waves-effect waves-light" type="button"><i class="fas fa-sign-in-alt align-center me-1"></i> Log In</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <!-- end -->
            </div>
            <!-- end cardbody -->
        </div>
        <!-- end card -->
    </div>
    <!-- end container -->
</div>

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    @if(Session::has('message'))
    command: toastr["success"]("Logout Sukses !")
    @endif 
    
    // script menampilkan password
    function showPassword() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
            $('.lihat-password').html('');
            $('.lihat-password').append('<i class="mdi mdi-eye-off"></i>');
        } else {
            x.type = "password";
            $('.lihat-password').html('');
            $('.lihat-password').append('<i class="mdi mdi-eye"></i>');
        }
    }

    // enter auto login
    $(document).ready(function() {
        $('body').keydown(function(event) {
        if (event.keyCode == 13) {
            $('#btn_login').click();
            return false;
        }
    });

});
    // script Login
    $('#btn_login').on('click', function (e) {
        e.preventDefault();
        $('#btn_login').html('<i class="fa fa-spin fa-spinner"></i> Mohon Tunggu...').attr('disabled', true);
        var email = $("#email").val();
        var password = $("#password").val();
        var token = $("meta[name='csrf-token']").attr("content");

        // $('#btn_login').html('<i class="fa fa-spin fa-spinner"></i> Mohon Tunggu...').attr('disabled', true);
        
        if(email.length == "") {
            $('#btn_login').html('<i class="fas fa-sign-in-alt align-center me-1"></i> Log In').attr('disabled', false);
            command: toastr["warning"]("Email Tidak Boleh Kosong !")
            email.focus();
            return false;

        } else if(password.length == "") {

            $('#btn_login').html('<i class="fas fa-sign-in-alt align-center me-1"></i> Log In').attr('disabled', false);
            command: toastr["warning"]("Password Tidak Boleh Kosong !")
            password.focus();
            return false;

        } else {

            $.ajax({
                url: "{{ route('login.check_login') }}",
                type: "POST",
                dataType: "JSON",
                cache: false,
                data: {
                    "email": email,
                    "password": password,
                    "_token": token
                },
                success:function(response){

                    if (response.success) {
                        $('#btn_login').html('<i class="fas fa-sign-in-alt align-center me-1"></i> Log In').attr('disabled', false);
                        
                        Swal.fire({
                            title: 'Hii, "'+response.email+'"',
                            text: 'Anda akan di arahkan dalam 3 Detik',
                            icon: 'success',
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading()
                                const b = Swal.getHtmlContainer().querySelector('b')
                                timerInterval = setInterval(() => {
                                b.textContent = Swal.getTimerLeft()
                                }, 100)
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                            }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                if(response.role == 1){
                                    window.location.href = "{{ url('admin/dashboard') }}"
                                }else if(response.role == 2){
                                    window.location.href = "{{ url('pengelola/dashboard') }}"
                                }else if(response.role == 3){
                                    window.location.href = "{{ url('prodi/dashboard') }}"
                                }else if(response.role == 4){
                                    window.location.href = "{{ url('asesor/dashboard') }}"
                                }
                            }
                        })
                    }else if(response.error){
                        $('#btn_login').html('<i class="fas fa-sign-in-alt align-center me-1"></i> Log In').attr('disabled', false);
                        Swal.fire({
                            icon:'warning',
                            title: 'Oops...',
                            html: 'Email atau password yang anda masukkan tidak sesuai !'
                        });
                        $("input[name='password']").val('');
                    } else {
                        $('#btn_login').html('<i class="fas fa-sign-in-alt align-center me-1"></i> Log In').attr('disabled', false);
                        Swal.fire({
                            icon:'warning',
                            title: 'Login Gagal!',
                            text: 'silahkan coba lagi!'
                        });

                    }

                },

                error:function(response){

                    Swal.fire({
                        icon:'warning',
                        title: 'Opps!',
                        text: 'server error!'
                    });

                    console.log(response);

                }

            });

        }
        
    });
    
</script>
@stop

@endsection