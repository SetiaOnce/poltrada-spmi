<style>
.swal-wide{
    width:55% !important;
}
@media only screen and (max-width: 768px) {
    .swal-wide{
        width:100% !important;
    }
}
</style>

<div class="row scroll-row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="section-title-heading text-center">
                    <h3 class="wow fadeInDown" data-wow-delay=".3s">LAPORAN SURVEY</h3>
                </div>
            </div>
            <div class="panel-body wow fadeIn" data-wow-delay=".3s">
               
            <div class="col-md-12">
                <div class="panel-group" id="accordion">

                @foreach($data_nama_survey as $nama_survey)
                @php
                    $jml_responden =  \DB::table('spm_data_hasil_survey')
                    ->where('id_nama_survey', $nama_survey->id)
                    ->groupBy('email')
                    ->get()
                    ->count();
                @endphp
                
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5 class="panel-title" style="cursor: pointer;"  onclick="_pieChart('{{ $nama_survey->id }}')" href="#collapse{{ $nama_survey->id }}">
                            <span data-toggle="collapse" data-parent="#accordion" style="cursor: pointer;" href="#collapse{{ $nama_survey->id }}" data-placement="top" title="Klik Untuk Lihat Detail"><strong style="font-size:13px;">{{ $nama_survey->nama_jenis_survey }} | {{ $nama_survey->tahun_survey }} | {{ strtoupper($nama_survey->nama_survey) }}</strong></span>
                        </h5>
                    </div>
                    <div id="collapse{{ $nama_survey->id }}" class="panel-collapse collapse ">
                        <div class="panel-body" id="data-laporan-survey{{ $nama_survey->id }}">
                            <div class="container">
                                <div style="display: flex; align-items:center; justify-content:space-between; margin-top:10px;">
                                    <mark>Jumlah Responden : (<b class="text-info" id="jmlh_responden{{ $nama_survey->id }}">{{ $jml_responden }}</b>)</mark>
                                    <mark>Jumlah Responden Laki-Laki : (<b class="text-info" id="jmlh_laki_laki{{ $nama_survey->id }}"></b>)</mark>
                                    <mark>Jumlah Responden Perempuan : (<b class="text-info" id="jmlh_perempuan{{ $nama_survey->id }}"></b>)</mark>
                                </div>
                                <hr>
                            </div>
                            <section id="default-breadcrumb">
                                <div class="row">
                                    <div class="col-sm-4">     
                                        <div id="chart-gender{{ $nama_survey->id }}" class="mt-2 mb-1"></div> 
                                    </div>
                                    <div class="col-sm-4">  
                                        <div id="chart-angkatan{{ $nama_survey->id }}" class="mt-2 mb-1"></div> 
                                    </div>
                                    <div class="col-sm-4">  
                                        <div id="chart-prodi{{ $nama_survey->id }}" class="mt-2 mb-1"></div> 
                                    </div>
                                </div>  
                            </section>
                            <div class="container">
                            <h4 class="card-title">Pertanyaan Yang Memiliki Jawaban 1-4</h4>
                                <div class="table-responsive">
                                    <table id="table-jawaban-1-4{{ $nama_survey->id }}"  class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead class="table-info">
                                            <tr style="height: 22px;">
                                                <td class="text-center" style="width: 7.21582%; height: 44px;vertical-align: middle; text-align: center;" colspan="2" rowspan="2"><strong>NO</strong></td>
                                                <td class="text-center" style="width: 60%; height: 44px;vertical-align: middle; text-align: center;" rowspan="2"><strong>PERTANYAAN</strong></td>
                                                <td class="text-center" style="height: 22px; width: 40%;" colspan="5"><strong>JAWABAN</strong></td>
                                                <td class="text-center" style="width: 5%; height: 53px;vertical-align: middle; text-align: center;" rowspan="2"><strong>JUMLAH</strong></td>
                                                <td class="text-center" style="width: 30%;vertical-align: middle; text-align: center;" rowspan="2"><strong>JUMLAH NILAI PER UNSUR</strong></td>
                                                <td class="text-center" style="width: 11%;vertical-align: middle; text-align: center;" rowspan="2"><strong>NRR</strong></td>
                                            </tr>
                                            <tr style="height: 22px;">
                                                <td style="text-align: center; width: 5%; height: 22px;"><strong>1</strong></td>
                                                <td style="text-align: center; width: 5%; height: 22px;"><strong>2</strong></td>
                                                <td style="text-align: center; width: 5%; height: 22px;"><strong>3</strong></td>
                                                <td style="text-align: center; width: 5%; height: 22px;"><strong>4</strong></td>
                                                <td style="text-align: center; width: 5%; height: 22px;"><strong>5</strong></td>
                                            </tr>
                                        </thead>
                                        <tbody id="data-jawaban-1-4{{ $nama_survey->id }}">
                                            
                                        </tbody>
                                    </table>
                                </div>
                                
                                <h4 class="card-title">Pertanyaan Yang Memiliki Jawaban Ya atau Tidak</h4>
                                <div class="table-responsive">
                                    <table id="table-jawaban-ya-tidak{{ $nama_survey->id }}" class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead class="table-info">
                                            <tr style="height: 22px;">
                                            <td style="width: 7.21582%; height: 44px; vertical-align: middle; text-align: center; align-items:center;" colspan="2" rowspan="2"><strong>NO</strong></td>
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
                                        <tbody id="data-persentase-ya-tidak{{ $nama_survey->id }}">
                                        </tbody>
                                    </table>
                                </div>

                                <h4 class="card-title">Jawaban Terhadap Pertanyaan Esai</h4>
                                <div class="table-responsive">
                                    <table id="table-jawaban-esai{{ $nama_survey->id }}" class="table table-bordered" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead class="table-info">
                                            <tr>
                                                <th style="width: 7.21582%; height: 44px; text-align: center; align-items:center;">NO</th>
                                                <th>JAWABAN</th>
                                            </tr>
                                        </thead>
                                        <tbody id="jawaban-pertanyaan-esai{{ $nama_survey->id }}">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                @endforeach

                </div>
            </div>

            </div>
        </div>
    </div>
</div>

@section('js')
<!-- popup informasi -->
<script type="text/javascript">
<?php if(!empty($pengumuman->keterangan)): ?>
 
$(document).ready(function(){
    Swal.fire({
        text: "A custom <span style='color:red;'>html</span> message.",
        html: "{{ $pengumuman->keterangan }}",
        type: "info",
        imageUrl: '{{ asset($pengumuman->foto_pengumuman) }}',
        imageHeight: 550,
        imageWidth: 650,
        customClass: 'swal-wide',
        showCloseButton: true,
        showCancelButton: false,
        showConfirmButton:false
   });
});
<?php endif ?>
</script>
<!-- end popup informasi -->

<!-- laporan data survey -->
<script type="text/javascript">
function _pieChart(data_id){
    $('#data-laporan-survey'+data_id+'').block({css: { border: 'none', padding: '5px', backgroundColor: '#000', '-webkit-border-radius': '5px', '-moz-border-radius': '5px', opacity: .5, color: '#fff' }, message: '<i class="fa fa-spin fa-spinner"></i> Data Sedang Dipersiapkan...'}); 

    $('#jmlh_laki_laki'+data_id+'').html('');
    $('#jmlh_perempuan'+data_id+'').html('');
    $('#data-jawaban-1-4'+data_id+'').html('')
    $('#data-persentase-ya-tidak'+data_id+'').html('')
    $('#jawaban-pertanyaan-esai'+data_id+'').html('')
    var url = '{{ route("front.ajax.pie.cart", ":data_id") }}';
        url = url.replace(':data_id', data_id);
        $.ajax({
            url:url,
            type: "GET",
            dataType: "JSON",
            success:function(response){
                $('#jmlh_laki_laki'+data_id+'').append(response.laki_laki);
                $('#jmlh_perempuan'+data_id+'').append(response.perempuan);

                var lakiLaki = response.laki_laki;
                var perempuan = response.perempuan;
                if((lakiLaki == 0) && (perempuan == 0)){
                    
                }else{
                    var $chartGender = document.querySelector('#chart-gender'+data_id+'');
                    var $chartAngkatan = document.querySelector('#chart-angkatan'+data_id+'');
                    var $chartProdi = document.querySelector('#chart-prodi'+data_id+'');

                    // chart by gender
                    var options = {
                        series: [44, 55, 13, 43, 22],
                        chart: {
                                events: {
                                    dataPointSelection: function(event, chartContext, config) { 
                                    dataPegawai('JK', config.w.config.labels[config.dataPointIndex]);  
                                    }
                                },
                                type: 'pie',
                                height: 325,
                                toolbar: {
                                show: true
                                }
                            },
                            title: {
                                text: 'PERSENTASE  GENDER',
                                align: 'center'
                            },
                            labels: ['LAKI-LAKI', 'PEREMPUAN'],
                            series: [lakiLaki, perempuan],
                            colors: ['#FF6000', '#454545'],
                            dataLabels: {
                                enabled: true,
                                textAnchor: 'start',
                                formatter: function(val, opt) { 
                                    return opt.w.globals.labels[opt.seriesIndex] + ":  " + opt.w.globals.series[opt.seriesIndex]
                                },
                                offsetX: 0,
                            },
                        legend: { 
                            show: false,
                            showForSingleSeries: false,
                            showForNullSeries: true,
                            showForZeroSeries: true,
                            position: 'bottom',
                            horizontalAlign: 'center', 
                            floating: false,
                            fontSize: '14px',
                            fontFamily: 'Helvetica, Arial',
                            fontWeight: 400,
                            formatter: undefined,
                            inverseOrder: false,
                            width: undefined,
                            height: undefined,
                            tooltipHoverFormatter: undefined,
                            customLegendItems: [],
                            offsetX: 0,
                            offsetY: 0,
                            labels: {
                                colors: undefined,
                                useSeriesColors: false
                            },
                            markers: {
                                width: 12,
                                height: 12,
                                strokeWidth: 0,
                                strokeColor: '#fff',
                                fillColors: undefined,
                                radius: 12,
                                customHTML: undefined,
                                onClick: undefined,
                                offsetX: 0,
                                offsetY: 0
                            },
                            itemMargin: {
                                horizontal: 5,
                                vertical: 0
                            },
                            onItemClick: {
                                toggleDataSeries: true
                            },
                            onItemHover: {
                                highlightDataSeries: true
                            },
                        },
                    };
                    var chart = new ApexCharts($chartGender, options);
                    chart.render();
                    
                    if(response.dataJenisSurvey == 4){
                        // chart by angkatan
                        let label = [];
                        let series = [];
                        for (let x = 0; x < response.angkatan.length; x++) {
                            label = label.concat('ANGKATAN '+response.angkatan[x].angkatan+'');
                            var response_data;
                            $.ajax({
                                url: "{{ route('ajax.get.persentase.angkatan') }}",
                                type: "GET",
                                async: false,
                                data: {
                                    idNamaSurvey: data_id,
                                    dataTahun: response.angkatan[x].angkatan
                                },
                                dataType: "JSON",
                                success:function(result){
                                    response_data = result.jumlah;
                                }
                            });
                            series = series.concat(response_data);
                            
                        }
            
                        var options = {
                            label: [44, 55, 13, 43, 22],
                            chart: {
                                    events: {
                                        dataPointSelection: function(event, chartContext, config) { 
                                        dataPegawai('JK', config.w.config.labels[config.dataPointIndex]);  
                                        }
                                    },
                                    type: 'pie',
                                    height: 325,
                                    toolbar: {
                                    show: true
                                    }
                                },
                                title: {
                                    text: 'PERSENTASE  ANGKATAN',
                                    align: 'center'
                                },
                                labels: label,
                                series: series,
                                dataLabels: {
                                    enabled: true,
                                    textAnchor: 'start',
                                    formatter: function(val, opt) { 
                                        return opt.w.globals.labels[opt.seriesIndex] + ":  " + opt.w.globals.series[opt.seriesIndex]
                                    },
                                    offsetX: 0,
                                },
                            legend: { 
                                show: false,
                                showForSingleSeries: false,
                                showForNullSeries: true,
                                showForZeroSeries: true,
                                position: 'bottom',
                                horizontalAlign: 'center', 
                                floating: false,
                                fontSize: '14px',
                                fontFamily: 'Helvetica, Arial',
                                fontWeight: 400,
                                formatter: undefined,
                                inverseOrder: false,
                                width: undefined,
                                height: undefined,
                                tooltipHoverFormatter: undefined,
                                customLegendItems: [],
                                offsetX: 0,
                                offsetY: 0,
                                labels: {
                                    colors: undefined,
                                    useSeriesColors: false
                                },
                                markers: {
                                    width: 12,
                                    height: 12,
                                    strokeWidth: 0,
                                    strokeColor: '#fff',
                                    fillColors: undefined,
                                    radius: 12,
                                    customHTML: undefined,
                                    onClick: undefined,
                                    offsetX: 0,
                                    offsetY: 0
                                },
                                itemMargin: {
                                    horizontal: 5,
                                    vertical: 0
                                },
                                onItemClick: {
                                    toggleDataSeries: true
                                },
                                onItemHover: {
                                    highlightDataSeries: true
                                },
                            },
                        };
                        var chart = new ApexCharts($chartAngkatan, options);
                        chart.render();

                        // chart by prodi
                        let labelProdi = [];
                        let seriesProdi = [];
                        for (let x = 0; x < response.prodi.length; x++) {
                            labelProdi = labelProdi.concat(response.prodi[x].prodi);
                            var response_prodi;
                            $.ajax({
                                url: "{{ route('ajax.get.persentase.prodi') }}",
                                type: "GET",
                                async: false,
                                data: {
                                    idNamaSurvey: data_id,
                                    dataProdi: response.prodi[x].prodi
                                },
                                dataType: "JSON",
                                success:function(resultPoridi){
                                    response_prodi = resultPoridi.jumlah;
                                }
                            });
                            // console.log(response_prodi);
                            seriesProdi = seriesProdi.concat(response_prodi);
                        }
                        var options = {
                            label: [44, 55, 13, 43, 22],
                            chart: {
                                    events: {
                                        dataPointSelection: function(event, chartContext, config) { 
                                        dataPegawai('JK', config.w.config.labels[config.dataPointIndex]);  
                                        }
                                    },
                                    type: 'pie',
                                    height: 325,
                                    toolbar: {
                                    show: true
                                    }
                                },
                                title: {
                                    text: 'PERSENTASE PRODI',
                                    align: 'center'
                                },
                                labels: labelProdi,
                                series: seriesProdi,
                                dataLabels: {
                                    enabled: true,
                                    textAnchor: 'start',
                                    formatter: function(val, opt) { 
                                        return opt.w.globals.labels[opt.seriesIndex] + ":  " + opt.w.globals.series[opt.seriesIndex]
                                    },
                                    offsetX: 0,
                                },
                            legend: { 
                                show: false,
                                showForSingleSeries: false,
                                showForNullSeries: true,
                                showForZeroSeries: true,
                                position: 'bottom',
                                horizontalAlign: 'center', 
                                floating: false,
                                fontSize: '14px',
                                fontFamily: 'Helvetica, Arial',
                                fontWeight: 400,
                                formatter: undefined,
                                inverseOrder: false,
                                width: undefined,
                                height: undefined,
                                tooltipHoverFormatter: undefined,
                                customLegendItems: [],
                                offsetX: 0,
                                offsetY: 0,
                                labels: {
                                    colors: undefined,
                                    useSeriesColors: false
                                },
                                markers: {
                                    width: 12,
                                    height: 12,
                                    strokeWidth: 0,
                                    strokeColor: '#fff',
                                    fillColors: undefined,
                                    radius: 12,
                                    customHTML: undefined,
                                    onClick: undefined,
                                    offsetX: 0,
                                    offsetY: 0
                                },
                                itemMargin: {
                                    horizontal: 5,
                                    vertical: 0
                                },
                                onItemClick: {
                                    toggleDataSeries: true
                                },
                                onItemHover: {
                                    highlightDataSeries: true
                                },
                            },
                        };
                        var chart = new ApexCharts($chartProdi, options);
                        chart.render();
                    }
                }

                //tabulasi pertanyaan 1-4
                $.each(response.hasil_survey_1_4, function(key,value){
                    // jumlah pertanyaan
                    var jml_pertanyaan1;
                    var jml_pertanyaan2;
                    var jml_pertanyaan3;
                    var jml_pertanyaan4;
                    var jml_pertanyaan5;

					var $key = key + 1;
                    var urlp = '{{ route("ajax.jml.pertanyaan.1.4", ":data_id") }}';
                        urlp = urlp.replace(':data_id', value.id);
                    $.ajax({
                        url:urlp,
                        type: "GET",
                        async: false,
                        dataType: "JSON",
                        success:function(resultp){
                            jml_pertanyaan1 = resultp.jml_pertanyaan1;
                            jml_pertanyaan2 = resultp.jml_pertanyaan2;
                            jml_pertanyaan3 = resultp.jml_pertanyaan3;
                            jml_pertanyaan4 = resultp.jml_pertanyaan4;
                            jml_pertanyaan5 = resultp.jml_pertanyaan5;
                        }
                    });
                    // jumlah responden
                    var jumlah_responden = jml_pertanyaan1 + jml_pertanyaan2 + jml_pertanyaan3 + jml_pertanyaan4 + jml_pertanyaan5;
                    // nilai perunsur
                    var nilai_perunsur_1 = jml_pertanyaan1 * 1;
                    var nilai_perunsur_2 = jml_pertanyaan2 * 2;
                    var nilai_perunsur_3 = jml_pertanyaan3 * 3;
                    var nilai_perunsur_4 = jml_pertanyaan4 * 4;
                    var nilai_perunsur_5 = jml_pertanyaan5 * 5;
                    var nilai_perunsur = nilai_perunsur_1 + nilai_perunsur_2 + nilai_perunsur_3 + nilai_perunsur_4 + nilai_perunsur_5;
                    //jumlah nnr
                    var nnr_format = nilai_perunsur / jumlah_responden;
                    var nnr = nnr_format.toFixed(2);

                    $('#data-jawaban-1-4'+data_id+'').append('<tr>\
                                                <td colspan="2" align="center">'+$key+'</td>\
                                                <td style="width: 14.9898%; text-align: justify;">'+value.pertanyaan+'</td>\
                                                <td align="center">'+jml_pertanyaan1+'</td>\
                                                <td align="center">'+jml_pertanyaan2+'</td>\
                                                <td align="center">'+jml_pertanyaan3+'</td>\
                                                <td align="center">'+jml_pertanyaan4+'</td>\
                                                <td align="center">'+jml_pertanyaan5+'</td>\
                                                <td align="center">'+jumlah_responden+'</td>\
                                                <td align="center">'+nilai_perunsur+'</td>\
                                                <td align="center">'+nnr+'</td>\
                                            </tr>  ')
				});
                var $pr1 = response.qr1 *1;
                var $pr2 = response.qr2 *2;
                var $pr3 = response.qr3 *3;
                var $pr4 = response.qr4 *4;
                var $pr5 = response.qr5 *5;
                var $jumlahDataPertanyaan = response.hasil_survey_1_4.length;
                var $jumlahdataQr = response.qr1 + response.qr2 + response.qr3 + response.qr4 + response.qr5;
                var $jumlah_pr = $pr1 + $pr2 + $pr3 + $pr4 + $pr5;
                if($jumlahDataPertanyaan == 0){
                    var $rata_rata = 0;
                }else{
                    var rata_rata_fromat = $jumlah_pr / $jumlahdataQr;
                    var $rata_rata = rata_rata_fromat.toFixed(2);
                }
                if($rata_rata != 0){
                $('#data-jawaban-1-4'+data_id+'').append('<tr style="height: 22px; background-color: #f1f1f1;">\
                                                <td style="width: 62.0912%; text-align: center; height: 22px; color:#000000;  font-weight: 900;font-weight: bolder;" colspan="9"><strong>NRR PER UNSUR</strong></td>\
                                                <td style="width: 6.28834%; text-align: center; height: 22px;" colspan="2"><strong>'+$rata_rata+'</strong></td>\
                                            </tr>  ')
                }

                //tabulasi ya tidak
                $.each(response.hasil_survey_ya_tidak, function(key,value){
                    
                    var jumlah_ya;
                    var jumlah_tidak;
					var $key = key + 1;

                    var urlq = '{{ route("ajax.jml.ya.yidak", ":data_id") }}';
                        urlq = urlq.replace(':data_id', value.id);
                    $.ajax({
                        url:urlq,
                        type: "GET",
                        async: false,
                        dataType: "JSON",
                        success:function(resultq){
                            jumlah_ya = resultq.jumlah_ya;
                            jumlah_tidak = resultq.jumlah_tidak;
                        }
                    });
                    var ya_tidak_r = jumlah_ya + jumlah_tidak;
                    
                    var q_ya = jumlah_ya / ya_tidak_r * 100;
                    var q_tidak = jumlah_tidak / ya_tidak_r * 100;
                    if(q_ya == 100){
                        var $persentase_ya =  q_ya;
                        var $persentase_tidak =  q_tidak;
                    }else{
                        var $persentase_ya =  q_ya.toFixed(2)
                        var $persentase_tidak =  q_tidak.toFixed(2);
                    }

                    $('#data-persentase-ya-tidak'+data_id+'').append('<tr>\
                                                <td colspan="2" align="center">&nbsp;'+$key+'</td>\
                                                <td style="width: 14.9898%; text-align: justify;">'+value.pertanyaan+'</td>\
                                                <td align="center">'+jumlah_ya+'</td>\
                                                <td align="center">'+jumlah_tidak+'</td>\
                                                <td align="center">'+$persentase_ya+'%</td>\
                                                <td align="center">'+$persentase_tidak+'%</td>\
                                            </tr>')
				});

                //tabulasi terhadapat pertanyaan esai
                $.each(response.hasil_esai, function(key,value){
					var $key = key + 1;
                    $('#jawaban-pertanyaan-esai'+data_id+'').append('<tr>\
                                            <td align="center">'+$key+'</td>\
                                            <td>'+value.jawaban+'</td></tr>\
                                        </tr>')
				});
                $('#data-laporan-survey'+data_id+'').unblock(); 
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
@stop