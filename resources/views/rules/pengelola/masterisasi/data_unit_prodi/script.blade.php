<script type="text/javascript">
	$.ajaxSetup({
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	var table = $('.datatable').DataTable({
        searchDelay: 300,
        processing: true,
        serverSide: true,
		ajax: "{{ route('pengelola-data-unit-prodi.index') }}",
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
			{data: 'unit_kerja', name: 'unit_kerja'},
        ],
        //Set column definition initialisation properties.
        columnDefs: [
            { "width": "10%", "targets": 0, "className": "align-top text-center" },
            { "width": "90%", "targets": 1, "className": "align-top" },
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
		$('#jenjang').val('');
		$('#unit_prodi').val('');
    }
	
    // show modal add
    function _addData() {
        _clearForm(),$('[name="methodform_data"]').val('add'), $('#modalAdd').modal('show');
		$('[name="id"]').val(''),
        $('#headeTitle').html(''),
        $('#headeTitle').append('Input Unit Prodi Baru');
    }
    // Edit data
    function _editData(data_id) {
		$('#form-data')[0].reset(), $('[name="id"]').val(data_id),$('[name="methodform_data"]').val('update');
        $('#headeTitle').html('');
        $('#headeTitle').append('Edit Unit Prodi');

		var url = '{{ route("pengelola-data-unit-prodi.edit", ":data_id") }}';
    		url = url.replace(':data_id', data_id);
		$.ajax({
				url:url,
                type: "GET",
                dataType: "JSON",
                success:function(response){
					$('#jenjang').val(response.jenjang);
					$('#unit_prodi').val(response.nama_unit_prodi);
					$('#modalAdd').modal('show');
                }

            });
    }

    // Delete Data
    function _deleteData(data_id) {
		Swal.fire({title: 'Apakah Kamu Yakin?',text: "Menghapus data ini?",icon: 'warning',showCancelButton:true,confirmButtonColor: '#3085d6',cancelButtonColor: '#d33',confirmButtonText:'Hapus!',cancelButtonText: "Batal",
		}).then((result) => {
			if (result.isConfirmed) {
				var url = '{{ route("pengelola-data-unit-prodi.destroy", ":data_id") }}';
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

    // Save Data
	$(document).ready(function(){
		$('#form-data').on('submit', function(event){
			event.preventDefault();
			$('#btn-save').html('<i class="fa fa-spin fa-spinner"></i> Mohon Tunggu...').attr('disabled', true);
			const unit_prodi = $('#unit_prodi'), jenjang = $('#jenjang');     
			if (jenjang.val() == '') {
				Swal.fire({ 
					icon: 'warning',
					title: 'Maaf!',
					text: 'Jenjang harus diisi terlebih dahulu. terlihat saat ini masih kosong...',
					allowOutsideClick: false, 
				})     
				jenjang.focus();
				$('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
				return false;
			}     
			
			if (unit_prodi.val() == '') {
				Swal.fire({ 
					icon: 'warning',
					title: 'Maaf!',
					text: 'Unit Prodi harus diisi terlebih dahulu. terlihat saat ini masih kosong...',
					allowOutsideClick: false, 
				})     
				unit_prodi.focus();
				$('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
				return false;
			}     
			
			$.ajax({
				url: "{{ route('pengelola-data-unit-prodi.store') }}",
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
</script>