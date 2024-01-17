<script type="text/javascript">
    $.ajaxSetup({
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	//script Review Image
	$(document).ready(function(){
		$('#file_pdf').change(function(e){
			$('#showPdf').show();
			var reader = new FileReader();
			reader.onload = function(e){
				$('#PriviewPdf').attr('src',e.target.result);
			}
			reader.readAsDataURL(e.target.files['0']);
		});
	});

	// show modal priview
	var previewPdf = function() {
       $('#modalShow').modal('show');
    }
    //datatable
    var table = $('.datatable').DataTable({
        searchDelay: 300,
        processing: true,
        serverSide: true,
		ajax: "{{ route('pengelola.produk.index') }}",
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
            {data: 'jenis_produk', name: 'jenis_produk'},
            {data: 'sub_jenis_produk', name: 'sub_jenis_produk'},
            {data: 'nama_produk', name: 'nama_produk'},
            {data: 'pdf', name: 'pdf'},
            {data: 'action', name: 'action' },
        ],
        //Set column definition initialisation properties.
        columnDefs: [
            { "width": "5%", "targets": 0, "className": "align-top text-center" },
            { "width": "20%", "targets": 1, "className": "align-top" },
            { "width": "10%", "targets": 2, "className": "align-top text-center" },
            { "width": "50%", "targets": 3, "className": "align-top" },
            { "width": "5%", "targets": 4, "className": "align-top", orderable: false, searchable: false},
            { "width": "10%", "targets": 5, "className": "align-top",orderable: false, searchable: false },
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
    
    // ajax mengambil data sub jenis produk
    $(document).ready(function(){
        $('select[name="jenis_produk_id"]').on('change',function(){
            var data_id = $(this).val();
            if (data_id) {
                
                var url = '{{ route("ajax.get.sub.jenis.produk", ":data_id") }}';
                url = url.replace(':data_id', data_id);

                $.ajax({
                    url: url,
                    type:"GET",
                    dataType:"json",
                    success:function(response) { 
                        $('select[name="sub_jenis_produk_id"]').html('');
                        $('select[name="sub_jenis_produk_id"]').append('<option value="">--Pilih Sub Jenis Produk--</option>');
                        $.each(response.data, function(key,value){
                              $('select[name="sub_jenis_produk_id"]').append('<option value="'+ value.id +'">' + value.sub_jenis_produk + '</option>');
                        });
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
        $('#showPdf').hide();
        _clearForm(), $('#card-form').hide(), $('#card-table').show();
    }

    // clear form
    var _clearForm = function() {
            $('#form-data')[0].reset(), 
			$('[name="id"]').val(''),
			$('[name="methodform_data"]').val(''),
			$('#jenis_produk_id').val('');
			$('#nama_produk').val('');
			$('#file_pdf').val('');
    }

	// add data baru
	var _addData = function() {
        $('.header-title').append('Input Data Produk Baru');
        _clearForm(), $('[name="methodform_data"]').val('add'), $('#card-table').hide(), $('#card-form').show();
        $('select[name="sub_jenis_produk_id"]').html('')
        $('select[name="sub_jenis_produk_id"]').append('<option value="">--Pilih Sub Jenis Produk--</option>');
    }

	// edit data
	var _editData = function(data_id) {
        $('.header-title').append('Edit Data Produk');
        $('#form-data')[0].reset(), $('[name="methodform_data"]').val('update');
        $('select[name="sub_jenis_produk_id"]').html('');
        $('select[name="sub_jenis_produk_id"]').append('<option value="">--Pilih Sub Jenis Produk--</option>');
        $('#card-table').hide(), $('#card-form').show();

        var url = '{{ route("pengelola.produk.edit", ":data_id") }}';
    		url = url.replace(':data_id', data_id);
		$.ajax({
            url:url,
            type: "GET",
            dataType: "JSON",
            success:function(response){
                // _clearForm();

                $('[name="id"]').val(response.data.id),
		        $('[name="methodform_data"]').val('update'),
                $('select[name="jenis_produk_id"]').val(response.data.jenis_produk_id)

                $('#nama_produk').val(response.data.nama_produk);
                $('#showPdf').show();
                $('#PriviewPdf').attr('src','{{ asset("") }}'+response.data.file_pdf+'');
                var url = '{{ route("ajax.get.sub.jenis.produk", ":data_id") }}';
                url = url.replace(':data_id', response.data.jenis_produk_id);

                $.ajax({
                    url: url,
                    type:"GET",
                    dataType:"json",
                    success:function(data) { 
                        $('select[name="sub_jenis_produk_id"]').html('');
                        $('select[name="sub_jenis_produk_id"]').append('<option value="">--Pilih Sub Jenis Produk--</option>');
                        $.each(data.data, function(key,value){
                                if(value.id ==  response.data.sub_jenis_produk_id){
                                    var sub_jenis = 'selected';
                                }else{
                                    var sub_jenis = '';
                                }
                              $('select[name="sub_jenis_produk_id"]').append('<option value="'+ value.id +'" '+sub_jenis+'>' + value.sub_jenis_produk + '</option>');
                        });
                    },
                });

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
            const jenis_produk_id = $('#jenis_produk_id'), nama_produk = $('#nama_produk') , sub_jenis_produk_id = $('#sub_jenis_produk_id');   
            if (jenis_produk_id.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Jenis produk masih kosong, silakan lengkapi terlebih dahulu...',
                    allowOutsideClick: false, 
                })    
                jenis_produk_id.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }     
            if (sub_jenis_produk_id.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Sub Jenis produk masih kosong, silakan lengkapi terlebih dahulu...',
                    allowOutsideClick: false, 
                })    
                sub_jenis_produk_id.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }     
            if (nama_produk.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Nama produk masih kosong, silakan lengkapi terlebih isi dahulu...',
                    allowOutsideClick: false, 
                })    
                nama_produk.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }    
        
            
            $.ajax({
                url: "{{ route('pengelola.produk.store') }}",
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
                var url = '{{ route("pengelola.produk.delete", ":data_id") }}';
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
								html: 'Sukses menghapus data produk'
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