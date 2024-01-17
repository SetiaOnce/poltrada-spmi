<script type="text/javascript">
	$.ajaxSetup({
		headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

    // textare data dukung
    tinymce.init({ 
        selector: 'textarea#data_dukung',
        height:300,
        width:1000,
        plugins:["lists"],
        toolbar: 'numlist'
    });

    //datatable
    var url = '{{ route("jenis.standar.mutu.index", ":data_id") }}';
        url = url.replace(':data_id', '{{ $daftar_standar_mutu->id }}');
    var table = $('.datatable').DataTable({
        searchDelay: 300,
        processing: true,
        serverSide: true,
		ajax: url,
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
            {data: 'nama_standar', name: 'nama_standar'},
            {data: 'jenis_standar_mutu', name: 'jenis_standar_mutu'},
            {data: 'jenis_indikator', name: 'jenis_indikator'},
            {data: 'bobot_nilai', name: 'bobot_nilai'},
            {data: 'target_nilai', name: 'target_nilai'},
            {data: 'action', name: 'action',  className:'text-center'},
        ],
        //Set column definition initialisation properties.
        columnDefs: [
            { "width": "5%", "targets": 0, "className": "align-top text-center" },
            { "width": "10%", "targets": 1, "className": "align-top text-center" },
            { "width": "5%", "targets": 2, "className": "align-top" },
            { "width": "20%", "targets": 3, "className": "align-top" },
            { "width": "50%", "targets": 4, "className": "align-top text-center" },
            { "width": "50%", "targets": 4, "className": "align-top text-center" },
            { "width": "10%", "targets": 5, "className": "align-top text-center",orderable: false, searchable: false },
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
        $('#btn-kembali').show();
        _clearForm(), $('#card-form').hide(), $('#card-table').show();
        $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
    }

    // clear form
    var _clearForm = function() {
        $('#form-data')[0].reset(), 
        $('[name="id"]').val(''),
        $('[name="methodform_data"]').val(''),

        $('#jenis_standar_mutu').val('');
        $('#data_dukung').val('');
        $('#keterangan').val('');
        $('#jenis_indikator').val('');
        $('#bobot_nilai').val('');
        $('#target_nilai').val('');
    }

	// add data baru
	var _addData = function() {
        $('.header-title').append('Input Jenis Standar Mutu Baru');
        $('#btn-kembali').hide();
        _clearForm(), $('[name="methodform_data"]').val('add'), $('#card-table').hide(), $('#card-form').show();
    }
    
	// edit data
	var _editData = function(data_id) {
        $('#btn-kembali').hide();
        $('.header-title').append('Edit Data Jenis Standar Mutu');
        $('#card-table').hide(), $('#card-form').show();
        $('#form-data')[0].reset(), $('[name="methodform_data"]').val('update');

        
        var url = '{{ route("jenis.standar.mutu.edit", ":data_id") }}';
    		url = url.replace(':data_id', data_id);
		$.ajax({
            url:url,
            type: "GET",
            dataType: "JSON",
            success:function(response){
                _clearForm();
                $('[name="id"]').val(response.data.id);
		        $('[name="methodform_data"]').val('update');
                
                $('#jenis_standar_mutu').val(response.data.jenis_standar_mutu);
                tinymce.get('data_dukung').setContent(response.data.data_dukung);
                $('#keterangan').val(response.data.keterangan);
                $('#jenis_indikator').val(response.data.jenis_indikator);
                $('#bobot_nilai').val(response.data.bobot_nilai);
                $('#target_nilai').val(response.data.target_nilai);

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
            daftar_standar_mutu_id = $('#daftar_standar_mutu_id'), 
            jenis_standar_mutu = $('#jenis_standar_mutu'), 
            data_dukung = $('#data_dukung'), 
            keterangan = $('#keterangan'),
            jenis_indikator = $('#jenis_indikator'), 
            bobot_nilai = $('#bobot_nilai'), 
            target_nilai = $('#target_nilai');

            if (daftar_standar_mutu_id.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Daftar standar mutu masih kosong, silakan lengkapi terlebih isi dahulu...',
                    allowOutsideClick: false, 
                })
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }
            if (jenis_standar_mutu.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Jenis standar mutu masih kosong, silakan lengkapi terlebih dahulu...',
                    allowOutsideClick: false, 
                })    
                jenis_standar_mutu.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }
            if (data_dukung.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Data dukung masih kosong, silakan lengkapi terlebih dahulu...',
                    allowOutsideClick: false, 
                })    
                data_dukung.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }
            if (keterangan.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Keterangan masih kosong, silakan lengkapi terlebih dahulu...',
                    allowOutsideClick: false, 
                })    
                keterangan.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }
            if (jenis_indikator.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Jenis indikator masih kosong, silakan lengkapi terlebih dahulu...',
                    allowOutsideClick: false, 
                })    
                jenis_indikator.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }
            if (bobot_nilai.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Bobot Nilai masih kosong, silakan lengkapi terlebih dahulu...',
                    allowOutsideClick: false, 
                })    
                bobot_nilai.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }
            if (target_nilai.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Target Nilai masih kosong, silakan lengkapi terlebih dahulu...',
                    allowOutsideClick: false, 
                })    
                target_nilai.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }

            $.ajax({
                url: "{{ route('jenis.standar.mutu.store') }}",
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
	function _deleteData() {
        Swal.fire({title: 'Apakah Kamu Yakin?',text: "Menghapus data ini?",icon: 'warning',showCancelButton:true,confirmButtonColor: '#3085d6',cancelButtonColor: '#d33',confirmButtonText:'Hapus!',cancelButtonText: "Batal",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route("home") }}'
            }
        }) 
    }

</script>