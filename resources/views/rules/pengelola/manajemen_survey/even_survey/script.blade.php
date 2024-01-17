<script type="text/javascript">
	$.ajaxSetup({
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

    // datatable
    var table = $('.datatable').DataTable({
        searchDelay: 300,
        processing: true,
        serverSide: true,
		ajax: "{{ route('even-survey.index') }}",
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
            {data: 'namaSurvey', name: 'namaSurvey'},
            {data: 'periode_awal', name: 'periode_awal'},
            {data: 'periode_akhir', name: 'periode_akhir'},
            {data: 'action', name: 'action'},
        ],
        //Set column definition initialisation properties.
        columnDefs: [
            { "width": "5%", "targets": 0, "className": "align-top text-center" },
            { "width": "50%", "targets": 1, "className": "align-top" },
            { "width": "20%", "targets": 2, "className": "align-top text-center" },
            { "width": "20%", "targets": 3, "className": "align-top text-center" },
            { "width": "5%", "targets": 4, "className": "align-top text-center", orderable: false, searchable: false},
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

        $('#priode_evaluasi_diri_awal').val('');
        $('#priode_evaluasi_diri_akhir').val('');
    }

	// add data baru
	var _addData = function() {
        $('.header-title').append('Input Data Even Survey Baru');
        _clearForm(), $('[name="methodform_data"]').val('add'), $('#card-table').hide(), $('#card-form').show();
    }
    
	// edit data
	var _editData = function(data_id) {
        $('.header-title').append('Edit Data Even Survey');
        $('#card-table').hide(), $('#card-form').show();
        $('#form-data')[0].reset(), $('[name="methodform_data"]').val('update');

        var url = '{{ route("even-survey.edit", ":data_id") }}';
    		url = url.replace(':data_id', data_id);
		$.ajax({
            url:url,
            type: "GET",
            dataType: "JSON",
            success:function(response){
                _clearForm();
                $('[name="id"]').val(response.data.id),
		        $('[name="methodform_data"]').val('update');

                $('#nama_survey_id').val(response.data.nama_survey_id);
                $('#priode_evaluasi_diri_awal').val(response.data.priode_evaluasi_diri_awal);
                $('#priode_evaluasi_diri_akhir').val(response.data.priode_evaluasi_diri_akhir);

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
            const nama_survey_id = $('#nama_survey_id'), periode_awal = $('#priode_evaluasi_diri_awal'),periode_akhir = $('#priode_evaluasi_diri_akhir');
            if (nama_survey_id.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Nama survey tidak boleh kosong, silakan lengkapi terlebih dahulu...',
                    allowOutsideClick: false, 
                })   
                nama_survey_id.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }  
            if (periode_awal.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Priode evaluasi diri awal tidak boleh kosong, silakan lengkapi terlebih dahulu...',
                    allowOutsideClick: false, 
                })   
                periode_awal.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }  
            if (periode_akhir.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Priode evaluasi diri akhir tidak boleh kosong, silakan lengkapi terlebih dahulu...',
                    allowOutsideClick: false, 
                })   
                periode_akhir.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }  
        
            $.ajax({
                url: "{{ route('even-survey.store') }}",
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
                var url = '{{ route("even-survey.destroy", ":data_id") }}';
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