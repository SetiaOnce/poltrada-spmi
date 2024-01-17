<script type="text/javascript">
    // only number
    function hanyaAngka(evt) {
    var theEvent = evt || window.event;
    // Handle paste
    if (theEvent.type === 'paste') {
        key = event.clipboardData.getData('text/plain');
    } else {
    // Handle key press
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
    }
    var regex = /[0-9]|\./;
    if( !regex.test(key) ) {
        theEvent.returnValue = false;
        if(theEvent.preventDefault) theEvent.preventDefault();
    }
    }

    // enter auto cek 
    $(document).ready(function() {
        $('body').keydown(function(event) {
            if (event.keyCode == 13) {
                $('#btn-cek').click();
                $('#btn-cek-email').click();
                return false;
            }
        });
    });

    // cek data by email
    $('#btn-cek-email').on('click', function (e) {
        e.preventDefault();
        $('#btn-cek-email').html('<i class="fa fa-spin fa-spinner"></i>').attr('disabled', false);

        var cek_email = $('#cek_email');
        
        if (cek_email.val() == '') {
            Swal.fire({ 
                icon: 'warning',
                title: 'Maaf!',
                text: 'Email Masih Kosong, Silakan Isi Terlebih Dahulu...',
                allowOutsideClick: false, 
            })
            $('#btn-cek-email').html('<b><i class="fa fa-search fa-fw" aria-hidden="true"></i>Cek</b>').attr('disabled', false);
            return false;
        }

        var formDataEmail = new FormData($('#form-email')[0])
        
        $.ajax({
            url: "{{ route('survey.cek.email') }}",
            method: 'POST',
            data: formDataEmail,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                $('#btn-cek-email').html('<b><i class="fa fa-search fa-fw" aria-hidden="true"></i>Cek</b>').attr('disabled', false);
                $('#status-data').html('');
                if (response.success) {
                    $('#status-data').append('<div class="alert alert-success" role="alert">\
                        <i class="mdi mdi-account-check"></i> Detail Staff/Dosen ditemukan\
                    </div>');

                    $.each(response.event_survey, function(key,value){
                        $('.status-check-survey'+value.id+'').prop('checked',false);
                        $('#submit-survey'+value.id+'').show();
                    });

                    // cek data survey yang sudah diisi
                    $.each(response.hasil_survey, function(no,hasil_survey){
                        var idHasilSurvey = hasil_survey.id_nama_survey;
                        $.each(response.event_survey, function(key,value){
                            var eventsurveyNamaSurvey = value.nama_survey_id;
                            if(idHasilSurvey == eventsurveyNamaSurvey){
                                $('.status-check-survey'+value.id+'').prop('checked',true);
                                $('#submit-survey'+value.id+'').hide();
                            }
                        });
				    });

                    $('#form_survey_taruna').removeClass('hide');
                    $('[name="nim"]').val(response.data.nim),
                    $('[name="nik"]').val(response.data.nik),
                    $('[name="nama"]').val(response.data.nama),
                    $('[name="jenis_kelamin"]').val(response.data.jenis_kelamin),
                    $('[name="email"]').val(response.data.email),
                    $('[name="tahun_masuk"]').val(response.data.tahun_masuk);
                    $('[name="jenjang"]').val('-');
                    $('[name="prodi"]').val('-');
                    
                }else if(response.error){
                    $('#form_survey_taruna').addClass('hide');
                    $('#status-data').append('<div class="alert alert-danger" role="alert">\
                        <i class="mdi mdi-alert"></i> Detail Staff/Dosen Tidak ditemukan\
                    </div>');
                }else if(response.already){
                    $('#form_survey_taruna').addClass('hide');
                    $('#status-data').append('<div class="alert alert-warning" role="alert">\
                        <i class="mdi mdi-alert"></i>"<b>'+response.data.nama+'</b>" anda sudah mengisi survey sebelumnya, tidak bisa lagi mengsisi survey\
                    </div>'); 
                }
            }, error: function () {
                $('#btn-cek').html('<b><i class="fa fa-search fa-fw" aria-hidden="true"></i>Cek</b>').attr('disabled', false);
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.',
                    allowOutsideClick: false, 
                })   
            }
        });
        
    });

    // cek data by notar
    $('#btn-cek').on('click', function (e) {
        e.preventDefault();
        $('#btn-cek').html('<i class="fa fa-spin fa-spinner"></i>').attr('disabled', false);

        var notar = $('#notar');
        
        if (notar.val() == '') {
            Swal.fire({ 
                icon: 'warning',
                title: 'Maaf!',
                text: 'No Taruna Masih Kosong, Silakan Isi Terlebih Dahulu...',
                allowOutsideClick: false, 
            })
            $('#btn-cek').html('<b><i class="fa fa-search fa-fw" aria-hidden="true"></i>Cek</b>').attr('disabled', false);
            return false;
        }

        var formData = new FormData($('#form-notar')[0])
        
        $.ajax({
            url: "{{ route('survey.cek.notar') }}",
            method: 'POST',
            data: formData,
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                $('#btn-cek').html('<b><i class="fa fa-search fa-fw" aria-hidden="true"></i>Cek</b>').attr('disabled', false);
                $('#status-data').html('');
                if (response.success) {
                    $('#status-data').append('<div class="alert alert-success" role="alert">\
                        <i class="mdi mdi-account-check"></i> Detail Taruna/i ditemukan\
                    </div>');
                    $.each(response.event_survey, function(key,value){
                        $('.status-check-survey'+value.id+'').prop('checked',false);
                        $('#submit-survey'+value.id+'').show();
                    });

                    // cek data survey yang sudah diisi
                    $.each(response.hasil_survey, function(no,hasil_survey){
                        var idHasilSurvey = hasil_survey.id_nama_survey;
                        $.each(response.event_survey, function(key,value){
                            var eventsurveyNamaSurvey = value.nama_survey_id;
                            if(idHasilSurvey == eventsurveyNamaSurvey){
                                $('.status-check-survey'+value.id+'').prop('checked',true);
                                $('#submit-survey'+value.id+'').hide();
                            }
                        });
				    });

                    $('#form_survey_taruna').removeClass('hide');
                    $('[name="nim"]').val(response.data.nim),
                    $('[name="nik"]').val(response.data.nik),
                    $('[name="nama"]').val(response.data.nama),
                    $('[name="jenis_kelamin"]').val(response.data.jenis_kelamin),
                    $('[name="email"]').val(response.data.email),
                    $('[name="tahun_masuk"]').val(response.data.tahun_masuk);
                    $('[name="jenjang"]').val(response.data.jenjang);
                    $('[name="prodi"]').val(response.data.prodi);
                    
                }else if(response.error){
                    $('#form_survey_taruna').addClass('hide');
                    $('#status-data').append('<div class="alert alert-danger" role="alert">\
                        <i class="mdi mdi-alert"></i> Detail Taruna/i Tidak ditemukan\
                    </div>');
                }else if(response.already){
                    $('#form_survey_taruna').addClass('hide');
                    $('#status-data').append('<div class="alert alert-warning" role="alert">\
                        <i class="mdi mdi-alert"></i>"<b>'+response.data.nama+'</b>" anda sudah mengisi survey sebelumnya, tidak bisa lagi mengsisi survey\
                    </div>'); 
                }
            }, error: function () {
                $('#btn-cek').html('<b><i class="fa fa-search fa-fw" aria-hidden="true"></i>Cek</b>').attr('disabled', false);
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.',
                    allowOutsideClick: false, 
                })   
            }
        });
        
    });

    // submit survey
    function submit_survey(data_id)
    {
        Swal.fire({title: 'Apakah Kamu Yakin?',text: "Pastikan semua form sudah terisi",icon: 'warning',showCancelButton:true,confirmButtonColor: '#3085d6',cancelButtonColor: '#d33',confirmButtonText:'Kirim!',cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                $('#submit-survey'+data_id+'').html('<i class="fa fa-spin fa-spinner"></i> Mohon Tunggu...').attr('disabled', true);
                
                var form_survey = new FormData($('#form-survey'+data_id+'')[0])
                $.ajax({
                    url: "{{ route('pertanyaan.survey.save') }}",
                    method: 'POST',
                    data: form_survey,
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (response) {
                        console.log(response);
                        $('#submit-survey'+data_id+'').html('<i class="fa fa-sign-in fa-fw"></i> Kirim Survey').attr('disabled', false);
                        
                        if (response.success) {
                            $('.status-check-survey'+data_id+'').prop('checked',true);
                            $('div.collspan-message'+data_id+'').collapse("hide");
                            $('#submit-survey'+data_id+'').hide();

                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses...',
                                text: 'Data survey yang anda masukkan sudah tersimpan pada sistem, Silakan Isi Survey Selanjutnya Terima Kasih...',
                                allowOutsideClick: false, 
                            })   
                        }else if(response.already){
                            Swal.fire({ 
                                icon: 'error',
                                title: 'Maaf!',
                                text: '"'+response.nama+'" anda sudah mengisi survey ini, tidak bisa mengisi survey yang sama secara berulang..',
                                allowOutsideClick: false, 
                            })
                        }else{
                            var pertanyaan = $('#jawaban'+response.id+'');
                            pertanyaan.focus();
                            $.each(response.errors, function(key,value){
                                Swal.fire({ 
                                    icon:'warning',
                                    title: 'Maaf!',
                                    text: ''+value+'',
                                    allowOutsideClick: false, 
                                })
                            });  
                        }
                    }, error: function () {
                        $('#submit-survey'+data_id+'').html('<i class="fa fa-sign-in fa-fw"></i> Kirim Survey').attr('disabled', false);
                        Swal.fire({ 
                            icon: 'warning',
                            title: 'Maaf!',
                            text: 'Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.',
                            allowOutsideClick: false, 
                        })   
                    }
                });
            
            }
        }) 
    }

</script>