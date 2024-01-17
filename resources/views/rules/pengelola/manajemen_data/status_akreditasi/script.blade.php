<script type="text/javascript">
	 $.ajaxSetup({
		headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
    jQuery(document).ready(function() {
        load_filedok('', '#file_sertifikat', '#file_sertifikat_view');
        $(".inputYear").datepicker({
            autoclose: true,
            format: "yyyy",
            viewMode: "years", 
            minViewMode: "years"
        });
        $(".inputDate").datepicker({
            autoclose: true,
            format: "dd/mm/yyyy",
        });
    })
	//datatable
    var table = $('#dt-statusAkreditasi').DataTable({
        searchDelay: 300,
        processing: true,
        serverSide: true,
        ajax: "{{ route('pengelola.statusakreditasi.index') }}",
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
            {data: 'program', name: 'program'},
            {data: 'Unit_prodi', name: 'Unit_prodi'},
            {data: 'status_peringkat', name: 'status_peringkat'},
            {data: 'tahun_sk', name: 'tahun_sk'},
            {data: 'tanggal_kedaluarsa', name: 'tanggal_kedaluarsa'},
            {data: 'pdf', name: 'pdf'},
            {data: 'action', name: 'action'},
        ],
        //Set column definition initialisation properties.
        columnDefs: [
            { "width": "5%", "targets": 0, "className": "align-top text-center"},
            { "width": "20%", "targets": 1, "className": "align-top" },
            { "width": "40%", "targets": 2, "className": "align-top"},
            { "width": "5%", "targets": 3, "className": "align-top text-center", orderable: false,},
            { "width": "10%", "targets": 4, "className": "align-top text-center"},
            { "width": "10%", "targets": 5, "className": "align-top text-center"},
            { "width": "10%", "targets": 6, "className": "align-top text-center",orderable: false, searchable: false },
            { "width": "10%", "targets": 7, "className": "align-top text-center",orderable: false, searchable: false },
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
    // file dokumen
    function load_filedok(url_file, paramsId, paramViews){
        if(url_file==''){
            //Upload File
            $(paramsId).fileinput({
                maxFileSize: 3024, //3MB
                language: "id", showUpload: false, dropZoneEnabled: false,
                allowedFileExtensions: ["pdf"], browseClass: "btn btn-dark btn-file btn-square rounded-right",
                browseLabel: "Cari File...", showCancel: false, removeLabel: "Hapus"
            }),
            $(paramViews).html('').hide();
        }else{
            // Upload File
            $(paramsId).fileinput({
                maxFileSize: 3024, //3MB
                language: "id", showUpload: false, dropZoneEnabled: false,
                allowedFileExtensions: ["pdf"], browseClass: "btn btn-dark btn-file btn-square rounded-right",
                browseLabel: "Cari File...", showCancel: false, removeLabel: "Hapus"
            });
            var setToView = `<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="` +url_file+ `" height="100%" frameborder="0">Your browser does not support open file <code>` +url_file+ `</code>.</iframe></div>`;
            $(paramViews).html(setToView).show();
        }
    }
	// close form
    var _closeForm = function() {
        $('.header-title').html('');
        _clearForm(), $('#card-form').hide(), $('#card-table').show();
    }
    // clear form
    var _clearForm = function() {
        $('#form-data')[0].reset(), 
        load_filedok('', '#file_sertifikat', '#file_sertifikat_view');
    }
	// add data baru
	var _addData = function() {
        $('.header-title').append('Input Data Status Akreditasi Baru');
        _clearForm(), $('[name="methodform_data"]').val('add'), $('#card-table').hide(), $('#card-form').show();
    }
	// edit data
	var _editData = function(data_id) {
        $('.header-title').append('Edit Data Status Akreditasi');
        // $('#card-table').hide(), $('#card-form').show();
        $('#form-data')[0].reset(), $('[name="methodform_data"]').val('update');
        
        var url = '{{ route("pengelola.statusakreditasi.edit", ":data_id") }}';
    		url = url.replace(':data_id', data_id);
		$.ajax({
            url:url,
            type: "GET",
            dataType: "JSON",
            success:function(response){
                $('[name="id"]').val(response.row.id),
		        $('[name="methodform_data"]').val('update'),

                $('select[name="fid_program_studi"]').val(response.row.fid_program_studi)
                $('#program').val(response.row.program);
                $('#status_peringkat').val(response.row.status_peringkat);
                $('#tahun_sk').val(response.row.tahun_sk);
                $('#tanggal_kedaluarsa').val(response.row.tanggal_kedaluarsa);

                $(".inputYear").datepicker("setDate", response.row.tahun_sk);
                $(".inputDate").datepicker("setDate", response.tanggal_kedaluarsa);

                load_filedok(response.url_file, '#file_sertifikat', '#file_sertifikat_view');
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
            const fid_program_studi = $('#fid_program_studi'), program = $('#program'), status_peringkat = $('#status_peringkat'), tahun_sk = $('#tahun_sk'), tanggal_kedaluarsa = $('#tanggal_kedaluarsa'), file_sertifikat = $('#file_sertifikat');   
            if (fid_program_studi.val() == '' || fid_program_studi.val() == null) {
                Swal.fire({  icon: 'warning', title: 'Maaf!', text: 'Program Studi harus diisi, terlihat saat ini masih kosong.', allowOutsideClick: false,  })  
                fid_program_studi.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            } if (program.val() == '') {
                Swal.fire({  icon: 'warning', title: 'Maaf!', text: 'Program harus diisi, terlihat saat ini masih kosong.', allowOutsideClick: false,  })   
                program.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            } if (status_peringkat.val() == '') {
                Swal.fire({  icon: 'warning', title: 'Maaf!', text: 'Status peringkat harus diisi, terlihat saat ini masih kosong.', allowOutsideClick: false,  })   
                status_peringkat.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            } if (tahun_sk.val() == '') {
                Swal.fire({  icon: 'warning', title: 'Maaf!', text: 'Tahun SK harus diisi, terlihat saat ini masih kosong.', allowOutsideClick: false,  })   
                tahun_sk.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            } if (tanggal_kedaluarsa.val() == '') {
                Swal.fire({icon: 'warning', title: 'Maaf!', text: 'Tanggal kedaluarsa harus diisi, terlihat saat ini masih kosong.', allowOutsideClick: false,})
                tanggal_kedaluarsa.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }    
            if($('[name="methodform_data"]').val() == 'add'){
                if (file_sertifikat.val() == '') {
                    Swal.fire({  icon: 'warning', title: 'Maaf!', text: 'File sertifikat harus diisi, silakan lengkapi terlebih dahulu...', allowOutsideClick: false,  })  
                    file_sertifikat.focus();
                    $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                    return false;
                } 
            }
            
            $.ajax({
                url: "{{ route('pengelola.statusakreditasi.store') }}",
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
                        Swal.fire({ icon:'success', title: 'Sukses...', html: 'Data sukses disimpan' });
                        table.draw();
                    }else{  
                        $.each(response.errors, function(key,value){
                            Swal.fire({  icon:'warning', title: 'Maaf!', text: ''+value+'', allowOutsideClick: false,})
                        });  
                    }
                }, error: function () {
                    $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false); 
                    Swal.fire({  icon: 'warning', title: 'Maaf!', text: 'Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.', allowOutsideClick: false,  })   
                }
            });
        });
    });

	// Hapus Data
	function _deleteData(data_id) {
        Swal.fire({title: 'Apakah Kamu Yakin?',text: "Menghapus data ini?",icon: 'warning',showCancelButton:true,confirmButtonColor: '#3085d6',cancelButtonColor: '#d33',confirmButtonText:'Hapus!',cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                var url = '{{ route("pengelola.statusakreditasi.delete", ":data_id") }}';
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
								html: 'Sukses menghapus data status akreditasi'
							});
							table.draw();
						}else {
							Swal.fire({
                                icon:'warning',
                                title: 'Gagal menghapus data status akreditasi...',
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