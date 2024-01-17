<script>
    $.ajaxSetup({
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
    
    //script menampilkan password
    function showPassword() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    function showPassword2() {
        var x = document.getElementById("konfirmasi_password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
    //script Review Image
    $(document).ready(function(){
        $('#foto').change(function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });

    //  datatable
	var table = $('.datatable').DataTable({
		processing: true,
		serverSide: true,
		ajax: "{{ route('pengguna.index') }}",
		columns: [
			{data: 'DT_RowIndex', name: 'DT_RowIndex'},
			{data: 'name', name: 'name'},
			{data: 'role', name: 'role', className:'text-center'},
			{data: 'email', name: 'email'},
			{data: 'dataTelepon', name: 'dataTelepon'},
			{data: 'foto', name: 'foto'},
			{data: 'action', name: 'action', orderable: false, searchable: false},
		]
	});

    //clear form
	var _clearForm = function() {
		// $('[name="id"]').val(''),
		// $('[name="methodform_data"]').val(''),
		$('#email').val('');
		$('#no_whatsapp').val('');
		$('#alamat').val('');
		$('#alamat').val('');
		$('#foto').val('');
        $('#showImage').attr('src','{{ asset("img/no-image.png") }}');
	}
    
    // ajax mengambil data sdm
    $(document).ready(function(){
        $('select[name="nama_lengkap"]').on('change',function(){
            var data_id = $(this).val();
            if (data_id) {
                
                var url = '{{ route("ajax.get.data.sdm", ":data_id") }}';
                url = url.replace(':data_id', data_id);

                $.ajax({
                    url: url,
                    type:"GET",
                    dataType:"json",
                    success:function(response) { 
                        _clearForm();
                        // $('[name="id"]').val(''),
                        // $('[name="methodform_data"]').val('add'),
                        $('#email').val(response.data.dataEmail);
                        $('#no_whatsapp').val(response.data.dataTelepon);
                        $('#alamat').val(response.data.dataAlamat);
		                $('#foto').val(response.data.dataFoto);
                        $('#showImage').attr('src',response.data.dataFoto);
                    },
                });

            }else{
                Swal.fire({
                    icon:'warning',
                    title: 'Id tidak ditemukan...',
                    html: 'Silakan coba lagi !'
                });
            }

        });
    });

    $(document).ready(function(){
        $('select[name="level"]').on('change',function(){
            var data_id = $(this).val();
            if(data_id == 3){
                $('#add_unit_prodi').show();
            }else{
                $('#add_unit_prodi').hide();
                $('#unit_prodi_id').val('disable');
            }

        });
    });

    // Hapus Data
    function _deleteData(data_id) {
        Swal.fire({title: 'Apakah Kamu Yakin?',text: "Menghapus Pengguna ini?",icon: 'warning',showCancelButton:true,confirmButtonColor: '#3085d6',cancelButtonColor: '#d33',confirmButtonText:'Hapus!',cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                var url = '{{ route("pengguna.destroy", ":data_id") }}';
    				url = url.replace(':data_id', data_id);
				$.ajax({
					url: url,
					type: "DELETE",
					dataType: "JSON",
					cache: false,
					success:function(response){

						if (response.success) {
							Swal.fire({
								icon:'success',
								title: 'Sukses...',
								html: 'Sukses menghapus data pengguna'
							});
							table.draw();
						}else {
							Swal.fire({
							icon:'warning',
							title: 'Gagal menghapus data pengguna...',
							html: 'Silakan coba lagi !'
							});
						}

					},

					error:function(response){
						Swal.fire({
							icon:'warning',
							title: 'Opps!',
							text: 'server error!'
						});
					}

				});
            }
        }) 
    }

    // close form
    var _closeForm = function() {
        $('.header-title').html('');
        $("#nama_lengkap").val("disable").trigger('change');
        $('#add_unit_prodi').hide();
        _clearForm(), $('#card-form').hide(), $('#card-table').show(), $('#form-data')[0].reset();
    }

    // add data baru
    var _addData = function() {
        $('.header-title').append('Input Data Pengguna Baru');
        save_method = 'add_data';
        _clearForm(), $('[name="methodform_data"]').val('add'), $('#card-table').hide(), $('#card-form').show();
    }

    // edit data
    var _editData = function(data_id) {
        $('.header-title').append('Edit Data Pengguna');
        $('#card-table').hide(), $('#card-form').show();
        $('#form-data')[0].reset(), $('[name="id"]').val(data_id), $('[name="methodform_data"]').val('update');
        var url = '{{ route("pengguna.edit", ":data_id") }}';
    		url = url.replace(':data_id', data_id);
		$.ajax({
            url:url,
            type: "GET",
            dataType: "JSON",
            success:function(response){
                _clearForm();
                $('[name="id"]').val(response.data.id);
		        $('[name="methodform_data"]').val('update');
                var role = response.data.role;
                if(role == 3){
                    $('#add_unit_prodi').show();
                    $('#unit_prodi_id').val(response.data.unit_prodi_id);
                }
                
                $('select[name="level"]').val(response.data.role)
                $("#nama_lengkap").val(response.data.name).trigger('change');
                $('#email').val(response.data.email);
                $('#no_whatsapp').val(response.data.dataTelepon);
                $('#alamat').val(response.data.dataAlamat);
                $('#foto').val(response.data.dataFoto);
                $('#showImage').attr('src',response.data.dataFoto);
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
    }

	// Save Data
	$(document).ready(function(){
		$('#form-data').on('submit', function(event){
        event.preventDefault();
            $('#btn-save').html('<i class="fa fa-spin fa-spinner"></i> Mohon Tunggu...').attr('disabled', true);

            const level = $('#level'), nama_lengkap = $('#nama_lengkap'), unit_prodi_id = $('#unit_prodi_id');
            if (level.val() == 3) {
                if (unit_prodi_id.val() == 'disable') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Unit/Prodi Masih kosong, silakan pilih unit/prodi...',
                    allowOutsideClick: false, 
                })  
                unit_prodi_id.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }
            }
            if (level.val() == 'disable') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Level masih kosong, silakan pilih level pengguna...',
                    allowOutsideClick: false, 
                })  
                level.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }
            if (nama_lengkap.val() == 'disable') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Nama Pengguna Masih kosong, Silakan pilih nama pengguna...',
                    allowOutsideClick: false, 
                })     
                nama_lengkap.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }

            $.ajax({
                url: "{{ route('pengguna.store') }}",
				method: 'POST',
				data: new FormData(this),
				dataType: 'JSON',
				contentType: false,
				cache: false,
				processData: false,
				success: function (response) {
					$('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
					
					if (response.success) {
                        _closeForm();
						Swal.fire({
							icon:'success',
							title: 'Sukses...',
							html: 'Data pengguna sukses disimpan'
						});
						table.draw();
					}else if(response.password){
						Swal.fire({
							icon:'warning',
							title: 'Oops...',
							html: 'Password dan konfirmasi password tidak sesuai..!'
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
					$('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false); 
					Swal.fire({ 
						icon:'warning',
						title: 'Maaf!',
						text: 'Akun tersebut sudah terdaftar pada sistem, Silakan pilih nama pengguna lain...',
						allowOutsideClick: false, 
					})   
				}
			});

        });
    });

    
</script>