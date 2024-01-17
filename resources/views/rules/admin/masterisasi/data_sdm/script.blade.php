<script type="text/javascript">
	$.ajaxSetup({
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

    //  datatable
	var table = $('.datatable').DataTable({
		processing: true,
		serverSide: true,
		ajax: "{{ route('ajax.data.sdm') }}",
		columns: [
			{data: 'DT_RowIndex', name: 'DT_RowIndex'},
			{data: 'dataNama', name: 'dataNama'},
			{data: 'dataAlamat', name: 'dataAlamat'},
			{data: 'dataEmail', name: 'dataEmail'},
			{data: 'dataJenisKelamin', name: 'dataJenisKelamin'},
			{data: 'dataTanggalLahir', name: 'dataTanggalLahir'},
			{data: 'dataTelepon', name: 'dataTelepon'},
			{data: 'foto', name: 'foto'},
		],
        oLanguage       : {
            sSearch     : "<i class='fa fa-search'></i>",
            sSearchPlaceholder: "Pencarian...",
            sEmptyTable : "Tidak ada Data yang dapat ditampilkan..",
            sInfo       : "Menampilkan _START_ s/d _END_ dari _TOTAL_ entri.",
            sInfoEmpty  : "Menampilkan 0 - 0 dari 0 entri.",
            sInfoFiltered : "",
            sProcessing : "<span class='text-center'><i class='fa fa-spin fa-spinner'></i> Mohon Tunggu...</span>",
            sZeroRecords: "Tidak ada Data yang dapat ditampilkan..",
            sLengthMenu : "Tampilkan _MENU_",
            oPaginate   : {
                sPrevious    : "Sebelumnya",
                sNext        : "Selanjutnya"
            }
        },
	});

	// ajax sinkrinosasi data sdm 
	function _sincronisasi() {
		Swal.fire({title: 'Apakah Kamu Yakin?',text: "Ingin Mensinkronisasi data ini?",icon: 'warning',showCancelButton:true,confirmButtonColor: '#3085d6',cancelButtonColor: '#d33',confirmButtonText:'Sinkronisasi',cancelButtonText: "Batal",
		}).then((result) => {
			if (result.isConfirmed) {
				$('#btn-sinkron').html('<i class="fa fa-spin fa-spinner"></i> Mohon Tunggu...').attr('disabled', true);
				$.ajax({
					url: "{{ route('ajax.data.sdm.sinkron') }}",
					method: 'GET',
					dataType: 'JSON',
					contentType: false,
					cache: false,
					processData: false,
					success: function (response) {
						$('#btn-sinkron').html('<i class="ri-cast-fill align-middle me-1"></i> Sinkronisasi').attr('disabled', false);
						
						if (response.success) {
							Swal.fire({
								icon:'success',
								title: 'Sukses...',
								html: 'Data berhasil disinkronisasi'
							});
							table.draw();
						}else{  
							Swal.fire({ 
								icon:'warning',
								title: 'Maaf!',
								text: 'Gagal mensinkronisasi data',
								allowOutsideClick: false, 
							}) 
						}
					}, error: function () {
						$('#btn-sinkron').html('<i class="ri-cast-fill align-middle me-1"></i> Sinkronisasi').attr('disabled', false);
						Swal.fire({ 
							icon:'warning',
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