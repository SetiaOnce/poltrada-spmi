@extends('layouts.pengelola')
@section('konten')

@section('title')
    Manajemen Hasil SPM
@stop
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <a href="javascript:history.go(-1);" id="btn-kembali" class="btn btn-danger btn-sm waves-effect" data-bs-original-title="Anda akan diarahkan ke halaman sebelumnya" data-bs-placement="top" data-bs-toggle="tooltip"><i class="ri-delete-back-2-fill align-middle"></i> Kembali</a>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="ri-home-3-fill"></i></a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Manajemen Survey</a></li>
                    <li class="breadcrumb-item active">Hasil Survey</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

@include('rules.pengelola.manajemen_survey.hasil_survey.modal')

<div id="card-table" class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class=" d-sm-flex align-items-center justify-content-between">
                    <h4 class="card-title">{{ $nama_survey->nama_survey }}</h4>
                </div>
                <hr>
                <h4 class="card-title">Pertanyaan Yang Memiliki Jawaban 1-5</h4>
                <div class="table-responsive">
                    <table  class="table table-bordered">
                        <thead class="table-secondary">
                            <tr style="height: 15px;">
                                <td class="text-center" style="width: 7.21582%; height: 20px;vertical-align: middle; text-align: center;" colspan="1" rowspan="2"><strong>NO</strong></td>
                                <td class="text-center" style="width: 60%; height: 20px;vertical-align: middle; text-align: center;" rowspan="2"><strong>PERTANYAAN</strong></td>
                                <td class="text-center" style="height: 15px; width: 40%;" colspan="5"><strong>JAWABAN</strong></td>
                                <td class="text-center" style="width: 5%; height: 53px;vertical-align: middle; text-align: center;" rowspan="2"><strong>JUMLAH</strong></td>
                                <td class="text-center" style="width: 30%;vertical-align: middle; text-align: center;" rowspan="2"><strong>JUMLAH NILAI PER UNSUR</strong></td>
                                <td class="text-center" style="width: 11%;vertical-align: middle; text-align: center;" rowspan="2"><strong>NRR</strong></td>
                            </tr>
                            <tr style="height: 15px;">
                                <td style="text-align: center; width: 5%; height: 15px;"><strong>1</strong></td>
                                <td style="text-align: center; width: 5%; height: 15px;"><strong>2</strong></td>
                                <td style="text-align: center; width: 5%; height: 15px;"><strong>3</strong></td>
                                <td style="text-align: center; width: 5%; height: 15px;"><strong>4</strong></td>
                                <td style="text-align: center; width: 5%; height: 15px;"><strong>5</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($dt_pertanyaanSurvey1_4) > 0)
                                @php
                                    $nnrPerunsur = 0;
                                @endphp
                                @foreach ($dt_pertanyaanSurvey1_4 as $no => $pertanyaan)
                                @php
                                    $jml_pertanyaan1 = App\Models\DataHasilSurvey::where('jawaban', 1)->where('id_pertanyaan_survey', $pertanyaan->id)->count();
                                    $jml_pertanyaan2 = App\Models\DataHasilSurvey::where('jawaban', 2)->where('id_pertanyaan_survey', $pertanyaan->id)->count();
                                    $jml_pertanyaan3 = App\Models\DataHasilSurvey::where('jawaban', 3)->where('id_pertanyaan_survey', $pertanyaan->id)->count();
                                    $jml_pertanyaan4 = App\Models\DataHasilSurvey::where('jawaban', 4)->where('id_pertanyaan_survey', $pertanyaan->id)->count();
                                    $jml_pertanyaan5 = App\Models\DataHasilSurvey::where('jawaban', 5)->where('id_pertanyaan_survey', $pertanyaan->id)->count();
                                    // jumlah responden
                                    $jumlahResponden = $jml_pertanyaan1 + $jml_pertanyaan2 + $jml_pertanyaan3 + $jml_pertanyaan4 + $jml_pertanyaan5;
                                    // nilai nnr perunsur
                                    $totalNilaiPerunsur = ($jml_pertanyaan1 * 1) + ($jml_pertanyaan2 * 2) + ($jml_pertanyaan3 * 3) + ($jml_pertanyaan4 * 4) + ($jml_pertanyaan5 * 5);
                                    // jumlah nnr
                                    if ($jumlahResponden == 0) {
                                        $nnr = number_format(0, 2, '.', '');
                                    }else {
                                        $nnr = number_format($totalNilaiPerunsur / $jumlahResponden, 2, '.', '');
                                        $nnrPerunsur += $nnr;
                                    }
                                    @endphp
                                    <tr>
                                        <td align="center">{{ $no+1 }}</td>
                                        <td>{{ $pertanyaan->pertanyaan }}</td>
                                        <td align="center">{{ $jml_pertanyaan1 }}</td>
                                        <td align="center">{{ $jml_pertanyaan2 }}</td>
                                        <td align="center">{{ $jml_pertanyaan3 }}</td>
                                        <td align="center">{{ $jml_pertanyaan4 }}</td>
                                        <td align="center">{{ $jml_pertanyaan5 }}</td>
                                        <td align="center">{{ $jumlahResponden }}</td>
                                        <td align="center">{{ $totalNilaiPerunsur }}</td>
                                        <td align="center">{{ $nnr }}</td>
                                    </tr>
                                @endforeach
                                <tr style="height: 22px; background-color: #f1f1f1;">
                                    <td style="width: 62.0912%; text-align: center; height: 22px; color:#000000;  font-weight: 900;font-weight: bolder;" colspan="9"><strong>NRR PER UNSUR</strong></td>
                                    <td style="width: 6.28834%; text-align: center; height: 22px;" colspan="2"><strong>{{ number_format($nnrPerunsur / count($dt_pertanyaanSurvey1_4), 2, '.', '') }}</strong></td>
                                </tr>
                            @else
                                <tr style="height: 22px; background-color: #f1f1f1;">
                                    <td colspan="10" align="center"><strong><i>Jawaban atas pertanyaan survey 1-5 masih kosong...</i></strong></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <h4 class="card-title mt-4">Pertanyaan Yang Memiliki Jawaban Ya atau Tidak</h4>
                <div class="table-responsive">
                    <table  class="table table-bordered">
                        <thead class="table-secondary">
                            <tr style="height: 22px;">
                                <td style="width: 7.21582%; height: 44px; vertical-align: middle; text-align: center; align-items:center;" colspan="1" rowspan="2"><strong>NO</strong></td>
                                <td style="width: 60%; height: 44px; vertical-align: middle; text-align: center;" rowspan="2"><strong>PERTANYAAN</strong></td>
                                <td style="height: 22px; vertical-align: middle; text-align: center; width: 40%;" colspan="2"><strong>JAWABAN</strong></td>
                                <td style="vertical-align: middle; text-align: center; width: 36.8661%; height: 22px;" colspan="2"><strong>PERSENTASE</strong></td>
                            </tr>
                            <tr style="height: 22px;">
                                <td style="vertical-align: middle; text-align: center; width: 5%; height: 22px;"><strong>Ya</strong></td>
                                <td style="vertical-align: middle; text-align: center; width: 5%; height: 22px;"><strong>Tidak</strong></td>
                                <td style="vertical-align: middle; text-align: center; width: 5%; height: 22px;"><strong>Ya</strong></td>
                                <td style="vertical-align: middle; text-align: center; width: 5%; height: 22px;"><strong>Tidak</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                        @if (count($dt_pertanyaanSurveyYaTidak) > 0)
                            @foreach ($dt_pertanyaanSurveyYaTidak as $no => $pertanyaan)
                            @php
                                $jmlhJawabanYa = App\Models\DataHasilSurvey::where('jawaban', 'Ya')->where('id_pertanyaan_survey', $pertanyaan->id)->count();
                                $jmlhJawabanTidak = App\Models\DataHasilSurvey::where('jawaban', 'Tidak')->where('id_pertanyaan_survey', $pertanyaan->id)->count();
                                
                                $jumlahYaTidak = $jmlhJawabanYa + $jmlhJawabanTidak;
                                // check jika persentasi 100
                                if($jumlahYaTidak != 0){
                                    if($jmlhJawabanYa / $jumlahYaTidak * 100 == 100){
                                        $persentase_ya =  $jmlhJawabanYa / $jumlahYaTidak * 100;
                                        $persentase_tidak =  $jmlhJawabanTidak / $jumlahYaTidak * 100;
                                    }else{
                                        $persentase_ya =  number_format($jmlhJawabanYa / $jumlahYaTidak * 100, 2, '.', '');
                                        $persentase_tidak =  number_format($jmlhJawabanTidak / $jumlahYaTidak * 100, 2, '.', '');
                                    }
                                }else {
                                    $persentase_ya =  0;
                                    $persentase_tidak =  0;
                                }
                            @endphp
                            <tr>
                                <td align="center">{{ $no+1 }}</td>
                                <td>{{ $pertanyaan->pertanyaan }}</td>
                                <td align="center">{{ $jmlhJawabanYa }}</td>
                                <td align="center">{{ $jmlhJawabanTidak }}</td>
                                <td align="center">{{ $persentase_ya }}%</td>
                                <td align="center">{{ $persentase_tidak }}%</td>
                            </tr>
                            @endforeach
                        @else
                            <tr style="height: 22px; background-color: #f1f1f1;">
                                <td colspan="6" align="center"><strong><i>Jawaban atas pertanyaan survey Ya-Tidak masih kosong...</i></strong></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <h4 class="card-title mt-4">Jawaban Terhadap Pertanyaan Esai</h4>
                <div class="table-responsive">
                    <table class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="table-secondary">
                            <tr>
                                <th style="width: 7.21582%; height: 44px; text-align: center; align-items:center;">NO</th>
                                <th>JAWABAN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($dt_jawaban_esai) > 0)
                                @foreach ($dt_jawaban_esai as $no => $jawaban)
                                    <tr>
                                        <td align="center">{{ $no+1 }}</td>
                                        <td>{{ $jawaban->jawaban }}</td>
                                    </tr>
                                @endforeach 
                            @else
                                <tr style="height: 22px; background-color: #f1f1f1;">
                                    <td colspan="2" align="center"><strong><i>Jawaban atas pertanyaan survey Esai masih kosong...</i></strong></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js')
      <script type="text/javascript">
        	$.ajaxSetup({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var url = '{{ route("detail.hasil.survey", ":data_id") }}';
                url = url.replace(':data_id', "{{ $nama_survey->id }}");

            var table = $('#detail_hasil_survey').DataTable({
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
                    {data: 'nik', name: 'nik'},
                    {data: 'nama', name: 'nama'},
                    {data: 'jenis_kelamin', name: 'jenis_kelamin'},
                    {data: 'email', name: 'email'},
                    {data: 'nim', name: 'nim'},
                    {data: 'tahun_masuk', name: 'tahun_masuk', className:'text-center'},
                    {data: 'unit_prodi', name: 'unit_prodi', className:'text-center'},
                    {data: 'action', name: 'action', className:'text-center', orderable: false, searchable: false},
                ],
                //Set column definition initialisation properties.
                columnDefs: [
                    { "width": "5%", "targets": 0, "className": "align-top text-center" },
                    { "width": "10%", "targets": 1, "className": "align-top text-center" },
                    { "width": "20%", "targets": 2, "className": "align-top" },
                    { "width": "10%", "targets": 3, "className": "align-top" },
                    { "width": "10%", "targets": 4, "className": "align-top" },
                    { "width": "10%", "targets": 5, "className": "align-top" },
                    { "width": "10%", "targets": 6, "className": "align-top" },
                    { "width": "20%", "targets": 7, "className": "align-top" },
                    { "width": "5%", "targets": 8, "className": "align-top text-center", orderable: false, searchable: false},
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
            $("#detail_hasil_survey").css("width", "100%");
            
            // show modal
            var _showmodal = function() {
                $('#modalView').modal('show');
            }
            
            // view detail jawaban taruna
            function _viewData(data_nim){
                $('input[name="data_nim"]').val(data_nim);
                var form = new FormData($('#jenis_data_tampil')[0])
                $.ajax({
                    url:"{{ route('sub.hasil.survey') }}",
                    method: 'POST',
                    data: form,
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(response){
                        $("#data_modal_view").html('');

                        $('input[name="data_nim_excel"]').val(response.detail.nim);
                        $('input[name="id_nama_survey_excel"]').val(response.detail.id_nama_survey);
                        
                        $("#dataNama").html('');
                        $("#dataNik").html('');
                        $("#dataJenisKelamin").html('');
                        $("#dataEmail").html('');

                        $("#dataNama").html(response.detail.nama);
                        $("#dataNik").html(response.detail.nik);
                        $("#dataJenisKelamin").html(response.detail.jenis_kelamin);
                        $("#dataEmail").html(response.detail.email);
                        _showmodal();

                        $.each(response.data, function(key,value){
                            var $key = key + 1;

							$("#data_modal_view").append('<tr>\
                                        <td align="center">'+$key+'</td>\
                                        <td>'+value.pertanyaan+'</td>\
                                        <td>'+value.jawaban+'</td>\
                                    </tr>')
						}); 
                        
                    }

                });
            }

            // view detail jawaban pegawai
            var _viewPegawai = function(d) {
                var email = d.getAttribute("data-email")
                $('input[name="email"]').val(email);

                var form = new FormData($('#jenis_data_tampil')[0])
                $.ajax({
                    url:"{{ route('sub.hasil.survey') }}",
                    method: 'POST',
                    data: form,
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(response){
                        $("#data_modal_view").html('');

                        $('input[name="email_excel"]').val(response.detail.email);
                        $('input[name="id_nama_survey_excel"]').val(response.detail.id_nama_survey);
                        
                        $("#dataNama").html('');
                        $("#dataNik").html('');
                        $("#dataJenisKelamin").html('');
                        $("#dataEmail").html('');

                        $("#dataNama").html(response.detail.nama);
                        $("#dataNik").html(response.detail.nik);
                        $("#dataJenisKelamin").html(response.detail.jenis_kelamin);
                        $("#dataEmail").html(response.detail.email);
                        _showmodal();

                        $.each(response.data, function(key,value){

                            var $key = key + 1;
                            
							$("#data_modal_view").append('<tr>\
                                        <td align="center">'+$key+'</td>\
                                        <td>'+value.pertanyaan+'</td>\
                                        <td>'+value.jawaban+'</td>\
                                    </tr>')
						}); 
                        
                    }

                });
            }

            // download excel 
            function _downloadExcel(){
                $('#btn-download').html('<i class="fa fa-spin fa-spinner"></i> Mohon Tunggu...').attr('disabled', true);

                var form = new FormData($('#import-data-excel')[0])
                $.ajax({
                    url:"{{ route('hasil.survey.export.excel') }}",
                    method: 'POST',
                    data: form,
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success:function(response){
                        
                        $('#btn-download').html('<i class="mdi mdi-microsoft-excel align-middle me-1"></i> Download Excel').attr('disabled', false);
                        
                        console.log(response.data);
                        
                    }

                });
                
            }
            
      </script>


@stop

@endsection