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
    var url = '{{ route("nama.standar.mutu.index", ":data_id") }}';
        url = url.replace(':data_id', '{{ $jenis_standar_mutu->id }}');
	var table = $('.datatable').DataTable({
		processing: true,
		serverSide: true,
		ajax: url,
		columns: [
		{data: 'DT_RowIndex', name: 'DT_RowIndex', className:'text-center'},
		{data: 'lembaga', name: 'lembaga'},
		{data: 'jenis', name: 'jenis'},
		{data: 'nama_standar_mutu', name: 'nama_standar_mutu'},
        {data: 'bobot_nilai', name: 'bobot_nilai', className:'text-center'},
		{data: 'action', name: 'action',  className:'text-center', orderable: false, searchable: false},
		]
	});
    
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
        $('#nama_standar_mutu').val('');
        $('#data_dukung').val('');
        $('#jenis_indikator').val('');
        $('#bobot_nilai').val('');
        $('#keterangan').val('');
    }

	// add data baru
	var _addData = function() {
        $('.header-title').append('Input Nama Standar Mutu Baru');
        $('#btn-kembali').hide();
        _clearForm(), $('[name="methodform_data"]').val('add'), $('#card-table').hide(), $('#card-form').show();
    }
    
	// edit data
	var _editData = function(data_id) {
        $('#btn-kembali').hide();
        $('.header-title').append('Edit Data Nama Standar Mutu');
        $('#card-table').hide(), $('#card-form').show();
        $('#form-data')[0].reset(), $('[name="methodform_data"]').val('update');

        var url = '{{ route("nama.standar.mutu.edit", ":data_id") }}';
    		url = url.replace(':data_id', data_id);
		$.ajax({
            url:url,
            type: "GET",
            dataType: "JSON",
            success:function(response){
                _clearForm();
                $('[name="id"]').val(response.data.id),
		        $('[name="methodform_data"]').val('update'),
                
                $('#nama_standar_mutu').val(response.data.nama_standar_mutu);
                tinymce.get('data_dukung').setContent(response.data.data_dukung);
                $('#jenis_indikator').val(response.data.jenis_indikator);
                $('#bobot_nilai').val(response.data.bobot_nilai);
                $('#keterangan').val(response.data.keterangan);

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
            lembaga_akreditasi_id = $('#lembaga_akreditasi_id'), 
            unit_prodi_id = $('#unit_prodi_id'), 
            tahun = $('#tahun'), 
            nama_standar_mutu = $('#nama_standar_mutu'), 
            data_dukung = $('#data_dukung'), 
            jenis_indikator = $('#jenis_indikator'), 
            bobot_nilai = $('#bobot_nilai'), 
            keterangan = $('#keterangan'); 

            if (lembaga_akreditasi_id.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Lembaga akreditasi masih kosong, silakan lengkapi terlebih isi dahulu...',
                    allowOutsideClick: false, 
                })   
                lembaga_akreditasi_id.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }
            if (unit_prodi_id.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Unit prodi masih kosong, silakan lengkapi terlebih isi dahulu...',
                    allowOutsideClick: false, 
                })   
                unit_prodi_id.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }
            if (tahun.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Tahun masih kosong, silakan lengkapi terlebih dahulu...',
                    allowOutsideClick: false, 
                })   
                tahun.focus();
                $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                return false;
            }    
            if (nama_standar_mutu.val() == '') {
                Swal.fire({ 
                    icon: 'warning',
                    title: 'Maaf!',
                    text: 'Nama Standar mutu masih kosong, silakan lengkapi terlebih dahulu...',
                    allowOutsideClick: false, 
                })   
                nama_standar_mutu.focus();
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
            $.ajax({
                url: "{{ route('nama.standar.mutu.store') }}",
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