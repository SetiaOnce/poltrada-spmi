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
        ajax: {
             url:"{{ route('asesor.evaluasi.audit') }}",
             data: function(data){
                data.filter_tahun = $('input[name="filter_tahun"]').val();
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
            {data: 'tahun', name: 'tahun'},
            {data: 'nama_lembaga', name: 'nama_lembaga'},
            {data: 'jenis_standar', name: 'jenis_standar'},
            {data: 'unit_prodi', name: 'unit_prodi'},
            {data: 'tgl_input', name: 'tgl_input'},
            {data: 'action', name: 'action', className:'text-center', orderable: false, searchable: false},
        ],
        //Set column definition initialisation properties.
        columnDefs: [
            { "width": "5%", "targets": 0, "className": "align-top text-center" },
            { "width": "15%", "targets": 1, "className": "align-top text-center" },
            { "width": "15%", "targets": 2, "className": "align-top" },
            { "width": "15%", "targets": 3, "className": "align-top" },
            { "width": "15%", "targets": 4, "className": "align-top" },
            { "width": "15%", "targets": 5, "className": "align-top" },
            { "width": "10%", "targets": 6, "className": "align-top text-center" },
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
    // filter data by tahun
    $(document).ready(function(){
        $('input[name="filter_tahun"]').on('change',function(){
            table.draw();
        });
    });

    function _resetFilter(){
        $('input[name="filter_tahun"]').val('')
        table.draw();
    }
    
    // close form
    var _closeForm = function() {
        $('#card-detail').hide(), $('#card-temuan').hide(),$('#card-rekomendasi').hide(),$('#card-table').show();
    }

    // detail pengajuan
    function _detailPengajuan(data_id){
        $('#card-detail').show(), $('#card-table').hide();
        $('#data_pendukung').html('');
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

        var url = '{{ route("asesor.ajax.get.data.pendukung", ":data_id") }}';
    		url = url.replace(':data_id', data_id);
            $.ajax({
            url:url,
            type: "GET",
            dataType: "JSON",
            success:function(response){
                $("#detail_unit_prodi").append(': '+response.unit_prodi+'');
                $("#detail_tahun").append(': '+response.tahun+'');
                $("#detail_nama_lembaga").append(': '+response.jenis_standar+'');
                $("#detail_jenis_standar_mutu").append(': '+response.nama_lembaga+'');
                $("#detail_per_awal").append(': '+response.priode_awal+'');
                $("#detail_per_akhir").append(': '+response.priode_akhir+'');
                $("#detail_tgl_input").append(': '+response.tgl_input+'');

                $.each(response.data, function(key,value){
					var $key = key + 1;
					$("#data_pendukung").append('<tr>\
								<td align="center">'+$key+'</td>\
								<td>'+value.nama_dokumen+'</td>\
								<td align="center"><a href="{{ asset("") }}'+value.file_permohonan+'" data-bs-original-title="Lihat File Pdf" title="Lihat File Pdf" data-bs-placement="top" data-bs-toggle="tooltip" target="_blank" target="_blank">\
                                <img src="{{ asset("img/pdf-image.jpg") }}" alt="avatar-4" class=" avatar-md">\
                                </a></td>')
				});
                $("#detail_asesor").append(': ')
                $.each(response.asesor, function(key,value){
                    $("#detail_asesor").append('<mark>'+value.name+'</mark>, ')
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
                    icon:'warning',
                    title: 'Maaf!',
                    text: 'Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.',
                    allowOutsideClick: false, 
                })   
            }

        });
    }

    // daftar temuan
    var _daftarTemuan = function (data_id){
        $('#card-temuan').show(), $('#card-table').hide();
        $("#daftar_unit_prodi").html('');
        $("#daftar_tahun").html('');
        $("#daftar_nama_lembaga").html('');
        $("#daftar_jenis_standar_mutu").html('');
        $("#daftar_per_awal").html('');
        $("#daftar_per_akhir").html('');
        $("#daftar_tgl_input").html('');
        $("#daftar_temuan").html('')
        $('[name="id"]').val('');
        $('[name="methodform_data"]').val('');
        $('#temuan').val('');

        var url = '{{ route("asesor.ajax.get.daftar.temuan", ":data_id") }}';
    		url = url.replace(':data_id', data_id);
            $.ajax({
            url:url,
            type: "GET",
            dataType: "JSON",
            success:function(response){
                var check = response.daftar_temuan;
                if(check == null){
                    $('[name="methodform_data"]').val('add');
                    $('#form-temuan').show();
                } else{
                    $('#form-temuan').hide();
                    $("#daftar_temuan").append('<tr>\
                        <td align="center">1</td>\
                        <td>'+response.daftar_temuan.temuan+'</td>\
                        <td align="center"><a href="javascript:void(0)" onclick="_editTemuan('+response.daftar_temuan.id+')" class="waves-effect waves-light btn btn-sm btn-info btn-circle" data-bs-original-title="Edit Temuan" title="Edit Temuan" data-bs-placement="top" data-bs-toggle="tooltip">\
                           <span class="mdi mdi-pencil-box-multiple"></span></a></td>\
                        ')
                }
                
                $("#daftar_unit_prodi").append(': '+response.unit_prodi+'');
                $("#daftar_tahun").append(': '+response.tahun+'');
                $("#daftar_nama_lembaga").append(': '+response.jenis_standar+'');
                $("#daftar_jenis_standar_mutu").append(': '+response.nama_lembaga+'');
                $("#daftar_per_awal").append(': '+response.priode_awal+'');
                $("#daftar_per_akhir").append(': '+response.priode_akhir+'');
                $("#daftar_tgl_input").append(': '+response.tgl_input+'');
                $("#pengajuan_id").val(response.pengajuan_id);
                $("#asesor_id").val(response.asesor_id);
                
            }, error: function () {
                Swal.fire({ 
                    icon:'warning',
                    title: 'Maaf!',
                    text: 'Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.',
                    allowOutsideClick: false, 
                })   
            }

        });
    }

    // edit Temuan
    function _editTemuan(data_id){
        $('#form-temuan').show();
        var url = '{{ route("ajax.temuan.edit", ":data_id") }}';
    		url = url.replace(':data_id', data_id);
            $.ajax({
            url:url,
            type: "GET",
            dataType: "JSON",
            success:function(response){
                $('[name="id"]').val(response.data.id);
                $('[name="methodform_data"]').val('update');
                $('#temuan').val(response.data.temuan);
            }, error: function () {
                Swal.fire({ 
                    icon:'warning',
                    title: 'Maaf!',
                    text: 'Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.',
                    allowOutsideClick: false, 
                })   
            }

        });
        
    }

    // daftar rekomendasi
    function _rekomendasi(data_id){
        $('#card-rekomendasi').show(), $('#card-table').hide();
        $("#rek_unit_prodi").html('');
        $("#rek_tahun").html('');
        $("#rek_nama_lembaga").html('');
        $("#rek_jenis_standar_mutu").html('');
        $("#rek_per_awal").html('');
        $("#rek_per_akhir").html('');
        $("#rek_tgl_input").html('');
        $("#daftar_rekomendasi").html('')
        $('[name="id"]').val('');
        $('[name="methodform_data"]').val('');
        $('#rek_pengajuan_id').val('');
        $('#rek_asesor_id').val('');
        $('#rekomendasi').val('');
        $('#tanggal_akhir').val('');

        var url = '{{ route("asesor.ajax.get.rekomendasi", ":data_id") }}';
    		url = url.replace(':data_id', data_id);
            $.ajax({
            url:url,
            type: "GET",
            dataType: "JSON",
            success:function(response){
                var check = response.daftar_rekomendasi;
                if(check == null){
                    $('[name="methodform_data"]').val('add');
                    $('#form-rekomendasi').show();
                } else{
                    $('#form-rekomendasi').hide();
                    $("#daftar_rekomendasi").append('<tr>\
                        <td align="center">1</td>\
                        <td>'+response.daftar_rekomendasi.rekomendasi+'</td>\
                        <td>'+response.daftar_rekomendasi.tanggal_akhir+'</td>\
                        <td align="center"><a href="javascript:void(0)" onclick="_editRekomendasi('+response.daftar_rekomendasi.id+')" class="waves-effect waves-light btn btn-sm btn-info btn-circle" data-bs-original-title="Edit Temuan" title="Edit Temuan" data-bs-placement="top" data-bs-toggle="tooltip">\
                           <span class="mdi mdi-pencil-box-multiple"></span></a></td>\
                        ')
                }
                
                $("#rek_unit_prodi").append(': '+response.unit_prodi+'');
                $("#rek_tahun").append(': '+response.tahun+'');
                $("#rek_nama_lembaga").append(': '+response.jenis_standar+'');
                $("#rek_jenis_standar_mutu").append(': '+response.nama_lembaga+'');
                $("#rek_per_awal").append(': '+response.priode_awal+'');
                $("#rek_per_akhir").append(': '+response.priode_akhir+'');
                $("#rek_tgl_input").append(': '+response.tgl_input+'');
                $("#rek_pengajuan_id").val(response.pengajuan_id);
                $("#rek_asesor_id").val(response.asesor_id);
                
            }, error: function () {
                Swal.fire({ 
                    icon:'warning',
                    title: 'Maaf!',
                    text: 'Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.',
                    allowOutsideClick: false, 
                })   
            }

        });
    }

    // edit Rekomendasi
    function _editRekomendasi(data_id){
        $('#form-rekomendasi').show();
        var url = '{{ route("ajax.rekomendasi.edit", ":data_id") }}';
    		url = url.replace(':data_id', data_id);
            $.ajax({
            url:url,
            type: "GET",
            dataType: "JSON",
            success:function(response){
                $('[name="id"]').val(response.data.id);
                $('[name="methodform_data"]').val('update');
                $('#rekomendasi').val(response.data.rekomendasi);
                $('#tanggal_akhir').val(response.data.tanggal_akhir);
            }, error: function () {
                Swal.fire({ 
                    icon:'warning',
                    title: 'Maaf!',
                    text: 'Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.',
                    allowOutsideClick: false, 
                })   
            }

        });
        
    }

    // save daftar temuan
    $(document).ready(function(){
		$('#form-temuan').on('submit', function(event){
            event.preventDefault();
            $('#btn-save').html('<i class="fa fa-spin fa-spinner"></i> Mohon Tunggu...').attr('disabled', true);
            const temuan = $('#temuan');    
            if (temuan.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Temuan masih kosong, silakan lengkapi terlebih dahulu...',
                    allowOutsideClick: false, 
                })    
                temuan.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }
            
            $.ajax({
                url: "{{ route('ajax.temuan.store') }}",
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
                        $('#form-temuan').hide();
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

    // save daftar rekomendasi
    $(document).ready(function(){
		$('#form-rekomendasi').on('submit', function(event){
            event.preventDefault();
            $('#rek-btn-save').html('<i class="fa fa-spin fa-spinner"></i> Mohon Tunggu...').attr('disabled', true);
            const rekomendasi = $('#rekomendasi'), tanggal_akhir = $('#tanggal_akhir');    
            if (rekomendasi.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Rekomendasi masih kosong, silakan lengkapi terlebih dahulu...',
                    allowOutsideClick: false, 
                })    
                rekomendasi.focus();
                $('#rek-btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }
            if (tanggal_akhir.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Tanggal Akhir masih kosong, silakan lengkapi terlebih dahulu...',
                    allowOutsideClick: false, 
                })    
                tanggal_akhir.focus();
                $('#rek-btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }
            
            $.ajax({
                url: "{{ route('ajax.rekomendasi.store') }}",
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function (response) {
                    $('#rek-btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                    
                    if (response.success) {
                        _closeForm();
                        $('#form-rekomendasi').hide();
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
                    $('#rek-btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false); 
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

</script>