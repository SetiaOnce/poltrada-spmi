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
		ajax: "{{ route('prodi.pengajuan.audit.index') }}",
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
            {data: 'tahun', name: 'tahun'},
            {data: 'nama_lembaga', name: 'nama_lembaga'},
            {data: 'jenis_standar', name: 'jenis_standar'},
            {data: 'tgl_input', name: 'tgl_input'},
            {data: 'status', name: 'status', className:'text-center'},
            {data: 'ajukan', name: 'ajukan', className:'text-center', orderable: false, searchable: false},
            {data: 'action', name: 'action', className:'text-center', orderable: false, searchable: false},
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

    // mengambil data jenis standar mutu
    $(document).ready(function(){
        $('select[name="priode_evaluasi_id"]').on('change',function(){
            var data_id = $(this).val();
            if (data_id) {
                
                var url = '{{ route("ajax.get.jenis.standar.mutu", ":data_id") }}';
                url = url.replace(':data_id', data_id);

                $.ajax({
                    url: url,
                    type:"GET",
                    dataType:"json",
                    success:function(response) {
                        $('#informasi-data-dukung').show();
                        $('#jenis_standar_mutu_id').html('')
                        $('#data-pendukung').html('')
                        $('#data-asesor').html('')
                        $('#jenis_standar_mutu_id').append(' <option value="'+response.data.id+'">'+response.data.jenis_standar_mutu+'</option>')
                        $('#data-pendukung').append(response.data.data_dukung)
                        $.each(response.asesor, function(key,value){
                                var $key = key + 1;
                                $('#data-asesor').append(''+$key+'. '+value.name+'<br>');
                        })
                        
                        
                    },
                });

            }else{
                Swal.fire({
                    icon:'warning',
                    title: 'Id tidak ditemukan...',
                    html: 'Silakan coba lagi !'
                });
            }

        });
    });
    
	// close form
    var _closeForm = function() {
        $('.header-title').html('');
        _clearForm(), $('#card-form').hide(),$('#card-detail').hide(), $('#informasi-data-dukung').hide(), $('#card-table').show();
        $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
    }

    // clear form
    var _clearForm = function() {
        $('#form-data')[0].reset(), 
        $('[name="id"]').val(''),
        $('[name="methodform_data"]').val(''),
        $('#tgl_input').val('');
        $('#jenis_standar_mutu_id').html('');
    }

	// add data baru
	var _addData = function() {
        $('.header-title').append('Input Pengajuan Audit Baru');
        _clearForm(), $('[name="methodform_data"]').val('add'), $('#card-table').hide(), $('#card-form').show();
    }

    // detail pengajuan
    function _detailPengajuan(data_id){
        $('#card-detail').show(), $('#card-table').hide();
        $("#detail_daftar_temuan").html('')
        $("#detail_daftar_rekomendasi").html('')
	    $("#detail_asesor").html('')

        $("#detail_unit_prodi").html('');
        $("#detail_tahun").html('');
        $("#detail_nama_lembaga").html('');
        $("#detail_jenis_standar_mutu").html('');
        $("#detail_per_awal").html('');
        $("#detail_per_akhir").html('');
        $("#detail_tgl_input").html('');

        $("#detail_tanggal_pembahasan").html('');
        $('#detail_file_pembahasan').html('');
        $("#detail_resume_pembahsan").html('');
        $("#detail_data_pendukung").html('');

        var url = '{{ route("prodi.ajax.get.detail.pengajuan", ":data_id") }}';
    		url = url.replace(':data_id', data_id);
            $.ajax({
            url:url,
            type: "GET",
            dataType: "JSON",
            success:function(response){
                console.log(response.data);
                $("#detail_unit_prodi").append(': '+response.unit_prodi+'');
                $("#detail_tahun").append(': '+response.tahun+'');
                $("#detail_nama_lembaga").append(': '+response.jenis_standar+'');
                $("#detail_jenis_standar_mutu").append(': '+response.nama_lembaga+'');
                $("#detail_per_awal").append(': '+response.priode_awal+'');
                $("#detail_per_akhir").append(': '+response.priode_akhir+'');
                $("#detail_tgl_input").append(': '+response.tgl_input+'');

                $("#detail_asesor").append(': ')
                $.each(response.asesor, function(key,value){
                    $("#detail_asesor").append('<mark>'+value.name+'</mark>, ')
				});
                
                $.each(response.data, function(key,value){
					var $key = key + 1;
					$("#detail_data_pendukung").append('<tr>\
								<td align="center">'+$key+'</td>\
								<td>'+value.nama_dokumen+'</td>\
								<td align="center"><a href="{{ asset("") }}'+value.file_permohonan+'" data-bs-original-title="Lihat File Pdf" title="Lihat File Pdf" data-bs-placement="top" data-bs-toggle="tooltip" target="_blank" target="_blank">\
                                <img src="{{ asset("img/pdf-image.jpg") }}" alt="avatar-4" class=" avatar-md">\
                                </a></td>')
				});
                
                $.each(response.temuan, function(key,value){
                    var $key = key + 1;
                    $("#detail_daftar_temuan").append('<tr>\
                                <td align="center">'+$key+'</td>\
                                <td>'+value.name+'</td>\
                                <td >'+value.temuan+'</td>')
                });

                $.each(response.rekomendasi, function(key,value){
                    var $key = key + 1;
                    $("#detail_daftar_rekomendasi").append('<tr>\
                                <td align="center">'+$key+'</td>\
                                <td>'+value.name+'</td>\
                                <td >'+value.rekomendasi+'</td>\
                                <td >'+value.tanggal_akhir+'</td>')
                });

                var check = response.laporan_akhir;
                if(check == null){
                    $("#detail_tanggal_pembahasan").append(': ');
                    $('#detail_file_pembahasan').append(': ');
                    $("#detail_resume_pembahsan").append(':');
                    
                }else{
                    $("#detail_tanggal_pembahasan").append(': '+response.laporan_akhir.tgl_pembahasan);
                    $('#detail_file_pembahasan').append(': <a href="{{ asset("") }}'+response.laporan_akhir.file_pembahasan+'" id="showPdf" data-bs-original-title="Lihat File Pembahasan" data-bs-placement="top" data-bs-toggle="tooltip" target="_blank"><img  src="{{ asset("img/pdf-image.jpg") }}" alt="avatar-4" class=" avatar-md"> </a>');
                    $("#detail_resume_pembahsan").append(response.laporan_akhir.resume_pembahasan);
                }

            }, error: function () {
                Swal.fire({ 
                    icon:'error',
                    title: 'Maaf!',
                    text: 'Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.',
                    allowOutsideClick: false, 
                })   
            }

        });
    }

    // pengajuan data
    function _ajukanData(data_id){
        Swal.fire({title: 'Apakah Kamu Yakin?',text: "Ingin melanjutkan langkah pengajuan audit pada data ini?",icon: 'warning',showCancelButton:true,confirmButtonColor: '#3085d6',cancelButtonColor: '#d33',confirmButtonText:'Ajukan!',cancelButtonText: "Batal",
        // Swal.fire({title: 'Apakah Kamu Yakin?',text: "jika kamu melakukan langkah ini kamu tidak dapat lagi mengedit ataupun menambahkan file pendukung pada data ini?",icon: 'warning',showCancelButton:true,confirmButtonColor: '#3085d6',cancelButtonColor: '#d33',confirmButtonText:'Ajukan!',cancelButtonText: "Batal",
        }).then((result) => {
           if (result.isConfirmed) {
                var url = '{{ route("prodi.ajax.ajukan.audit", ":data_id") }}';
    				url = url.replace(':data_id', data_id);
				$.ajax({
					url: url,
					type: "GET",
					dataType: "JSON",
					cache: false,
					success:function(response){

						if (response.success) {
							Swal.fire({
								icon:'success',
								title: 'Sukses...',
								html: 'Pengajuan data sukses, Asesor akan memvalidasi data anda...'
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

    // mneampilkan dokumen pendukung
    function _dataPendukung(data_id){
        $('#modalAddData').modal('show');

        $('#pengajuan_id').val(data_id);
        $("#data_pendukung").html('')
        $("#title_jenis_standar_mutu").html('')

        //datatable
        var url = '{{ route("ajax.get.data.pendukung", ":data_id") }}';
    		url = url.replace(':data_id', data_id);
            $.ajax({
            url:url,
            type: "GET",
            dataType: "JSON",
            success:function(response){
                $("#title_jenis_standar_mutu").append(response.title.jenis_standar_mutu);
                $.each(response.data, function(key,value){
					var $key = key + 1;
					$("#data_pendukung").append('<tr>\
								<td align="center">'+$key+'</td>\
								<td>'+value.nama_dokumen+'</td>\
								<td align="center"><a href="{{ asset("") }}'+value.file_permohonan+'" data-bs-original-title="Lihat File Pdf" title="Lihat File Pdf" data-bs-placement="top" data-bs-toggle="tooltip" target="_blank" target="_blank">\
                                <img src="{{ asset("img/pdf-image.jpg") }}" alt="avatar-4" class=" avatar-md">\
                                </a></td>\
								<td align="center"><a onclick="_deleteData('+value.id+')" href="javascript:void(0)" class="waves-effect waves-light btn btn-sm btn-danger btn-circle" data-bs-original-title="Hapus Data" title="Hapus Data" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-trash-can-outline"></span></a></td>\
							    </tr>')
				});

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
        
    }
    
    // save dokumen pendukung
	$(document).ready(function(){
		$('#form-dokumen-pendukung').on('submit', function(event){
            event.preventDefault();

            $('#btn-dokumen-pendukung').html('<i class="fa fa-spin fa-spinner"></i> Mohon Tunggu...').attr('disabled', true);

            const nama_dokumen = $('#nama_dokumen'), file_permohonan = $('#file_permohonan');
            if (nama_dokumen.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Nama Dokumen masih kosong, silakan lengkapi terlebih dahulu...',
                    allowOutsideClick: false, 
                })
                nama_dokumen.focus();
                $('#btn-dokumen-pendukung').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }
            if (file_permohonan.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'File permohonan masih kosong, silakan lengkapi terlebih isi dahulu...',
                    allowOutsideClick: false, 
                })
                file_permohonan.focus();
                $('#btn-dokumen-pendukung').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }      
        
            $.ajax({
                url: "{{ route('prodi.dokumen.pendukung.add') }}",
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    $('#btn-dokumen-pendukung').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                    
                    if (response.success) {
                        $('#modalAddData').modal('hide');
                        $("#nama_dokumen").val('')
                        $("#file_permohonan").val('')
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
                    $('#btn-dokumen-pendukung').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false); 
                    Swal.fire({ 
                        icon: 'error',
                        title: 'Maaf!',
                        text: 'Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.',
                        allowOutsideClick: false, 
                    })   
                }
            });

        });
    });

	// edit data
	var _editData = function(data_id) {
        $('.header-title').append('Edit Data Pengajuan Audit');
        $('#card-table').hide(), $('#card-form').show();
        $('#form-data')[0].reset(), $('[name="methodform_data"]').val('update');

        var url = '{{ route("prodi.pengajuan.audit.edit", ":data_id") }}';
    		url = url.replace(':data_id', data_id);
		$.ajax({
            url:url,
            type: "GET",
            dataType: "JSON",
            success:function(response){
                // console.log(response.asesor);
                _clearForm();
                $('#jenis_standar_mutu_id').html('');
                $('#unit_prodi').html('');
                $('#informasi-data-dukung').show();
                $('#data-pendukung').html('');
                $('#data-asesor').html('')
                
                $('[name="id"]').val(response.data.id),
		        $('[name="methodform_data"]').val('update');
                
                $('#priode_evaluasi_id').val(response.data.priode_evaluasi_id);
                $('#jenis_standar_mutu_id').append(' <option value="'+response.data.jenis_standar_mutu_id+'">'+response.data.jenis_standar_mutu+'</option>')
                $('#unit_prodi').append(' <option value="'+response.data.user_id+'">'+response.data.unit_kerja+'</option>')
                $('#tgl_input').val(response.data.tgl_input);
                $('#data-pendukung').append(response.data.data_dukung);
                $.each(response.asesor, function(key,value){
                        var $key = key + 1;
                        $('#data-asesor').append(''+$key+'. '+value.name+'<br>');
                })
                
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
    }

	// save data
	$(document).ready(function(){
		$('#form-data').on('submit', function(event){
            event.preventDefault();

            $('#btn-save').html('<i class="fa fa-spin fa-spinner"></i> Mohon Tunggu...').attr('disabled', true);

            const priode_evaluasi_id = $('#priode_evaluasi_id'), tgl_input = $('#tgl_input');
            if (priode_evaluasi_id.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Periode Evaluasi masih kosong, silakan lengkapi terlebih dahulu...',
                    allowOutsideClick: false, 
                })
                priode_evaluasi_id.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }
            if (tgl_input.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Tanggal input masih kosong, silakan lengkapi terlebih isi dahulu...',
                    allowOutsideClick: false, 
                })
                tgl_input.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }      
        
            $.ajax({
                url: "{{ route('prodi.pengajuan.audit.store') }}",
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
                    }else if(response.already){
                        Swal.fire({ 
                                icon:'warning',
                                title: 'Oops!',
                                text: 'Periode Evaluasi Sudah Terdata, Anda Tidak Bisa Menambahkan Pengajuan Audit Dengan Periode Evaluasi Yang Sama',
                                allowOutsideClick: false, 
                            })
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
                        icon: 'error',
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
        // console.log(data_id);
        Swal.fire({title: 'Apakah Kamu Yakin?',text: "Menghapus data ini?",icon: 'warning',showCancelButton:true,confirmButtonColor: '#3085d6',cancelButtonColor: '#d33',confirmButtonText:'Hapus!',cancelButtonText: "Batal",
        }).then((result) => {
           if (result.isConfirmed) {
                var url = '{{ route("prodi.dokumen.pendukung.destroy", ":data_id") }}';
    				url = url.replace(':data_id', data_id);
				$.ajax({
					url: url,
					type: "DELETE",
					dataType: "JSON",
					cache: false,
					success:function(response){

						if (response.success) {
                            $('#modalAddData').modal('hide');
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