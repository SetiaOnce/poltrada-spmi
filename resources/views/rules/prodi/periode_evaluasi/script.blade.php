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
             url:"{{ route('prodi.periode.evaluasi.index') }}",
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
			{data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
			{data: 'action', name: 'action', className:'text-center', orderable: false, searchable: false},
			{data: 'tahun', name: 'tahun', className: 'text-center'},
			{data: 'nama_lembaga', name: 'nama_lembaga'},
			{data: 'nama_standar', name: 'nama_standar'},
			{data: 'jenis_standar', name: 'jenis_standar'},
			{data: 'periode_awal', name: 'periode_awal'},
			{data: 'periode_akhir', name: 'periode_akhir'},
			{data: 'visitasi_awal', name: 'visitasi_awal'},
			{data: 'visitasi_akhir', name: 'visitasi_akhir'},
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

	// show modal
	var _showmodal = function() {
		$('#modalView').modal('show');
	}
	
	// popup modal lihat asesor
	function _lihatAsesor(data_id){
		$("#data_modal_view").html('');
		$('#tahun').html('');
		$('#nama_lembaga').html('');
		$('#jenis_standar_mutu').html('');
		_showmodal();
		var url = '{{ route("prodi.ajax.detail.asesor", ":data_id") }}';
    		url = url.replace(':data_id', data_id);
		
		$.ajax({
			url:url,
			method: 'GET',
			dataType: 'JSON',
			contentType: false,
			cache: false,
			processData: false,
			success:function(response){
				$('#tahun').append(' : '+response.title.tahun);
				$('#nama_lembaga').append(' : '+response.title.nama_lembaga);
				$('#jenis_standar_mutu').append(' : '+response.title.jenis_standar);
				$.each(response.data, function(key,value){
					var $key = key + 1;
					$("#data_modal_view").append('<tr>\
								<td align="center">'+$key+'</td>\
								<td>'+value.name+'</td>\
							</tr>')
				});
			}

		});
	}

</script>