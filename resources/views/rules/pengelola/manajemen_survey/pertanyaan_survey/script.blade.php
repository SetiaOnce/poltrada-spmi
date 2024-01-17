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
		ajax: '/pengelola/manajemen-survey/kelola_pertanyaan_survey/'+"{{ $namaSurvey->id }}",
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
            {data: 'pertanyaan', name: 'pertanyaan'},
            {data: 'role_jenis', name: 'role_jenis'},
            {data: 'action', name: 'action'},
        ],
        //Set column definition initialisation properties.
        columnDefs: [
            { "width": "5%", "targets": 0, "className": "align-top text-center" },
            { "width": "45%", "targets": 1, "className": "align-top" },
            { "width": "20%", "targets": 2, "className": "align-top" },
            { "width": "10%", "targets": 3, "className": "align-top text-center", orderable: false, searchable: false},
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

			$('#pertanyaan').val('');
			$('#jenis').val('');
			$('#pilihan1').val('');
			$('#pilihan2').val('');
			$('#pilihan3').val('');
			$('#pilihan4').val('');
			$('#pilihan5').val('');
			$('#keterangan').val('');
    }

	// add data baru
	var _addData = function() {
        $('.header-title').append('Input Data Pertanyaan Survey Baru');
        _clearForm(), $('[name="methodform_data"]').val('add'), $('#card-table').hide(), $('#card-form').show();
    }

    $(document).ready(function(){
        $('select[name="jenis"]').on('change',function(){
            var data_id = $(this).val();
            if(data_id == 0){
                $("#pilihan1").val('');
                $("#pilihan2").val('');
                $("#pilihan3").val('');
                $("#pilihan4").val('');
                $("#pilihan5").val('');
                $("#pilihan1").prop("readonly", true);
                $("#pilihan2").prop("readonly", true);
                $("#pilihan3").prop("readonly", true);
                $("#pilihan4").prop("readonly", true);
                $("#pilihan5").prop("readonly", true);
            }else if(data_id ==1){
                $("#pilihan1").val('1');
                $("#pilihan2").val('2');
                $("#pilihan3").val('3');
                $("#pilihan4").val('4');
                $("#pilihan5").val('5');
                $("#pilihan1").prop("readonly", true);
                $("#pilihan2").prop("readonly", true);
                $("#pilihan3").prop("readonly", true);
                $("#pilihan4").prop("readonly", true);
                $("#pilihan5").prop("readonly", true);
            }else if(data_id ==2){
                $("#pilihan1").val('Ya');
                $("#pilihan2").val('Tidak');
                $("#pilihan3").val('');
                $("#pilihan4").val('');
                $("#pilihan5").val('');
                $("#pilihan1").prop("readonly", true);
                $("#pilihan2").prop("readonly", true);
                $("#pilihan3").prop("readonly", true);
                $("#pilihan4").prop("readonly", true);
                $("#pilihan5").prop("readonly", true);
            }

        });
    });

	// edit data
	var _editData = function(data_id) {
        $('.header-title').append('Edit Data Pertanyaan Survey');
        $('#card-table').hide(), $('#card-form').show();
        $('#form-data')[0].reset(), $('[name="methodform_data"]').val('update');

        var url = '{{ route("pertanyaan-survey.edit", ":data_id") }}';
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
                $('#pertanyaan').val(response.data.pertanyaan);
                $('#jenis').val(response.data.jenis);
                $('#keterangan').val(response.data.keterangan);

                if(response.data.jenis == 0){
                    $("#pilihan1").val('');
                    $("#pilihan2").val('');
                    $("#pilihan3").val('');
                    $("#pilihan4").val('');
                    $("#pilihan5").val('');
                    $("#pilihan1").prop("readonly", true);
                    $("#pilihan2").prop("readonly", true);
                    $("#pilihan3").prop("readonly", true);
                    $("#pilihan4").prop("readonly", true);
                    $("#pilihan5").prop("readonly", true);
                }else if(response.data.jenis ==1){
                    $('#pilihan1').val(response.data.pilihan1);
                    $('#pilihan2').val(response.data.pilihan2);
                    $('#pilihan3').val(response.data.pilihan3);
                    $('#pilihan4').val(response.data.pilihan4);
                    $('#pilihan5').val(response.data.pilihan5);
                    $("#pilihan1").prop("readonly", true);
                    $("#pilihan2").prop("readonly", true);
                    $("#pilihan3").prop("readonly", true);
                    $("#pilihan4").prop("readonly", true);
                    $("#pilihan5").prop("readonly", true);
                }else if(response.data.jenis ==2){
                    $('#pilihan1').val(response.data.pilihan1);
                    $('#pilihan2').val(response.data.pilihan2);
                    $('#pilihan3').val(response.data.pilihan3);
                    $('#pilihan4').val(response.data.pilihan4);
                    $('#pilihan5').val(response.data.pilihan5);
                    $("#pilihan1").prop("readonly", true);
                    $("#pilihan2").prop("readonly", true);
                    $("#pilihan3").prop("readonly", true);
                    $("#pilihan4").prop("readonly", true);
                    $("#pilihan5").prop("readonly", true);
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
    }

	// save data
	$(document).ready(function(){
		$('#form-data').on('submit', function(event){
            event.preventDefault();
            $('#btn-save').html('<i class="fa fa-spin fa-spinner"></i> Mohon Tunggu...').attr('disabled', true);
            const   
            pertanyaan = $('#pertanyaan'), 
            jenis = $('#jenis'), 
            pilihan1 = $('#pilihan1'),
            pilihan2 = $('#pilihan2'),
            pilihan3 = $('#pilihan3'),
            pilihan4 = $('#pilihan4');    
            pilihan5 = $('#pilihan5');    
            if (pertanyaan.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Pertanyaan survey masih kosong, silakan lengkapi terlebih dahulu...',
                    allowOutsideClick: false, 
                })
                pertanyaan.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }     
            if (jenis.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Jenis masih kosong, silakan lengkapi terlebih isi dahulu...',
                    allowOutsideClick: false, 
                })
                jenis.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }
            // if (jenis.val() == 1) {
            //     if (pilihan1.val() == '') {
            //         Swal.fire({ 
            //             icon: 'warning',
            //             title: 'Maaf!',
            //             text: 'Pilihan 1 masih kosong, silakan lengkapi terlebih isi dahulu...',
            //             allowOutsideClick: false, 
            //         })
            //         pilihan1.focus();
            //         $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
            //         return false;
            //     }
            //     if (pilihan2.val() == '') {
            //         Swal.fire({ 
            //             icon: 'warning',
            //             title: 'Maaf!',
            //             text: 'Pilihan 1 masih kosong, silakan lengkapi terlebih isi dahulu...',
            //             allowOutsideClick: false, 
            //         })
            //         pilihan2.focus();
            //         $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
            //         return false;
            //     }
            //     if (pilihan3.val() == '') {
            //         Swal.fire({ 
            //             icon: 'warning',
            //             title: 'Maaf!',
            //             text: 'Pilihan 1 masih kosong, silakan lengkapi terlebih isi dahulu...',
            //             allowOutsideClick: false, 
            //         })
            //         pilihan3.focus();
            //         $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
            //         return false;
            //     }
            //     if (pilihan4.val() == '') {
            //         Swal.fire({ 
            //             icon: 'warning',
            //             title: 'Maaf!',
            //             text: 'Pilihan 1 masih kosong, silakan lengkapi terlebih isi dahulu...',
            //             allowOutsideClick: false, 
            //         })
            //         pilihan4.focus();
            //         $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
            //         return false;
            //     }
            // }
        
            $.ajax({
                url: "{{ route('pertanyaan-survey.store') }}",
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
                var url = '{{ route("pertanyaan-survey.destroy", ":data_id") }}';
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