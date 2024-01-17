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
		ajax: "{{ route('nilai-mutu.index') }}",
		columns: [
		{data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center'},
		{data: 'tahun', name: 'tahun'},
		{data: 'lembaga', name: 'lembaga'},
		{data: 'prodi', name: 'prodi'},
		{data: 'target_nilai', name: 'target_nilai', className: 'text-center'},
		{data: 'action', name: 'action', orderable: false, searchable: false},
		]
	});

    //datatable
    // var table = $('.datatable').DataTable({
    //     searchDelay: 300,
    //     processing: true,
    //     serverSide: true,
    //     ajax: "{{ route('pengelola.kegiatan.index') }}",
    //     destroy: true,
    //     draw: true,
    //     deferRender: true,
    //     responsive: false,
    //     autoWidth: false,
    //     LengthChange: true,
    //     paginate: true,
    //     pageResize: true,
    //     columns: [
    //         {data: 'DT_RowIndex', name: 'DT_RowIndex'},
    //         {data: 'jenis_kegiatan', name: 'jenis_kegiatan'},
    //         {data: 'judul_kegiatan', name: 'judul_kegiatan'},
    //         {data: 'foto', name: 'foto',className:'text-center', searchable: false},
    //         {data: 'action', name: 'action', className:'d-sm-flex', orderable: false, searchable: false},
    //     ],
    //     //Set column definition initialisation properties.
    //     columnDefs: [
    //         { "width": "5%", "targets": 0, "className": "align-top text-center" },
    //         { "width": "20%", "targets": 1, "className": "align-top" },
    //         { "width": "60%", "targets": 2, "className": "align-top" },
    //         { "width": "5%", "targets": 3, "className": "align-top", orderable: false, searchable: false},
    //         { "width": "10%", "targets": 4, "className": "align-top text-center",orderable: false, searchable: false },
    //     ],
    //     oLanguage: {
    //         sSearch : "<i class='mdi mdi-magnify'></i>",
    //         sSearchPlaceholder: "Pencarian...",
    //         sEmptyTable: "Tidak ada Data yang dapat ditampilkan..",
    //         sInfo: "Menampilkan _START_ s/d _END_ dari _TOTAL_",
    //         sInfoEmpty: "Menampilkan 0 - 0 dari 0 entri.",
    //         sInfoFiltered: "",
    //         sProcessing: `<div class="d-flex justify-content-center align-items-center"><div class="blockui-message"><span class="spinner-border text-primary align-middle me-2"></span> Mohon Tunggu...</div></div>`,
    //         sZeroRecords: "Tidak ada Data yang dapat ditampilkan..",
    //         sLengthMenu : "Tampilkan _MENU_ Entri",
    //         oPaginate: {
    //             sPrevious: "Sebelumnya",
    //             sNext: "Selanjutnya",
    //         },
    //     },

    //     fnDrawCallback: function (settings, display) {
    //         $('[data-bs-toggle="tooltip"]').tooltip("dispose"), $(".tooltip").hide();
    //         //Custom Table
    //         $('[data-bs-toggle="tooltip"]').tooltip({ 
    //             trigger: "hover"
    //         }).on("click", function () {
    //             $(this).tooltip("hide");
    //         });
    //     },
    // });
    // $(".datatable").css("width", "100%");

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
        $('#tahun').val('');
        $('#lembaga_akreditasi_id').val('');
        $('#unit_prodi_id').val('');
        $('#target_nilai').val('');
        $('#keterangan').val('');
    }

	// add data baru
	var _addData = function() {
        $('.header-title').append('Input Data Target Nilai Mutu Baru');
        _clearForm(), $('[name="methodform_data"]').val('add'), $('#card-table').hide(), $('#card-form').show();
    }
    
    // edit data
    var _editData = function(data_id) {
        $('.header-title').append('Edit Data Target Nilai Mutu');
        $('#card-table').hide(), $('#card-form').show();
        $('#form-data')[0].reset(), $('[name="methodform_data"]').val('update');

        var url = '{{ route("nilai-mutu.edit", ":data_id") }}';
    		url = url.replace(':data_id', data_id);
		$.ajax({
            url:url,
            type: "GET",
            dataType: "JSON",
            success:function(response){
                _clearForm();
                $('[name="id"]').val(response.data.id),
		        $('[name="methodform_data"]').val('update'),
                
                $('#tahun').val(response.data.tahun);
                $('#lembaga_akreditasi_id').val(response.data.lembaga_akreditasi_id);
                $('#unit_prodi_id').val(response.data.unit_prodi_id);
                $('#target_nilai').val(response.data.target_nilai);
                $('#keterangan').val(response.data.keterangan);

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
            const 
            tahun = $('#tahun'), 
            lembaga_akreditasi_id = $('#lembaga_akreditasi_id'), 
            unit_prodi_id = $('#unit_prodi_id'), 
            target_nilai = $('#target_nilai'), 
            keterangan = $('#keterangan');
            if (tahun.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Tahun masih kosong, silakan lengkapi terlebih dahulu...',
                    allowOutsideClick: false, 
                })    
                tahun.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }     
            if (lembaga_akreditasi_id.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Lembaga akreditasi masih kosong, silakan lengkapi terlebih isi dahulu...',
                    allowOutsideClick: false, 
                })    
                lembaga_akreditasi_id.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }     
            if (unit_prodi_id.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Unit Prodi masih kosong, silakan lengkapi terlebih dahulu...',
                    allowOutsideClick: false, 
                })    
                unit_prodi_id.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }
            if (target_nilai.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Target nilai masih kosong, silakan lengkapi terlebih dahulu...',
                    allowOutsideClick: false, 
                })    
                target_nilai.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }
            if (keterangan.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Keterangan masih kosong, silakan lengkapi terlebih dahulu...',
                    allowOutsideClick: false, 
                })    
                keterangan.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }
            
            $.ajax({
                url: "{{ route('nilai-mutu.store') }}",
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
                var url = '{{ route("nilai-mutu.destroy", ":data_id") }}';
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