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
		ajax: "{{ route('asesor.kegiatan.index') }}",
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
            {data: 'jenis_kegiatan', name: 'jenis_kegiatan'},
            {data: 'judul_kegiatan', name: 'judul_kegiatan'},
            {data: 'foto', name: 'foto'},
            {data: 'action', name: 'action'},
        ],
        //Set column definition initialisation properties.
        columnDefs: [
            { "width": "5%", "targets": 0, "className": "align-top text-center" },
            { "width": "20%", "targets": 1, "className": "align-top" },
            { "width": "60%", "targets": 2, "className": "align-top" },
            { "width": "5%", "targets": 3, "className": "align-top text-center", orderable: false, searchable: false},
            { "width": "10%", "targets": 4, "className": "align-top text-center",orderable: false, searchable: false },
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
        $('#showImage').attr('src',"{{ asset('img/no-image2.png') }}");
        $('#data-view').hide(), $('#card-table').show();

        $('#waktu_dan_view').html('');
        $('#judul_kegiatan').html('');
        $('#deskripsi_kegiatan').html('');
        $('#jenis_kegiatan').html('');
    }

	// edit data
	var _viewData = function(data_id) {
        $('.header-title').append('Detail Kegiatan');
        $('#card-table').hide(), $('#data-view').show();
        
        var url = '{{ route("asesor.detail.kegiatan", ":data_id") }}';
    		url = url.replace(':data_id', data_id);
		$.ajax({
            url:url,
            type: "GET",
            dataType: "JSON",
            success:function(response){
                console.log(response.data);
                $('#foto_kegiatan').attr('src','{{ asset("") }}'+response.data.foto_kegiatan+'');
                $('#waktu_dan_view').append('<span class="text-mute"><i class="fa fa-calendar fa-fw"></i> '+response.data.waktu_kegiatan+'</span>\
                <span class="text-mute"><i class="mdi mdi-eye align-center">'+response.data.view+'</i></span>');
                $('#judul_kegiatan').append(response.data.judul_kegiatan);
                $('#deskripsi_kegiatan').append(response.data.deskripsi_kegiatan);
                $('#jenis_kegiatan').append(response.data.jenis_kegiatan);


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

</script>