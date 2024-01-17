<script type="text/javascript">
    $.ajaxSetup({
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

    //script Review Image
	$(document).ready(function(){
		$('#logo').change(function(e){
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
		ajax: "{{ route('link-survey-external.index') }}",
        destroy: true,
        draw: true,
        deferRender: true,
        responsive: false,
        autoWidth: false,
        LengthChange: true,
        paginate: true,
        pageResize: true,
        columns: [
			{data: 'DT_RowIndex', name: 'DT_RowIndex', className:'text-center'},
			{data: 'nama_link_survey', name: 'nama_link_survey'},
			{data: 'link_url', name: 'link_url'},
			{data: 'logo', name: 'logo', className:'text-center'},
			{data: 'status', name: 'status'},
			{data: 'action', name: 'action',},
        ],
        //Set column definition initialisation properties.
        columnDefs: [
            { "width": "5%", "targets": 0, "className": "align-top text-center" },
            { "width": "35%", "targets": 1, "className": "align-top" },
            { "width": "35%", "targets": 2, "className": "align-top" },
            { "width": "10%", "targets": 3, "className": "align-top" },
            { "width": "10%", "targets": 4, "className": "align-top" },
            { "width": "5%", "targets": 5, "className": "align-top text-center", orderable: false, searchable: false},
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
    
	// close form
    var _closeForm = function() {
        $('.header-title').html('');
        _clearForm(), $('#card-form').hide(), $('#card-table').show();
        $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
    }

    // clear form
    var _clearForm = function() {
        $('#form-data')[0].reset(), 
        $('[name="id"]').val(''),
        $('[name="methodform_data"]').val(''),
        $('#nama_link_survey').val('');
        $('#link_url').val('');
		$('#showImage').attr('src','{{ asset("img/no-image.png") }}');
    }

	// add data baru
	var _addData = function() {
        $('.header-title').append('Input Data Link Survey External Baru');
        _clearForm(), $('[name="methodform_data"]').val('add'), $('#card-table').hide(), $('#card-form').show();
    }

	// edit data
	var _editData = function(data_id) {
        $('.header-title').append('Edit Data Link Survey External');
        $('#card-table').hide(), $('#card-form').show();
        $('#form-data')[0].reset(), $('[name="methodform_data"]').val('update');

        var url = '{{ route("link-survey-external.edit", ":data_id") }}';
    		url = url.replace(':data_id', data_id);
		$.ajax({
            url:url,
            type: "GET",
            dataType: "JSON",
            success:function(response){
                _clearForm();
                $('[name="id"]').val(response.data.id),
		        $('[name="methodform_data"]').val('update');
                $('#nama_link_survey').val(response.data.nama_link_survey);
                $('#link_url').val(response.data.link_url);
				$('#showImage').attr('src','{{ asset("") }}'+response.data.logo+'');

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

    	// edit status
	function editStatus(data_id) {
		Swal.fire({
			title: 'Apakah Kamu Yakin?',text: "Ingin ingin mengubah status link survey ini?",icon: 'warning',showCancelButton: true,confirmButtonColor: '#3085d6',cancelButtonColor: '#d33',confirmButtonText: 'Lanjutkan!',cancelButtonText: "Batal",
		}).then((result) => {
			if (result.isConfirmed) {
                var url = '{{ route("link.survey.change.status", ":data_id") }}';
    		        url = url.replace(':data_id', data_id);
				$.ajax({
					url: url,
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

	// save data
	$(document).ready(function(){
		$('#form-data').on('submit', function(event){
            event.preventDefault();
            $('#btn-save').html('<i class="fa fa-spin fa-spinner"></i> Mohon Tunggu...').attr('disabled', true);
            const nama_link_survey = $('#nama_link_survey'), link_url = $('#link_url');
            if (nama_link_survey.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Nama link survey masih kosong, silakan lengkapi terlebih dahulu...',
                    allowOutsideClick: false, 
                })    
                nama_link_survey.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }     
            if (link_url.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Link url masih kosong, silakan lengkapi terlebih isi dahulu...',
                    allowOutsideClick: false, 
                })    
                link_url.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }      
        
            $.ajax({
                url: "{{ route('link-survey-external.store') }}",
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
                var url = '{{ route("link-survey-external.destroy", ":data_id") }}';
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
								html: 'Sukses menghapus data'
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

</script>