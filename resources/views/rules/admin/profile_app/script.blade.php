<script type="text/javascript">
//script Review Image
$(document).ready(function(){
    $('#logo_header_panjang').change(function(e){
        var reader = new FileReader();
        reader.onload = function(e){
            $('#showImage').attr('src',e.target.result);
        }
        reader.readAsDataURL(e.target.files['0']);
    });
    $('#logo_header_kecil').change(function(e){
        var reader = new FileReader();
        reader.onload = function(e){
            $('#showImage2').attr('src',e.target.result);
        }
        reader.readAsDataURL(e.target.files['0']);
    });
    $('#logo_aplikasi').change(function(e){
        var reader = new FileReader();
        reader.onload = function(e){
            $('#showImage3').attr('src',e.target.result);
        }
        reader.readAsDataURL(e.target.files['0']);
    });
    $('#banner_login').change(function(e){
        var reader = new FileReader();
        reader.onload = function(e){
            $('#showImage5').attr('src',e.target.result);
        }
        reader.readAsDataURL(e.target.files['0']);
    });
    $('#banner_detail').change(function(e){
        var reader = new FileReader();
        reader.onload = function(e){
            $('#showImage4').attr('src',e.target.result);
        }
        reader.readAsDataURL(e.target.files['0']);
    });
});

var _clearForm = function() {
    $('#logo_header_panjang').val('');
    $('#logo_header_kecil').val('');
    $('#logo_aplikasi').val('');
    $('#banner_detail').val('');
}

$(document).ready(function(){
    $('#form-data').on('submit', function(event){
        event.preventDefault();
        $('#btn-save').html('<i class="fa fa-spin fa-spinner"></i> Mohon Tunggu...').attr('disabled', true);
 
        const nama_aplikasi = $('#nama_aplikasi'), footer = $('#footer');     
        if (nama_aplikasi.val() == '') {
            Swal.fire({ 
                icon: 'warning',
                title: 'Maaf!',
                text: 'Nama Aplikasi tidak boleh kosong, terlihat saat ini masih kosong...',
                allowOutsideClick: false, 
            })
            nama_aplikasi.focus();
            $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
            return false;
        }
        if (footer.val() == '') {
            Swal.fire({ 
                icon: 'warning',
                title: 'Maaf!',
                text: 'Footer tidak boleh kosong, terlihat saat ini masih kosong...',
                allowOutsideClick: false, 
            })     
            footer.focus();
            $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
            return false;
        }  

        $.ajax({
            url: "{{ route('profile-app.store') }}",
            method: 'POST',
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                if (response.success) {
                    _clearForm();
                    Swal.fire({
                        icon:'success',
                        title: 'Sukses...',
                        html: 'Data sukses diperbarui'
                    });
                    table.draw();
                }else{  
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
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false); 
                Swal.fire({ 
                    icon:'warning',
                    title: 'Maaf!',
                    text: 'Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.',
                    allowOutsideClick: false, 
                })   
            }
        });
    });
});
</script>