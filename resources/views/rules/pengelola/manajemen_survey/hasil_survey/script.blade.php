<script type="text/javascript">
	$.ajaxSetup({
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

    //hasil survey
	var table = $('.datatable').DataTable({
		processing: true,
		serverSide: true,
		ajax: "{{ route('hasil-survey.index') }}",
		columns: [
		{data: 'DT_RowIndex', name: 'DT_RowIndex', className:'text-center'},
		{data: 'jenis_survey', name: 'jenis_survey'},
		{data: 'nama_survey', name: 'nama_survey'},
		{data: 'tahun_survey', name: 'tahun_survey', className:'text-center'},
		{data: 'jumlah_sruvey', name: 'jumlah_sruvey', className:'text-center'},
		{data: 'action', name: 'action', className:'text-center', orderable: false, searchable: false},
		]
	});

	
    // datatable
    var table = $('.datatable').DataTable({
        searchDelay: 300,
        processing: true,
        serverSide: true,
		ajax: "{{ route('hasil-survey.index') }}",
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
			{data: 'jenis_survey', name: 'jenis_survey'},
			{data: 'nama_survey', name: 'nama_survey'},
			{data: 'tahun_survey', name: 'tahun_survey', className:'text-center'},
			{data: 'jumlah_sruvey', name: 'jumlah_sruvey', className:'text-center'},
			{data: 'action', name: 'action', className:'text-center', orderable: false, searchable: false},
        ],
        //Set column definition initialisation properties.
        columnDefs: [
            { "width": "5%", "targets": 0, "className": "align-top text-center" },
            { "width": "10%", "targets": 1, "className": "align-top text-center" },
            { "width": "50%", "targets": 2, "className": "align-top" },
            { "width": "20%", "targets": 3, "className": "align-top" },
            { "width": "10%", "targets": 4, "className": "align-top" },
            { "width": "5%", "targets": 5, "className": "align-top text-center", orderable: false, searchable: false},
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
</script>