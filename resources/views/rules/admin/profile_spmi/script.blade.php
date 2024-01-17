<script type="text/javascript">
$.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
    
//script Review Image
$(document).ready(function(){
    $('#gambar_struktur').change(function(e){
        var reader = new FileReader();
        reader.onload = function(e){
            $('#showImage').attr('src',e.target.result);
            $('#showImage2').attr('src',e.target.result);
        }
        reader.readAsDataURL(e.target.files['0']);
    });
});

// show modal edit
function showImage() {
    $('#modalShow').modal('show');
}

// Script Untuk Upload Gambar form editor
tinymce.init({ 
    selector: 'textarea#visi_misi',
    height:300,
    plugins:["advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker","searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking","save table contextmenu directionality emoticons template paste textcolor"],
    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons',          
    images_upload_handler: function (blobInfo, success, failure) {
        var xhr, formData;
        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', '{{ route("tinymce.upload") }}');
        var token = '{{ csrf_token() }}';
        xhr.setRequestHeader("X-CSRF-Token", token);
        xhr.onload = function() {
            var json;
            if (xhr.status != 200) {
                failure('HTTP Error: ' + xhr.status);
                return;
            }
            json = JSON.parse(xhr.responseText);

            if (!json || typeof json.location != 'string') {
                failure('Invalid JSON: ' + xhr.responseText);
                return;
            }
            success(json.location);
        };
        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        xhr.send(formData);
    }
});
tinymce.init({ 
    selector: 'textarea#fungsi_tugas',
    height:300,
    plugins:["advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker","searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking","save table contextmenu directionality emoticons template paste textcolor"],
    toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons',          
    images_upload_handler: function (blobInfo, success, failure) {
        var xhr, formData;
        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', '{{ route("tinymce.upload") }}');
        var token = '{{ csrf_token() }}';
        xhr.setRequestHeader("X-CSRF-Token", token);
        xhr.onload = function() {
            var json;
            if (xhr.status != 200) {
                failure('HTTP Error: ' + xhr.status);
                return;
            }
            json = JSON.parse(xhr.responseText);

            if (!json || typeof json.location != 'string') {
                failure('Invalid JSON: ' + xhr.responseText);
                return;
            }
            success(json.location);
        };
        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        xhr.send(formData);
    }
});

// Save Visi Misi
$(document).ready(function(){
    $('#profile_visi_misi').on('submit', function(event){
        event.preventDefault();
        $('#btn-save').html('<i class="fa fa-spin fa-spinner"></i> Mohon Tunggu...').attr('disabled', true);
 
         const visi_misi = $('#visi_misi');     
            if (visi_misi.val() == '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Visi Misi tidak boleh kosong, terlihat saat ini masih kosong...',
                    allowOutsideClick: false, 
                })     
                visi_misi.focus();
                $('#save_visi_misi').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }

        $.ajax({
            url: "{{ route('visi.misi.update') }}",
            method: 'POST',
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                if (response.success) {
                    Swal.fire({
                        icon:'success',
                        title: 'Sukses...',
                        html: 'Visi Misi sukses diperbarui'
                    });
                    table.draw();
                }else{  
                    $.each(response.errors, function(key,value){
                        Swal.fire({ 
                            icon:'warning',
                            title: 'Maaf!',
                            text: 'Data gagal diperbarui',
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

// Save Fungsi dan Tugas
$(document).ready(function(){
    $('#profile_fungsi_tugas').on('submit', function(event){
        event.preventDefault();
        $('#btn-save').html('<i class="fa fa-spin fa-spinner"></i> Mohon Tunggu...').attr('disabled', true);
 
        const fungsi_tugas = $('#fungsi_tugas');     
        if (fungsi_tugas.val() == '') {
            Swal.fire({ 
                icon: 'warning',
                title: 'Maaf!',
                text: 'Fungsi dan Tugas tidak boleh kosong, terlihat saat ini masih kosong...',
                allowOutsideClick: false, 
            })     
            fungsi_tugas.focus();
            $('#save_fugsi_tugas').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
            return false;
        }     

        $.ajax({
            url: "{{ route('fungsi.tugas.update') }}",
            method: 'POST',
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                if (response.success) {
                    Swal.fire({
                        icon:'success',
                        title: 'Sukses...',
                        html: 'Fungsi dan Tugas sukses diperbarui'
                    });
                    table.draw();
                }else{  
                    $.each(response.errors, function(key,value){
                        Swal.fire({ 
                            icon:'warning',
                            title: 'Maaf!',
                            text: 'Data gagal diperbarui',
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

// Save Struktur
$('#save_struktur').on('click', function (e) {
    e.preventDefault();
    $('#save_struktur').html('<i class="fa fa-spin fa-spinner"></i> Mohon Tunggu...').attr('disabled', true);
    deskripsi = $('#deskripsi');     

    if (deskripsi.val() == '') {
        Swal.fire({ 
            title: 'Maaf!',
            text: 'Deskripsi tidak boleh kosong, terlihat saat ini masih kosong...',
            allowOutsideClick: false, 
        })     
        deskripsi.focus();
        $('#save_struktur').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
        return false;
    }     
    
    var formData = new FormData($('#profile_struktur_organisasi')[0]), ajax_url= "{{ route('struktur.organisasi.update') }}";
    $.ajax({
        url: ajax_url,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "JSON", 
        success: function (response) {
            $('#save_struktur').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
            
            if (response.success) {
                Swal.fire({
                    icon:'success',
                    title: 'Sukses...',
                    html: 'Struktur Organisasi Sukses diupdate'
                });
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
            $('#save_struktur').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false); 
            Swal.fire({ 
                icon: 'warning',
                title: 'Maaf!',
                text: 'Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.',
                allowOutsideClick: false, 
            })   
        }
    });

});
</script>
