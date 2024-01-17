<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Persentasi Survey SPMI</title>
    <style>
    #persentase {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
    }

    #persentase td, #persentase th {
    border: 1px solid #ddd;
    padding: 8px;
    }

    #persentase tr:nth-child(even){background-color: #f2f2f2;}

    #persentase tr:hover {background-color: #ddd;}

    #persentase th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #04AA6D;
    color: white;
    }
    </style>
</head>
<body>
<h2 style="text-align: center; color: #ff0000;"><span style="color: #000000;"><strong>{{ strtoupper($nama_survey->nama_survey ) }}&nbsp;</strong></span></h2>
    <ul style="list-style-type: square;">
        <li><strong>Jumlah Responden : (<span style="color: #3598db;"> {{ $jml_responden }} </span> )</strong></li>
        <li><strong>Jumlah Responden Laki-Laki : ( <span style="color: #3598db;"> {{ $jml_laki_laki }} </span>)</strong></li>
        <li><strong>Jumlah Responden Perempuan : ( <span style="color: #3598db;"> {{ $jml_perempuan }} </span> )</strong></li>
    </ul>
    <h4 style="text-align: left; margin-bottom:-0px;"><span>Pertanyaan Yang Memiliki Jawaban 1-4</span></h4>
    <table id="persentase">
        <thead class="table-info">
            <tr style="height: 22px;">
                <!-- <th style="width: 7%; height: 44px; text-align: center; align-items:center;" colspan="2" rowspan="2">
                    <strong>NO</strong>
                </th> -->
                <th style="width: 60%; height: 44px; text-align: center;" rowspan="2">
                    <strong>PERTANYAAN</strong>
                </th>
                <th style="height: 22px; text-align: center; width: 40%;" colspan="4">
                    <strong>JAWABAN</strong>
                </th>
                <th style="width: 10%; height: 44px; text-align: center;" rowspan="2">
                    <strong>JUMLAH</strong>
                </th><th style="width: 10%; height: 44px; text-align: center;" rowspan="2">
                    <strong>JUMLAH NILAI PER UNSUR</strong>
                </th><th style="width: 10%; height: 44px; text-align: center;" rowspan="2">
                    <strong>NRR</strong>
                </th>
            </tr>
            <tr style="height: 22px;">
                <th style="text-align: center; width: 5%; height: 22px;"><strong>1</strong></th>
                <th style="text-align: center; width: 5%; height: 22px;"><strong>2</strong></th>
                <th style="text-align: center; width: 5%; height: 22px;"><strong>3</strong></th>
                <th style="text-align: center; width: 5%; height: 22px;"><strong>4</strong></th>
            </tr>
        </thead>
        <tbody>
        @foreach($hasil_survey_1_4 as $no => $hasil_1_4)
            @php
                $jml_pertanyaan1 =  App\Models\DataHasilSurvey::where('jawaban', 1)->where('id_pertanyaan_survey', $hasil_1_4->id)->count();
                $jml_pertanyaan2 =  App\Models\DataHasilSurvey::where('jawaban', 2)->where('id_pertanyaan_survey',   $hasil_1_4->id)->count();
                $jml_pertanyaan3 =  App\Models\DataHasilSurvey::where('jawaban', 3)->where('id_pertanyaan_survey',   $hasil_1_4->id)->count();
                $jml_pertanyaan4 =  App\Models\DataHasilSurvey::where('jawaban', 4)->where('id_pertanyaan_survey',   $hasil_1_4->id)->count();

                $jumlah_responden = $jml_pertanyaan1 + $jml_pertanyaan2 + $jml_pertanyaan3 + $jml_pertanyaan4;

                $nilai_perunsur_1 = $jml_pertanyaan1 * 1;
                $nilai_perunsur_2 = $jml_pertanyaan2 * 2;
                $nilai_perunsur_3 = $jml_pertanyaan3 * 3;
                $nilai_perunsur_4 = $jml_pertanyaan4 * 4;

                $nilai_perunsur = $nilai_perunsur_1 + $nilai_perunsur_2 + $nilai_perunsur_3 + $nilai_perunsur_4;

                $nnr = number_format( $nilai_perunsur / $jumlah_responden, 2);
            @endphp
            <tr>
                <!-- <td colspan="2">&nbsp;{{ $no+1 }}</td> -->
                <td style="width: 14.9898%; text-align: justify;">{{ $hasil_1_4->pertanyaan }}</td>
                <td style="text-align: center;">&nbsp;{{ $jml_pertanyaan1 }}</td>
                <td style="text-align: center;">&nbsp;{{ $jml_pertanyaan2 }}</td>
                <td style="text-align: center;">&nbsp;{{ $jml_pertanyaan3 }}</td>
                <td style="text-align: center;">&nbsp;{{ $jml_pertanyaan4 }}</td>
                <td style="text-align: center;">&nbsp;{{ $jumlah_responden }}</td>
                <td style="text-align: center;">&nbsp;{{ $nilai_perunsur }}</td>
                <td style="text-align: center;">&nbsp;{{ $nnr }}</td>
            </tr>   
            @endforeach 
        </tbody>
    </table>

    <h4 style="text-align: left; margin-bottom:-0px;"><span>Pertanyaan Yang Memiliki Jawaban Ya/Tidak</span></h4>
    <table id="persentase">
        <thead class="table-info">
            <tr style="height: 22px;">
                <!-- <td style="width: 7.21582%; height: 44px; text-align: center; align-items:center;" colspan="2" rowspan="2"><strong>NO</strong></td> -->
                <th style="width: 30%; height: 44px; text-align: center;" rowspan="2"><strong>PERTANYAAN</strong></th>
                <th style="height: 22px; text-align: center; width: 40%;" colspan="2"><strong>JAWABAN</strong></th>
                <th style="text-align: center; width: 36.8661%; height: 22px;" colspan="2"><strong>PERSENTASE</strong></th>
            </tr>
            <tr style="height: 22px;">
                <th style="text-align: center; width: 5%; height: 22px;"><strong>Ya</strong></th>
                <th style="text-align: center; width: 5%; height: 22px;"><strong>Tidak</strong></th>
                <th style="text-align: center; width: 5%; height: 22px;"><strong>Ya</strong></th>
                <th style="text-align: center; width: 5%; height: 22px;"><strong>Tidak</strong></th>
            </tr>
        </thead>
        <tbody>
        <!-- perhitungan persentase berdasarkan jawaban ya-tidak -->
        @foreach($hasil_survey_ya_tidak as $no2 => $hasil_ya_tidak)
        @php
            $jml_ya =  App\Models\DataHasilSurvey::where('jawaban', 'Ya')->where('id_pertanyaan_survey',  $hasil_ya_tidak->id)->count();
            $jml_tidak =  App\Models\DataHasilSurvey::where('jawaban', 'Tidak')->where('id_pertanyaan_survey',  $hasil_ya_tidak->id)->count();

            $r = $jml_ya + $jml_tidak;
            $q_ya = $jml_ya / $r * 100;
            $q_tidak = $jml_tidak / $r * 100;
            if($q_ya == 100){
                $persentase_ya =  $q_ya.'%';
                $persentase_tidak =  $q_tidak.'%';
            }else{
                $persentase_ya =  number_format($q_ya, 2).'%';
                $persentase_tidak =  number_format($q_tidak, 2).'%';
            }
        @endphp
            <tr>
                <!-- <td colspan="2" align="center">&nbsp;{{ $no2+1 }}</td> -->
                <td style="width: 14.9898%; text-align: justify;">{{ $hasil_ya_tidak->pertanyaan }}</td>
                <td style="text-align: center;" align="center">{{ $jml_ya }}</td>
                <td style="text-align: center;" align="center">{{ $jml_tidak }}</td>
                <td style="text-align: center;" align="center">{{ $persentase_ya }}</td>
                <td style="text-align: center;" align="center">{{ $persentase_tidak }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h4 style="text-align: left; margin-bottom:-0px;"><span>Jawaban Terhadap Pertanyaan Esai</span></h4>
    <table id="persentase">
        <thead class="table-info">
            <tr>
                <th style="width: 7.21582%; height: 44px; text-align: center; align-items:center;">NO</th>
                <th>JAWABAN</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hasil_esai as $no3 => $esai)
            <tr>
                <td align="center">{{ $no3+1 }}</td>
                <td>{{ $esai->jawaban }}</td></tr>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>