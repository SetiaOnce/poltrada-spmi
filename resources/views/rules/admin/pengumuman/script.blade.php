<script type="text/javascript">
	$.ajaxSetup({
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	
    //script Review Image
	$(document).ready(function(){
		$('#foto_pengumuman').change(function(e){
			var reader = new FileReader();
			reader.onload = function(e){
				$('#showImage').attr('src',e.target.result);
			}
			reader.readAsDataURL(e.target.files['0']);
		});
	});

	// script Tutup Modal
	var _tutup = function (){
		$('#showImage').attr('src','{{ asset("img/no-image.png") }}');
	}
		
	//datatable
	var table = $('.datatable').DataTable({
        searchDelay: 300,
        processing: true,
        serverSide: true,
		ajax: "{{ route('pengumuman.index') }}",
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
			{data: 'foto', name: 'foto'},
			{data: 'keterangan', name: 'keterangan'},
			{data: 'status', name: 'status'},
			{data: 'action', name: 'action'},
        ],
        //Set column definition initialisation properties.
        columnDefs: [
            { "width": "5%", "targets": 0, "className": "align-top text-center" },
            { "width": "35%", "targets": 1, "className": "align-top" },
            { "width": "40%", "targets": 2, "className": "align-top" },
            { "width": "10%", "targets": 3, "className": "align-top text-center" },
            { "width": "10%", "targets": 4, "className": "align-top text-center", orderable: false, searchable: false},
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

	//clear form
	var _clearForm = function() {
		$('#form-data')[0].reset(), 
		$('[name="id"]').val(''),
		$('[name="methodform_data"]').val(''),
		$('#foto_pengumuman').val('');
		$('#keterangan').val('');
	}

	// edit status
	function editStatus(data_id) {
		Swal.fire({
			title: 'Apakah Kamu Yakin?',text: "Ingin ingin mengubah status banner ini?",icon: 'warning',showCancelButton: true,confirmButtonColor: '#3085d6',cancelButtonColor: '#d33',confirmButtonText: 'Lanjutkan!',cancelButtonText: "Batal",
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: "{{  url('/admin/pengumuman/edit-status') }}/"+data_id,
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

	// show modal edit
	function _editData(data_id) {
		$('#modalAdd').modal('show');
		_clearForm();
		$('#headeTitle').html('');
		$('#headeTitle').append('Edit Konten Pengumuman');
		$('[name="id"]').val(data_id);
		$('[name="methodform_data"]').val('update');

		var url = '{{ route("pengumuman.edit", ":data_id") }}';
    		url = url.replace(':data_id', data_id);
		$.ajax({
				url:url,
                type: "GET",
                dataType: "JSON",
                success:function(response){
				$('#keterangan').val(response.keterangan);
				$('#showImage').attr('src','{{ asset("") }}'+response.foto_pengumuman+'');
                }

            });
	}

	// Save Data
	$(document).ready(function(){
		$('#form-data').on('submit', function(event){
			event.preventDefault();
			$('#btn-save').html('<i class="fa fa-spin fa-spinner"></i> Mohon Tunggu...').attr('disabled', true);

			const keterangan = $('#keterangan');     
			if (keterangan.val() == '') {
				Swal.fire({
					icon: 'warning',
					title: 'Maaf!',
					text: 'Keterangan tidak boleh kosong...',
					allowOutsideClick: false,
				})
				keterangan.focus();
				$('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
				return false;
			}

			$.ajax({
				url: "{{ route('pengumuman.store') }}",
				method: 'POST',
				data: new FormData(this),
				dataType: 'JSON',
				contentType: false,
				cache: false,
				processData: false,
				success: function (response) {
					$('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
					
					if (response.success) {
						$('#modalAdd').modal('hide'),_tutup(),_clearForm();
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