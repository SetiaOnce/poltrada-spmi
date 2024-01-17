<!-- trend data pengajuan audit -->
<script type="text/javascript">
$(document).ready(function(){
    var statistic = {!! $statistik !!};    
    var optionsAudit = {
        series: [{
            name: "Info",
            data: statistic,
        }],
        chart: {
            height: 350,
            type: 'line',
            zoom: {
                enabled: false
            },
            events: {
                click(event, chartContext, config ) {
                    $.ajax({
                        url:'{{ route("prodi.ajax.detail.trend.audit") }}',
                        type: "GET",
                        data: {
                            dataBulan: config.dataPointIndex,
                            dataTahun: $('input[name="filter_tahun"]').val()
                        },
                        dataType: "JSON",
                        success:function(response){
                            $("#dataDetailAudit").html('');
                            $("#headeBulan").html('');
                            $("#headerTahun").html('');
                            $('#modalDetail').modal('show');

                            $("#headeBulan").append(response.namaBulan);
                            $("#headerTahun").append(response.dataTahun);
                            $.each(response.data, function(key,value){
                                var $key = key + 1;
                                if(value.status_pengajuan == 1){
                                    var status = '<span class="badge bg-info">DALAM PROSES PENGAJUAN</span>';
                                }else if(value.status_pengajuan == 2){
                                    var status = '<span class="badge bg-success">SUDAH SELESAI</span>';
                                }
                                $("#dataDetailAudit").append('<tr>\
                                        <td align="center">'+$key+'</td>\
                                        <td>'+value.tahun+'</td>\
                                        <td>'+value.nama_lembaga+'</td>\
                                        <td>'+value.jenis_standar+'</td>\
                                        <td>'+value.unit_kerja+'</td>\
                                        <td>'+status+'</td>\
                                    </tr>')
                            });
                        }
                    });
                }
            },
            
        },
        dataLabels: {
            enabled: true,
            textAnchor: 'start',
            formatter: function(val, opt) { 
            return val
            },
            offsetX: 0,
            },
        stroke: {
        curve: 'straight'
        },
        title: {
            text: 'TREND PENGAJUAN AUDIT PERTAHUN',
            align: 'left'
        },
        grid: {
        row: {
            colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
            opacity: 0.5
        },
        },
        xaxis: {
        categories: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
        },
        tooltip: {
            y: {
                formatter: function (val) {
                return "Trend Pengajuan Audit: " + val + " data"
                }
            }
        },
        events: {
            dataPointMouseUp: function(event, chartContext, { seriesIndex, dataPointIndex, w }) {
            // Show the modal with the corresponding data
            var dataPointValue = w.config.series[seriesIndex].data[dataPointIndex];
            var dataPointCategory = w.config.xaxis.categories[dataPointIndex];
            showModal(dataPointCategory, dataPointValue);
            }
        }
    };

    var chartAudit = new ApexCharts(document.querySelector("#chart-trend-audit"), optionsAudit);
    chartAudit.render();
    
    $('input[name="filter_tahun"]').change(function() {
        var dataTahun = $(this).val();
        $.ajax({
            url:'{{ route("prodi.ajax.trend.audit") }}',
            type: "GET",
            data: {
                dataTahun: dataTahun
            },
            dataType: "JSON",
            success:function(response){
                var Datastatistik = response.statistik;
                chartAudit.updateSeries([{
                    name: 'info',
                    data: Datastatistik
                }]);
            }
        });
    });

});   
</script>

<!-- laporan data survey -->
<script type="text/javascript">
function _pieChart(data_id){
    $('#data-laporan-survey'+data_id+'').block({css: { border: 'none', padding: '5px', backgroundColor: '#000', '-webkit-border-radius': '5px', '-moz-border-radius': '5px', opacity: .5, color: '#fff' }, message: '<i class="fa fa-spin fa-spinner"></i> Data Sedang Dipersiapkan...'}); 

    $('#jmlh_laki_laki'+data_id+'').html('');
    $('#jmlh_perempuan'+data_id+'').html('');
    $('#data-jawaban-1-4'+data_id+'').html('')
    $('#data-persentase-ya-tidak'+data_id+'').html('')
    $('#jawaban-pertanyaan-esai'+data_id+'').html('')
    var url = '{{ route("prodi.ajax.pie.cart", ":data_id") }}';
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
                                url: "{{ route('prodi.ajax.get.persentase.angkatan') }}",
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
                                url: "{{ route('prodi.ajax.get.persentase.prodi') }}",
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

					var $key = key + 1;
                    var urlp = '{{ route("prodi.ajax.jml.pertanyaan.1.4", ":data_id") }}';
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
                        }
                    });
                    // jumlah responden
                    var jumlah_responden = jml_pertanyaan1 + jml_pertanyaan2 + jml_pertanyaan3 + jml_pertanyaan4;
                    // nilai perunsur
                    var nilai_perunsur_1 = jml_pertanyaan1 * 1;
                    var nilai_perunsur_2 = jml_pertanyaan2 * 2;
                    var nilai_perunsur_3 = jml_pertanyaan3 * 3;
                    var nilai_perunsur_4 = jml_pertanyaan4 * 4;
                    var nilai_perunsur = nilai_perunsur_1 + nilai_perunsur_2 + nilai_perunsur_3 + nilai_perunsur_4;
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
                                                <td align="center">'+jumlah_responden+'</td>\
                                                <td align="center">'+nilai_perunsur+'</td>\
                                                <td align="center">'+nnr+'</td>\
                                            </tr>  ')
				});
                var $pr1 = response.qr1 *1;
                var $pr2 = response.qr2 *2;
                var $pr3 = response.qr3 *3;
                var $pr4 = response.qr4 *4;
                var $jumlahDataPertanyaan = response.hasil_survey_1_4.length;
                var $jumlahdataQr = response.qr1 + response.qr2 + response.qr3 + response.qr4;
                var $jumlah_pr = $pr1 + $pr2 + $pr3 + $pr4;
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

                    var urlq = '{{ route("prodi.ajax.jml.ya.yidak", ":data_id") }}';
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