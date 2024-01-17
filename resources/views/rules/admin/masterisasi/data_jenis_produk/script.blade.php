<script type="text/javascript">
	$.ajaxSetup({
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	//datatable
	var table = $('.datatable').DataTable({
        searchDelay: 300,
        processing: true,
        serverSide: true,
		ajax: "{{ route('data-jenis-produk.index') }}",
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
			{data: 'nama_jenis_produk', name: 'nama_jenis_produk'},
			{data: 'action', name: 'action'},
        ],
        //Set column definition initialisation properties.
        columnDefs: [
            { "width": "10%", "targets": 0, "className": "align-top text-center" },
            { "width": "60%", "targets": 1, "className": "align-top" },
            { "width": "30%", "targets": 2, "className": "align-top text-center", orderable: false, searchable: false},
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
	
	// clear form
	var _clearForm = function() {
		$('#form-data')[0].reset(), 
		$('[name="id"]').val(''),
		$('[name="methodform_data"]').val(''),
		$('#nama_jenis_produk').val('');
    }
	// show modal add
	function _addData() {
		_clearForm(),$('[name="methodform_data"]').val('add'), $('#modalAdd').modal('show');
		$('[name="id"]').val(''),
        $('#headeTitle').html(''),
        $('#headeTitle').append('Input Jenis Produk Baru');
    }
	
    // show modal edit
    function _editData(data_id) {
		$('#form-data')[0].reset(), $('[name="id"]').val(data_id),$('[name="methodform_data"]').val('update');
        $('#headeTitle').html('');
        $('#headeTitle').append('Edit Data Jenis Produk');
		$('#modalAdd').modal('show');

		var url = '{{ route("data-jenis-produk.edit", ":data_id") }}';
    		url = url.replace(':data_id', data_id);
		$.ajax({
				url:url,
                type: "GET",
                dataType: "JSON",
                success:function(response){
					$('#nama_jenis_produk').val(response.nama_jenis_produk);
					$('#modalAdd').modal('show');
                }

            });
    }

    // Save Data
	$(document).ready(function(){
		$('#form-data').on('submit', function(event){
			event.preventDefault();
			$('#btn-save').html('<i class="fa fa-spin fa-spinner"></i> Mohon Tunggu...').attr('disabled', true);
			const nama_jenis_produk = $('#nama_jenis_produk');     
			if (nama_jenis_produk.val() == '') {
				Swal.fire({ 
					icon: 'warning',
					title: 'Maaf!',
					text: 'Jenjang harus diisi terlebih dahulu. terlihat saat ini masih kosong...',
					allowOutsideClick: false, 
				})     
				nama_jenis_produk.focus();
				$('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
				return false;
			}       
			
			$.ajax({
				url: "{{ route('data-jenis-produk.store') }}",
				method: 'POST',
				data: new FormData(this),
				dataType: 'JSON',
				contentType: false,
				cache: false,
				processData: false,
				success: function (response) {
					$('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
					
					if (response.success) {
						$('#modalAdd').modal('hide'),_clearForm();
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
						icon:'warning',
						title: 'Maaf!',
						text: 'Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.',
						allowOutsideClick: false, 
					})   
				}
			});

		});
	});

	// Delete Data
	function _deleteData(data_id) {
		Swal.fire({title: 'Apakah Kamu Yakin?',text: "Menghapus data ini?",icon: 'warning',showCancelButton:true,confirmButtonColor: '#3085d6',cancelButtonColor: '#d33',confirmButtonText:'Hapus!',cancelButtonText: "Batal",
		}).then((result) => {
			if (result.isConfirmed) {
				var url = '{{ route("data-jenis-produk.destroy", ":data_id") }}';
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
							title: 'Gagal menghapus data...',
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

	// SUB JENIS PRODUK ALL SCRIPT
	// reset form sub jenis produk
	function _clearformSub(){
		$('#form-sub-jenis').hide(),
		$('#form-data')[0].reset(), 
		$('[name="id"]').val(''),
		$('[name="methodform_data"]').val(''),
		$('[name="jenis_produk_id"]').val(''),
		$('#sub_jenis_produk').val('');
	}

	function _addSubJenis(){
		$('#form-sub-jenis').show();
		$('#info-method').html('');
		$('#info-method').append('Tambah');
		$('#sub_jenis_produk').val('');
	}
	
	// data sub jenis produk
	function _subJenisProduk(data_id){
		$('#modalSubJenis').modal('show');
		$('#subJenisProduk').html('');
		$('#jenisProduk').html('');
		_clearformSub();
		
		var url = '{{ route("sub.jenis.produk.index", ":data_id") }}';
    		url = url.replace(':data_id', data_id);
		$.ajax({
			url:url,
			type: "GET",
			dataType: "JSON",
			success:function(response){
				$('#jenisProduk').append(response.jenisProduk.nama_jenis_produk);
				$('[name="id"]').val(''),
				$('[name="methodform_data"]').val('add'),
				$('[name="jenis_produk_id"]').val(response.jenisProduk.id);

				$.each(response.subJenis, function(key,value){
					var $key = key + 1;
					$("#subJenisProduk").append('<tr>\
								<td align="center">'+$key+'</td>\
								<td>'+value.sub_jenis_produk+'</td>\
								<td align="center"><a href="javascript:void(0)" onclick="editSubJenis('+value.id+')" class="waves-effect waves-light btn btn-sm btn-info btn-circle" data-bs-original-title="Edit Data" title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-pencil-box-multiple"></span></a>\
								<a onclick="deleteSubJenis('+value.id+')" href="javascript:void(0)" class="waves-effect waves-light btn btn-sm btn-danger btn-circle" data-bs-original-title="Hapus Data" data-bs-placement="top" data-bs-toggle="tooltip" title="Hapus Data"><span class="mdi mdi-trash-can-outline"></span></a>\
								</td>')
				});
				
			}

		});
		
	}

	function editSubJenis(data_id){
		$('[name="id"]').val(data_id);
		$('[name="methodform_data"]').val('update'),
		_addSubJenis();
		$('#info-method').html('');
		$('#info-method').append('Edit');

		var url = '{{ route("sub-jenis-produk.edit", ":data_id") }}';
    		url = url.replace(':data_id', data_id);
		$.ajax({
				url:url,
                type: "GET",
                dataType: "JSON",
                success:function(response){
					$('#sub_jenis_produk').val(response.data.sub_jenis_produk);	
                }

            });
	}
	
	// Save sub jenis produk
	$(document).ready(function(){
		$('#form-sub-jenis').on('submit', function(event){
			event.preventDefault();
			$('#btn-save').html('<i class="fa fa-spin fa-spinner"></i> Mohon Tunggu...').attr('disabled', true);
			const sub_jenis_produk = $('#sub_jenis_produk');     
			if (sub_jenis_produk.val() == '') {
				Swal.fire({ 
					icon: 'warning',
					title: 'Maaf!',
					text: 'Sub jenis produk tidak boleh kosong. terlihat saat ini masih kosong...',
					allowOutsideClick: false, 
				})     
				sub_jenis_produk.focus();
				$('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
				return false;
			}       
			
			$.ajax({
				url: "{{ route('sub-jenis-produk.store') }}",
				method: 'POST',
				data: new FormData(this),
				dataType: 'JSON',
				contentType: false,
				cache: false,
				processData: false,
				success: function (response) {
					$('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
					
					if (response.success) {
						$('[name="jenis_produk_id"]').val(''),
						Swal.fire({
							icon:'success',
							title: 'Sukses...',
							html: 'Data sukses disimpan'
						});

						$('#subJenisProduk').html('');
						$('#jenisProduk').html('');
						_clearformSub();
						
						var url = '{{ route("sub.jenis.produk.index", ":data_id") }}';
							url = url.replace(':data_id', response.id);
						$.ajax({
							url:url,
							type: "GET",
							dataType: "JSON",
							success:function(response){
								$('#jenisProduk').append(response.jenisProduk.nama_jenis_produk);
								$('[name="id"]').val(''),
								$('[name="methodform_data"]').val('add'),
								$('[name="jenis_produk_id"]').val(response.jenisProduk.id);

								$.each(response.subJenis, function(key,value){
									var $key = key + 1;
									$("#subJenisProduk").append('<tr>\
												<td align="center">'+$key+'</td>\
												<td>'+value.sub_jenis_produk+'</td>\
												<td align="center"><a href="javascript:void(0)" onclick="editSubJenis('+value.id+')" class="waves-effect waves-light btn btn-sm btn-info btn-circle" data-bs-original-title="Edit Data" title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-pencil-box-multiple"></span></a>\
												<a onclick="deleteSubJenis('+value.id+')" href="javascript:void(0)" class="waves-effect waves-light btn btn-sm btn-danger btn-circle" data-bs-original-title="Hapus Data" data-bs-placement="top" data-bs-toggle="tooltip" title="Hapus Data"><span class="mdi mdi-trash-can-outline"></span></a>\
												</td>')
								});
								
							}

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
						text: 'Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.',
						allowOutsideClick: false, 
					})   
				}
			});

		});
	});

	// delete sub jenis produk
	function deleteSubJenis(data_id){
		Swal.fire({title: 'Apakah Kamu Yakin?',text: "Menghapus data ini?",icon: 'warning',showCancelButton:true,confirmButtonColor: '#3085d6',cancelButtonColor: '#d33',confirmButtonText:'Hapus!',cancelButtonText: "Batal",
		}).then((result) => {
			if (result.isConfirmed) {
				var url = '{{ route("sub-jenis-produk.destroy", ":data_id") }}';
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
							$('#subJenisProduk').html('');
						$('#jenisProduk').html('');
						_clearformSub();
						
						var url = '{{ route("sub.jenis.produk.index", ":data_id") }}';
							url = url.replace(':data_id', response.id);
						$.ajax({
							url:url,
							type: "GET",
							dataType: "JSON",
							success:function(response){
								$('#jenisProduk').append(response.jenisProduk.nama_jenis_produk);
								$('[name="id"]').val(''),
								$('[name="methodform_data"]').val('add'),
								$('[name="jenis_produk_id"]').val(response.jenisProduk.id);

								$.each(response.subJenis, function(key,value){
									var $key = key + 1;
									$("#subJenisProduk").append('<tr>\
												<td align="center">'+$key+'</td>\
												<td>'+value.sub_jenis_produk+'</td>\
												<td align="center"><a href="javascript:void(0)" onclick="editSubJenis('+value.id+')" class="waves-effect waves-light btn btn-sm btn-info btn-circle" data-bs-original-title="Edit Data" title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-pencil-box-multiple"></span></a>\
												<a onclick="deleteSubJenis('+value.id+')" href="javascript:void(0)" class="waves-effect waves-light btn btn-sm btn-danger btn-circle" data-bs-original-title="Hapus Data" data-bs-placement="top" data-bs-toggle="tooltip" title="Hapus Data"><span class="mdi mdi-trash-can-outline"></span></a>\
												</td>')
								});
								
							}

						});
						}else {
							Swal.fire({
							icon:'warning',
							title: 'Gagal menghapus data...',
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