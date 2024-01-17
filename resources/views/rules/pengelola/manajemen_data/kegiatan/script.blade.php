<script type="text/javascript">
    $.ajaxSetup({
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	//script Review Image
	$(document).ready(function(){
		$('#foto_kegiatan').change(function(e){
			var reader = new FileReader();
			reader.onload = function(e){
				$('#showImage').attr('src',e.target.result);
			}
			reader.readAsDataURL(e.target.files['0']);
		});
	});

    //datatable
    var table = $('.datatable').DataTable({
        searchDelay: 300,
        processing: true,
        serverSide: true,
		ajax: "{{ route('pengelola.kegiatan.index') }}",
        destroy: true,
        draw: true,
        deferRender: true,
        responsive: false,
        autoWidth: false,
        LengthChange: true,
        paginate: true,
        pageResize: true,
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'jenis_akreditasi', name: 'jenis_akreditasi'},
            {data: 'judul_kegiatan', name: 'judul_kegiatan'},
            {data: 'foto', name: 'foto'},
            {data: 'status', name: 'foto'},
            {data: 'action', name: 'action'},
        ],
        //Set column definition initialisation properties.
        columnDefs: [
            { "width": "5%", "targets": 0, "className": "align-top text-center" },
            { "width": "20%", "targets": 1, "className": "align-top" },
            { "width": "60%", "targets": 2, "className": "align-top" },
            { "width": "5%", "targets": 3, "className": "align-top text-center", orderable: false, searchable: false},
            { "width": "5%", "targets": 3, "className": "align-top text-center", orderable: false, searchable: false},
            { "width": "5%", "targets": 4, "className": "align-top text-center",orderable: false, searchable: false },
        ],
        oLanguage: {
			sSearch : "<i class='mdi mdi-magnify'></i>",
            sSearchPlaceholder: "Pencarian...",
            sEmptyTable: "Tidak ada Data yang dapat ditampilkan..",
            sInfo: "Menampilkan _START_ s/d _END_ dari _TOTAL_",
            sInfoEmpty: "Menampilkan 0 - 0 dari 0 entri.",
            sInfoFiltered: "",
            sProcessing: `<div class="d-flex justify-content-center align-items-center"><div class="blockui-message"><span class="spinner-border text-primary align-middle me-2"></span> Mohon Tunggu...</div></div>`,
            sZeroRecords: "Tidak ada Data yang dapat ditampilkan..",
            sLengthMenu : "Tampilkan _MENU_ Entri",
            oPaginate: {
                sPrevious: "Sebelumnya",
                sNext: "Selanjutnya",
            },
        },

        fnDrawCallback: function (settings, display) {
            $('[data-bs-toggle="tooltip"]').tooltip("dispose"), $(".tooltip").hide();
            //Custom Table
            $('[data-bs-toggle="tooltip"]').tooltip({ 
                trigger: "hover"
            }).on("click", function () {
                $(this).tooltip("hide");
            });
        },
    });
    $(".datatable").css("width", "100%");

    // Script Untuk Upload Gambar form editor
    tinymce.init({ 
        selector: 'textarea#deskripsi_kegiatan',
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
	
	// close form
    var _closeForm = function() {
        $('.header-title').html('');
        $('#showImage').attr('src',"{{ asset('img/no-image2.png') }}");
        _clearForm(), $('#card-form').hide(), $('#card-table').show();
    }

    // clear form
    var _clearForm = function() {
            $('#form-data')[0].reset(), 
			$('[name="id"]').val(''),
			$('[name="methodform_data"]').val(''),
			$('#jenis_akreditasi_id').val('');
			$('#judul_kegiatan').val('');
			$('#deskripsi_kegiatan').val('');
			$('#foto_kegiatan').val('');
    }

	// add data baru
	var _addData = function() {
        $('.header-title').append('Input Data Kegiatan Baru');
        _clearForm(), $('[name="methodform_data"]').val('add'), $('#card-table').hide(), $('#card-form').show();
    }

	// edit data
	var _editData = function(data_id) {
        $('.header-title').append('Edit Data Kegiatan');
        // $('#card-table').hide(), $('#card-form').show();
        $('#form-data')[0].reset(), $('[name="methodform_data"]').val('update');

        var url = '{{ route("pengelola.kegiatan.edit", ":data_id") }}';
    		url = url.replace(':data_id', data_id);
		$.ajax({
            url:url,
            type: "GET",
            dataType: "JSON",
            success:function(response){
                _clearForm();   
                $('[name="id"]').val(response.data.id),
		        $('[name="methodform_data"]').val('update'),
                $('select[name="jenis_akreditasi_id"]').val(response.data.jenis_akreditasi_id)
                $('#judul_kegiatan').val(response.data.judul_kegiatan);
                tinymce.get('deskripsi_kegiatan').setContent(response.data.deskripsi_kegiatan);
                // tinymce.activeEditor.setContent(response.data.deskripsi_kegiatan);
                $('#showImage').attr('src','{{ asset("") }}'+response.data.foto_kegiatan+'');

                $('#card-table').hide(), $('#card-form').show();
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

	// save data
	$(document).ready(function(){
		$('#form-data').on('submit', function(event){
            event.preventDefault();
            $('#btn-save').html('<i class="fa fa-spin fa-spinner"></i> Mohon Tunggu...').attr('disabled', true);
            const jenis_akreditasi_id = $('#jenis_akreditasi_id'), judul_kegiatan = $('#judul_kegiatan'), deskripsi_kegiatan = $('#deskripsi_kegiatan');     
            if (jenis_akreditasi_id.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Jenis kegiatan masih kosong, silakan lengkapi terlebih dahulu...',
                    allowOutsideClick: false, 
                })    
                jenis_akreditasi_id.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }
            if (judul_kegiatan.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Judul kegiatan masih kosong, silakan lengkapi terlebih isi dahulu...',
                    allowOutsideClick: false, 
                })    
                judul_kegiatan.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }
            if (deskripsi_kegiatan.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Deskripsi kegiatan masih kosong, silakan lengkapi terlebih dahulu...',
                    allowOutsideClick: false, 
                })    
                deskripsi_kegiatan.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }
            
            $.ajax({
                url: "{{ route('pengelola.kegiatan.store') }}",
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
                            html: 'Data sukses disimpan'
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
                        icon: 'warning',
                        title: 'Maaf!',
                        text: 'Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.',
                        allowOutsideClick: false, 
                    })   
                }
            });
        });
    });

	// Hapus Data
	function _deleteData(data_id) {
        Swal.fire({title: 'Apakah Kamu Yakin?',text: "Menghapus data ini?",icon: 'warning',showCancelButton:true,confirmButtonColor: '#3085d6',cancelButtonColor: '#d33',confirmButtonText:'Hapus!',cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                var url = '{{ route("pengelola.kegiatan.delete", ":data_id") }}';
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
								html: 'Sukses menghapus data kegiatan'
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

    	// edit status
	function editStatus(data_id) {
		Swal.fire({
			title: 'Apakah Kamu Yakin?',text: "Ingin ingin mengubah status kegiatan ini?",icon: 'warning',showCancelButton: true,confirmButtonColor: '#3085d6',cancelButtonColor: '#d33',confirmButtonText: 'Lanjutkan!',cancelButtonText: "Batal",
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: "{{  url('/pengelola/manajemen-data/kegiatan/edit-status') }}/"+data_id,
					type: "GET",
					dataType: "JSON",
					cache: false,
					success:function(response){

						if (response.success) {
							Swal.fire({
							icon:'success',
							title: 'Sukses...',
							html: 'Status sukses dirubah'
							});
							table.draw();
						}else {
							Swal.fire({
							icon:'warning',
							title: 'Status gagal dirubah...',
							html: 'Silakan coba lagi !'
							});
							table.draw();
						}

					},

					error:function(response){
					console.log(response);
						Swal.fire({
							icon:'warning',
							title: 'Opps!',
							text: 'server error!'
						});

					}

				});
			} else{
				table.draw();
			}
		}) 
	}

</script>