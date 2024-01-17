<script type="text/javascript">
	
	// close form
    var _closeForm = function() {
        $('.header-title').html('');
        $('#btn-kembali').show();
        save_method = '';
        _clearForm(), $('#card-form').hide(), $('#card-table').show();
        $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
    }

    // clear form
    var _clearForm = function() {
        if(save_method=='' || save_method=='add_data') {
            $('#form-data')[0].reset(), 
			$('[name="id"]').val(''),
			$('[name="methodform_data"]').val(''),
			$('#sub_standar_mutu').val('');
			$('#data_dukung').val('');
			$('#jenis_indikator').val('');
			$('#bobot_nilai').val('');
			$('#keterangan').val('');
        } else {
            var id_data = $('[name="id"]').val();
            _editData(id_data);
        }
    }

	// add data baru
	var _addData = function() {
        $('.header-title').append('Input Data Sub Standar Mutu Baru');
        $('#btn-kembali').hide();
        save_method = 'add_data';
        _clearForm(), $('[name="methodform_data"]').val('add'), $('#card-table').hide(), $('#card-form').show();
    }

    var _muncuSementara = function(){
        $('#tahun').val('2017');
        $('#data_dukung').val('Contoh Data Dukung');
        $('#jenis_indikator').val('Contoh Jenis Indikator');
        $('#bobot_nilai').val('4');
        $('#keterangan').val('Lorem Ipsum Dummyy.....');
    }
    
	// edit data
	var _editData = function(id_data) {
        $('#btn-kembali').hide();
        $('.header-title').append('Edit Data Sub Standar Mutu');
        $('#card-table').hide(), $('#card-form').show();
        save_method = 'update_data';
        $('#form-data')[0].reset(), $('[name="methodform_data"]').val('update'), _muncuSementara();
        var target = document.querySelector('#card-form'); 
        $.ajax({
            url: BASE_URL+ "/penugasan/edit/",
            type: "GET",
            dataType: "JSON",
            data: {
                'id': id_data
            }, success: function (data) { 
                if (data.status == true) {  
                    var $newOption3 = $("<option selected='selected'></option>").val(data.detail.satpel_id).text(data.detail.nama_satpel);
                    $("#satpel_id").append($newOption3).trigger('change');
                    $('[name="id"]').val(data.detail.id),  
                    $('[name="koor_lat"]').val(data.detail.koor_lat),  
                    $('[name="koor_long"]').val(data.detail.koor_long),  
                    $('#nama').val(data.detail.nama),      
                    $('#card-data-background').hide(), $('#card-form-background').show();
                } else {
                    alert('Load data mengalami masalah, Periksa koneksi jaringan internet lalu coba kembali')
                }
            }, error: function (jqXHR, textStatus, errorThrown) {
                alert('Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.')
            }
        });
    }
    
	// save data
	$('#btn-save').on('click', function (e) {
        e.preventDefault();
        $('#btn-save').html('<i class="fa fa-spin fa-spinner"></i> Mohon Tunggu...').attr('disabled', true);
        const 
        lembaga_akreditasi_id = $('#lembaga_akreditasi_id'), 
        unit_prodi_id = $('#unit_prodi_id'), 
        tahun = $('#tahun'), 
        sub_standar_mutu = $('#sub_standar_mutu'), 
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
            // command: toastr["warning"]("Nama Aplikasi masih kosong silakan silakan lengkapi data !")    
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
            // command: toastr["warning"]("Nama Aplikasi masih kosong silakan silakan lengkapi data !")    
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
            // command: toastr["warning"]("Nama Aplikasi masih kosong silakan silakan lengkapi data !")    
            tahun.focus();
            $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
            return false;
        }    
        if (sub_standar_mutu.val() == '') {
            Swal.fire({ 
                icon: 'warning',
                title: 'Maaf!',
                text: 'Sub Standar mutu masih kosong, silakan lengkapi terlebih dahulu...',
                allowOutsideClick: false, 
            })
            // command: toastr["warning"]("Nama Aplikasi masih kosong silakan silakan lengkapi data !")    
            sub_standar_mutu.focus();
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
            // command: toastr["warning"]("Nama Aplikasi masih kosong silakan silakan lengkapi data !")    
            data_dukung.focus();
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
            // command: toastr["warning"]("Nama Aplikasi masih kosong silakan silakan lengkapi data !")    
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
            // command: toastr["warning"]("Nama Aplikasi masih kosong silakan silakan lengkapi data !")    
            bobot_nilai.focus();
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
            // command: toastr["warning"]("Nama Aplikasi masih kosong silakan silakan lengkapi data !")    
            keterangan.focus();
            $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
            return false;
        }     
        var formData = new FormData($('#form-data')[0]), ajax_url= BASE_URL+ "/ajax_save_penugasan";
            $.ajax({
                url: ajax_url,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "JSON", 
                success: function (data) {
                    $.unblockUI();
                    $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false);
                    
                    if (data.status==true){ 
                        Swal.fire({
                            icon: 'success', 
                            text: 'Data berhasil disimpan. Terima kasih!',  
                            confirmButtonText: 'Selesai!', 
                        }).then((result) => {  
                            _closeForm(), oTable.draw();
                        });  
                    }else{  
                        if(data.pesan_code=='format_inputan') { 
                            Swal.fire({ 
                                title: 'Maaf!',
                                text: data.pesan_error[0],
                                allowOutsideClick: false, 
                            }) 
                        } else { 
                            Swal.fire({ 
                                title: 'Maaf!',
                                text: 'Pastikan Anda melengkapi form dengan benar. Terima kasih!',
                                allowOutsideClick: false, 
                            })  
                        } 
                    }
                }, error: function (jqXHR, textStatus, errorThrown) {
                    $.unblockUI();
                    $('#btn-save').html('<i class="ri-save-fill align-middle"></i> Simpan').attr('disabled', false); 
                    Swal.fire({ 
                        title: 'Maaf!',
                        text: 'Terjadi kesalahan yang tidak diketahui, Periksa koneksi jaringan internet lalu coba kembali. Mohon hubungi pengembang jika masih mengalami masalah yang sama.',
                        allowOutsideClick: false, 
                    })   
                }
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