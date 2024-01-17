<script type="text/javascript">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	//datatable
	var table = $('.datatable').DataTable({
		processing: true,
		serverSide: true,
		ajax: "{{ route('pengelola-data-jenis-akreditasi.index') }}",
		columns: [
			{data: 'DT_RowIndex', name: 'DT_RowIndex', className:'text-center'},
			{data: 'nama_jenis_akreditasi', name: 'nama_jenis_akreditasi'},
			{data: 'action', name: 'action', className:'text-center', orderable: false, searchable: false},
		]
	});

	// clear form
	var _clearForm = function() {
		$('#form-data')[0].reset();
    }
	// show modal add
	function _addData() {
		_clearForm(),$('[name="methodform_data"]').val('add'), $('#modalAdd').modal('show');
		$('[name="id"]').val(''),
        $('#headeTitle').html(''),
        $('#headeTitle').append('Input Jenis Akreditasi Baru');
    }

    // show modal edit
    function _editData(data_id) {
		$('#form-data')[0].reset(), $('[name="id"]').val(data_id),$('[name="methodform_data"]').val('update');
        $('#headeTitle').html('Edit Data Jenis Akreditasi');
		var url = '{{ route("pengelola-data-jenis-akreditasi.edit", ":data_id") }}';
    		url = url.replace(':data_id', data_id);
		$.ajax({
			url:url,
			type: "GET",
			dataType: "JSON",
			success:function(response){
				$('#nama_jenis_akreditasi').val(response.nama_jenis_akreditasi);
				$('#modalAdd').modal('show');
			}
		});
    }

    // Delete Data
    function _deleteData(data_id) {
		Swal.fire({title: 'Apakah Kamu Yakin?',text: "Menghapus data ini?",icon: 'warning',showCancelButton:true,confirmButtonColor: '#3085d6',cancelButtonColor: '#d33',confirmButtonText:'Hapus!',cancelButtonText: "Batal",
		}).then((result) => {
			if (result.isConfirmed) {
				var url = '{{ route("pengelola-data-jenis-akreditasi.destroy", ":data_id") }}';
    				url = url.replace(':data_id', data_id);
				$.ajax({
					url: url,
					type: "DELETE",
					dataType: "JSON",
					cache: false,
					success:function(response){
						if (response.success) {
							Swal.fire({ icon:'success', title: 'Sukses...', html: 'Sukses menghapus data' });
							table.draw();
						}else {
							Swal.fire({ icon:'warning', title: 'Gagal menghapus data...', html: 'Silakan coba lagi !' });
						}
					},error:function(response){
						Swal.fire({ icon:'warning', title: 'Opps!', text: 'server error!' });
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
			const nama_jenis_akreditasi = $('#nama_jenis_akreditasi');     
			if (nama_jenis_akreditasi.val() == '') {
				Swal.fire({
					icon: 'warning',
					title: 'Maaf!',
					text: 'Nama jenis akreditasi harus diisi terlebih dahulu. terlihat saat ini masih kosong...',
					allowOutsideClick: false, 
				})     
				nama_jenis_akreditasi.focus();
				$('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
				return false;
			}       
			
			$.ajax({
				url: "{{ route('pengelola-data-jenis-akreditasi.store') }}",
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