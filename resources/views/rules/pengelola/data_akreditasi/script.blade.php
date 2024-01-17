<script type="text/javascript">
    var table; var table2;
	$.ajaxSetup({
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
    jQuery(document).ready(function() {
        load_filedok('', '#timeline_akreditasi', '#timeline_akreditasi_view');
    })
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
    //datatable
    table = $('.datatable').DataTable({
        searchDelay: 300,
        processing: true,
        serverSide: true,
		ajax: "{{ route('data-akreditasi.index') }}",
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
            {data: 'nama_jenis_akreditasi', name: 'nama_jenis_akreditasi'},
            {data: 'tahun', name: 'tahun',},
            {data: 'dasar_kegiatan', name: 'dasar_kegiatan'},
            {data: 'file_timeline', name: 'file_timeline'},
            {data: 'action', name: 'action'},
        ],
        //Set column definition initialisation properties.
        columnDefs: [
            { "width": "5%", "targets": 0, "className": "align-top text-center" },
            { "width": "25%", "targets": 1, "className": "align-top", orderable: false,},
            { "width": "5%", "targets": 2, "className": "align-top text-center" },
            { "width": "25%", "targets": 3, "className": "align-top", orderable: false,},
            { "width": "20%", "targets": 4, "className": "align-top text-center", orderable: false, searchable: false},
            { "width": "15%", "targets": 5, "className": "align-top text-center",orderable: false, searchable: false },
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
        _clearForm(), $('#card-form').hide(), $('#card-form-file').hide(), $('#card-table').show();
        $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
    }
    // clear form
    var _clearForm = function() {
        $('#form-data')[0].reset(), 
        $('[name="id"]').val(''),
        $('[name="methodform_data"]').val(''),

        $('#tahun').val('');
        load_filedok('', '#timeline_akreditasi', '#timeline_akreditasi_view');
    }
	// add data baru
	var _addData = function() {
        $('.header-title').append('Input Data Akreditasi');
        _clearForm(), $('[name="methodform_data"]').val('add'), $('#card-table').hide(), $('#card-form').show();
    }
	// edit data
	var _editData = function(data_id) {
        $('.header-title').append('Edit Data Akreditasi');
        $('#card-table').hide(), $('#card-form').show();
        $('#form-data')[0].reset(), $('[name="methodform_data"]').val('update');
         
        var url = '{{ route("data-akreditasi.edit", ":data_id") }}';
    		url = url.replace(':data_id', data_id);
		$.ajax({
            url:url,
            type: "GET",
            dataType: "JSON",
            success:function(response){
                _clearForm();
                $('[name="id"]').val(response.data.id);
		        $('[name="methodform_data"]').val('update');
                
                $('#tahun').val(response.data.tahun);
                $('#fid_jenis_akreditasi').val(response.data.fid_jenis_akreditasi);
                $('#dasar_kegiatan').val(response.data.dasar_kegiatan);
                load_filedok(response.url_timeline, '#timeline_akreditasi', '#timeline_akreditasi_view');
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
            methodform_data = $('#methodform_data'), 
            tahun = $('#tahun'), 
            fid_jenis_akreditasi = $('#fid_jenis_akreditasi'), 
            dasar_kegiatan = $('#dasar_kegiatan'), 
            timeline_akreditasi = $('#timeline_akreditasi'); 

            if (tahun.val() == '') {
                Swal.fire({  icon: 'warning', title: 'Maaf!', text: 'Tahun haru diisi, silakan lengkapi terlebih dahulu...', allowOutsideClick: false,  })  
                tahun.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            } if (fid_jenis_akreditasi.val() == '' || fid_jenis_akreditasi.val() == null) {
                Swal.fire({  icon: 'warning', title: 'Maaf!', text: 'Jenis akreditasi harus diisi, silakan lengkapi terlebih dahulu...', allowOutsideClick: false,  })  
                fid_jenis_akreditasi.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            } if (dasar_kegiatan.val() == '') {
                Swal.fire({  icon: 'warning', title: 'Maaf!', text: 'Dasar kegiatan harus diisi, silakan lengkapi terlebih dahulu...', allowOutsideClick: false,  })  
                dasar_kegiatan.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;                                                       
            }
            if($('[name="methodform_data"]').val() == 'add'){
                if (timeline_akreditasi.val() == '') {
                    Swal.fire({  icon: 'warning', title: 'Maaf!', text: 'Timeline akreditasi harus diisi, silakan lengkapi terlebih dahulu...', allowOutsideClick: false,  })  
                    timeline_akreditasi.focus();
                    $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                    return false;
                } 
            }

            $.ajax({
                url: "{{ route('data-akreditasi.store') }}",
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
                    }else if(response.is_available){
                        Swal.fire({ icon:'warning', title: 'Ooops!', text: 'Tahun yang sama pada Jenis Akreditasi ini sudah terdata...', allowOutsideClick: false, })
                    }else{  
                        $.each(response.errors, function(key,value){
                            Swal.fire({ icon:'warning', title: 'Maaf!', text: ''+value+'', allowOutsideClick: false, })
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
		Swal.fire({title: 'Apakah Kamu Yakin?',text: "Langkah ini juga akan menghapus file yang beraitan dengan data ini?",icon: 'warning',showCancelButton:true,confirmButtonColor: '#3085d6',cancelButtonColor: '#d33',confirmButtonText:'Hapus!',cancelButtonText: "Batal",
		}).then((result) => {
			if (result.isConfirmed) {
                var url = '{{ route("data-akreditasi.destroy", ":data_id") }}';
    				url = url.replace(':data_id', data_id);
				$.ajax({
					url: url,
					type: "DELETE",
					dataType: "JSON",
					cache: false,
					success:function(response){
						if (response.success) {
							Swal.fire({ icon:'success', title: 'Sukses', text: 'Data sukses dihapus...' });
							table.draw();
						}else {
							Swal.fire({ icon:'warning', title: 'Gagal menghapus data...', html: 'Silakan coba lagi !' });
						}
					}, error:function(response){
						Swal.fire({ icon:'warning', title: 'Opps!', text: 'server error!' });
					}

				});
			
			}
		}) 
	}

    // Input File
	var _inputFile = function(idp_akreditasi) {
        $('.header-title').html('Input File Akreditasi'), $('#card-table').hide(), $('#card-form-file').show(), $('#formfile-src').hide();
        load_filedok('', '#file_akreditasi', '#file_akreditasi_view'),$('[name="nama_file"]').val(''), $('[select="jenis_file"]').val('');
        $('[name="idp_akreditasi"]').val(idp_akreditasi);
        var url = '{{ route("data_akreditasi_file_input", ":data_id") }}';
    		url = url.replace(':data_id', idp_akreditasi);
		$.ajax({
            url:url,
            type: "GET",
            dataType: "JSON",
            success:function(response){
               $('#headerAkreditasi').html(response.output);
            }, error: function () {
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false); 
                Swal.fire({ 
                    icon:'error',
                    title: 'Maaf!',
                    text: 'Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.',
                    allowOutsideClick: false, 
                })   
            }
        });
        _loadDataFileAkreditasi(idp_akreditasi);
    }
    var _closeAddFileSrc = function() {
        $('#formfile-src').hide();
        load_filedok('', '#file_akreditasi', '#file_akreditasi_view'),
        $('[name="nama_file"]').val('');
        $('[select="jenis_file"]').val('');
    }
    var _addFileSrc = function() {
        $('#formfile-src').show();
    }
    function _loadDataFileAkreditasi(idp_akreditasi){
        table2 = $('#dt-fileAkreditasi').DataTable({
            searchDelay: 300,
            processing: true,
            serverSide: true,
            ajax: {
                "url" : "{{ route('load_data_akreditasi_file_input') }}",
                'type': 'POST',
                data: function ( data ) {
                    data.idp_akreditasi = idp_akreditasi;
                    data.filterJenisFile = $('#filterJenisFile').val();
                }
            },
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
                {data: 'jenis_file', name: 'jenis_file'},
                {data: 'nama_file', name: 'nama_file'},
                {data: 'file_button', name: 'file_button'},
                {data: 'action', name: 'action'},
            ],
            //Set column definition initialisation properties.
            columnDefs: [
                { "width": "5%", "targets": 0, "className": "align-top text-center" },
                { "width": "35%", "targets": 1, "className": "align-top" },
                { "width": "35%", "targets": 2, "className": "align-top" },
                { "width": "20%", "targets": 3, "className": "align-top text-center" },
                { "width": "15%", "targets": 4, "className": "align-top text-center",orderable: false, searchable: false },
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
    }
    // save file
	$(document).ready(function(){
		$('#form-file').on('submit', function(event){
            event.preventDefault();
            $('#btn-save-file').html('<i class="fa fa-spin fa-spinner"></i> Mohon Tunggu...').attr('disabled', true);
            const 
            jenis_file = $('#jenis_file'), 
            nama_file = $('#nama_file'), 
            file_akreditasi = $('#file_akreditasi'); 

            if (jenis_file.val() == '' || jenis_file.val() == null) {
                Swal.fire({  icon: 'warning', title: 'Maaf!', text: 'Jenis file harus diisi, silakan lengkapi terlebih dahulu...', allowOutsideClick: false,  })  
                jenis_file.focus();
                $('#btn-save-file').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            } if (nama_file.val() == '') {
                Swal.fire({  icon: 'warning', title: 'Maaf!', text: 'Nama file harus diisi, silakan lengkapi terlebih dahulu...', allowOutsideClick: false,  })  
                nama_file.focus();
                $('#btn-save-file').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;                                                       
            }if (file_akreditasi.val() == '') {
                Swal.fire({  icon: 'warning', title: 'Maaf!', text: 'File harus diisi, silakan lengkapi terlebih dahulu...', allowOutsideClick: false,  })  
                file_akreditasi.focus();
                $('#btn-save-file').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            } 

            $.ajax({
                url: "{{ route('data_akreditasi_file_input_save') }}",
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    $('#btn-save-file').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                    if (response.success) {
                        _inputFile(response.idp_akreditasi);
                        Swal.fire({ icon:'success', title: 'Sukses...', text: 'File berhasil disimpan...' });
                    }else{  
                        $.each(response.errors, function(key,value){
                            Swal.fire({ icon:'warning', title: 'Maaf!', text: ''+value+'', allowOutsideClick: false, })
                        });  
                    }
                }, error: function () {
                    $('#btn-save-file').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false); 
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
    $('#filterJenisFile').change(function(){
        table2.draw();
    })
    function _deleteFileAkreditasi(data_id) {
		Swal.fire({title: 'Apakah Kamu Yakin?',text: "Ingin menghapus file ini?",icon: 'warning',showCancelButton:true,confirmButtonColor: '#3085d6',cancelButtonColor: '#d33',confirmButtonText:'Hapus!',cancelButtonText: "Batal",
		}).then((result) => {
			if (result.isConfirmed) {
                var url = '{{ route("data_akreditasi_file_input_destroy", ":data_id") }}';
    				url = url.replace(':data_id', data_id);
				$.ajax({
					url: url,
					type: "GET",
					dataType: "JSON",
					cache: false,
					success:function(response){
						if (response.success) {
							Swal.fire({ icon:'success', title: 'Sukses', text: 'Data sukses dihapus...' });
							table2.draw();
						}else {
							Swal.fire({ icon:'warning', title: 'Gagal menghapus data...', html: 'Silakan coba lagi !' });
						}
					}, error:function(response){
						Swal.fire({ icon:'warning', title: 'Opps!', text: 'server error!' });
					}

				});
			
			}
		}) 
	}
</script>