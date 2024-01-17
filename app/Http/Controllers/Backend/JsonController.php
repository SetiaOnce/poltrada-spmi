<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Backend\Rules\Pengelola\HasilSurveyController;
use App\Http\Controllers\Controller;
use App\Models\AkademikMahasiswa;
use App\Models\AkademikProdi;
use App\Models\DataHasilSurvey;
use App\Models\EventSurvey;
use App\Models\GroupPegawai;
use App\Models\ManajemenPeraturan;
use App\Models\ManajemenProduk;
use App\Models\NamaSurvey;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

use function PHPUnit\Framework\isNull;

class JsonController extends Controller
{
    public function TinymceUpload(Request $request)
    {
        // $data = $request->validate([
        //     'file' => 'mimes:jpg,jpeg,png|max:1048'
        // ]);
        
        $mainImage = $request->file('file');
        $filename = time() . '.' . $mainImage->extension();
        Image::make($mainImage)->save(public_path('img/tinymce/'.$filename));
        return json_encode(['location' => asset('img/tinymce/'.$filename)]);
    }

    // get produk
    public function getPorduk(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = ManajemenProduk::latest()->where('jenis_produk_id', $id)->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('btn', function($row) {
                        return '<a href="'.asset(($row->file_pdf)).'" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" title="Lihat Pdf" target="_blank">
                        LIHAT PDF
                    </a>';
                    })
                    ->rawColumns(['btn'])
                    ->make(true);
        }
    }

    public function getPeraturan(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = ManajemenPeraturan::latest()->where('jenis_peraturan_id', $id)->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('btn', function($row) {
                        return '<a href="'.asset(($row->file_pdf)).'" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" title="Lihat Pdf" target="_blank">
                        LIHAT PDF
                    </a>';
                    })
                    ->rawColumns(['btn'])
                    ->make(true);
        }
    }

    public function CekNotar(Request $request)
    {
        $notar = $request->input('notar');
        $jenis_survey_id = $request->input('jenis_survey_id');
        
        $checkNotar = AkademikMahasiswa::where('nim', $notar)->first();
        if(!empty($checkNotar)) {
            $taruna = $checkNotar;
            $prodi = AkademikProdi::where('kode_prodi', $taruna->kode_prodi)->first();
            $data = [
                'success'    => true,
                'nim'    => $taruna->nim,
                'nik'    => $taruna->nik,
                'nama'  => $taruna->nama,
                'jenis_kelamin'   => $taruna->jenis_kelamin,
                'email' => $taruna->email,
                'tahun_masuk' => $taruna->angkatan,
                'jenjang' => $prodi->nama_jenjang,
                'prodi' => $prodi->nama_prodi,
            ];
        } else{
            $data = [
                'error' => true
            ];
            return response()->json($data);
        }

        $data['data_event_survey'] = EventSurvey::select(
            "spm_event_survey.id",
            "spm_event_survey.nama_survey_id",
        )
        ->join("spm_nama_survey", "spm_nama_survey.id", "=", "spm_event_survey.nama_survey_id")
        ->join("spm_data_jenis_survey", "spm_data_jenis_survey.id", "=", "spm_nama_survey.jenis_survey_id")
        ->where("spm_nama_survey.jenis_survey_id", $jenis_survey_id)
        ->get();

        $data['hasil_survey'] = DataHasilSurvey::select(
            "spm_data_hasil_survey.id_nama_survey",
        )
        ->join("spm_nama_survey", "spm_nama_survey.id", "=", "spm_data_hasil_survey.id_nama_survey")
        ->where("spm_data_hasil_survey.nim", $notar)
        ->where("spm_nama_survey.jenis_survey_id", $jenis_survey_id)
        ->groupBy('spm_data_hasil_survey.id_nama_survey')
        ->get();

        return response()->json([
            'success' => true,
            'data' => $data,
            'hasil_survey' =>  $data['hasil_survey'],
            'event_survey' =>  $data['data_event_survey'],
        ], 200);
        
    }

    public function CekEmail(Request $request)
    {
        $cek_email = $request->input('cek_email');
        $jenis_survey_id = $request->input('jenis_survey_id');
        
        $checkEmail = GroupPegawai::where('email', $cek_email)->first();

        if(!empty($checkEmail)) {
            $pegawai = $checkEmail;
            $data = [
                'success'    => true,
                'nim'    => '-',
                'nik'    => $pegawai->nik,
                'nama'  => $pegawai->nama,
                'jenis_kelamin'   => $pegawai->jenis_kelamin,
                'email' => $pegawai->email,
                'tahun_masuk' => 0,
            ];
        } else{
            $data = [
                'error' => true
            ];
            return response()->json($data);
        }

        $data['data_event_survey'] = EventSurvey::select(
            "spm_event_survey.id",
            "spm_event_survey.nama_survey_id",
        )
        ->join("spm_nama_survey", "spm_nama_survey.id", "=", "spm_event_survey.nama_survey_id")
        ->join("spm_data_jenis_survey", "spm_data_jenis_survey.id", "=", "spm_nama_survey.jenis_survey_id")
        ->where("spm_nama_survey.jenis_survey_id", $jenis_survey_id)
        ->get();

        $data['hasil_survey'] = DataHasilSurvey::select(
            "spm_data_hasil_survey.id_nama_survey",
        )
        ->join("spm_nama_survey", "spm_nama_survey.id", "=", "spm_data_hasil_survey.id_nama_survey")
        ->where("spm_data_hasil_survey.email", $cek_email)
        ->where("spm_nama_survey.jenis_survey_id", $jenis_survey_id)
        ->groupBy('spm_data_hasil_survey.id_nama_survey')
        ->get();

        return response()->json([
            'success' => true,
            'data' => $data,
            'hasil_survey' =>  $data['hasil_survey'],
            'event_survey' =>  $data['data_event_survey'],
        ], 200);
        
    }

    public function PertanyaanSurveySave(Request $request)
    {
        $jenis_survey = $request->input('jenis_survey');

        $id_nama_survey = $request->input('id_nama_survey');
        $id_event_survey = $request->input('id_event_survey');
        $nim = $request->input('nim');
        $nik = $request->input('nik');
        $nama = $request->input('nama');
        $jenis_kelamin = $request->input('jenis_kelamin');
        $email = $request->input('email');
        $tahun_masuk = $request->input('tahun_masuk');
        $jenjang = $request->input('jenjang');
        $prodi = $request->input('prodi');

        $jumlah = $request->input('jumlah');
        
        $id_pertanyaan    =$request->input('id');

        // cek pengisian survey berdasarkan nama survey
        if($jenis_survey == 4){
            $cek_survey = DataHasilSurvey::where('nim', $nim)->where('id_nama_survey', $id_nama_survey)->first();
            if(!empty($cek_survey->nim)){
                $data = [
                    'already' => true,
                    'nama'  => $nama,
                ];
                return response()->json($data);
            }
        }else{
            $cek_survey = DataHasilSurvey::where('email', $email)->where('id_nama_survey', $id_nama_survey)->first();
            if(!empty($cek_survey->email)){
                $data = [
                    'already' => true,
                    'nama'  => $nama,
                ];
                return response()->json($data);
            }
        }

        // loop cek pertanyaan survey yang kosong
        for($i=0;$i<$jumlah;$i++){
            $id  = $id_pertanyaan[$i];
            $no=$i+1;
            
            $validasi = validator()->make($request->all(),[
                'jawaban'.$id.'' => 'required|max:255',
            ],[
                'jawaban'.$id.'.required' => 'Langkah tidak dapat dilanjutkan, pertanyaan no '.$no.' belum dijawab silakan lengkapi terlebih dahulu...',
                'jawaban'.$id.'.max' => 'Pertanyaan No '.$no.' jawaban tidak boleh lebih dari 255 karakter',
            ]);

            if($validasi->fails()){
                return response()->json([
                    'errors' => $validasi->errors(),
                    'id' => $id
                ]);
            }
        }
        
        //loop penyimpanan jawaban survey
        for($i=0;$i<$jumlah;$i++){
            $id    =$id_pertanyaan[$i];

            DataHasilSurvey::create([
                'nik' => $nik,
                'nama' => $nama,
                'jenis_kelamin' => $jenis_kelamin,
                'email' => $email,
                'nim' => $nim,
                'tahun_masuk' => $tahun_masuk,
                'jenjang' => $jenjang,
                'prodi' => $prodi,
                'id_event_survey' => $id_event_survey,
                'id_nama_survey' => $id_nama_survey,
                'id_pertanyaan_survey' => $id,
                'jawaban' => $request->input('jawaban'.$id.''),
                'keterangan' => "-",
                'created_at' => Carbon::now()
            ]);

        }

        return response()->json([
            'success' => true,
            'data' => $id_pertanyaan
        ], 200);

    }

    public function ajaxPieCart($id)
    {
        $jenis_survey = NamaSurvey::select(
            "spm_data_jenis_survey.id",
        )
        ->join("spm_data_jenis_survey", "spm_data_jenis_survey.id", "=", "spm_nama_survey.jenis_survey_id")
        ->where('spm_nama_survey.id', $id)
        ->first();

        // count gender
        if($jenis_survey->id == 4){
            $data['jml_laki_laki'] = DB::table('spm_data_hasil_survey')
            ->where('jenis_kelamin', 'LAKI-LAKI')
            ->where('id_nama_survey', $id)
            ->groupBy('email')
            ->get()
            ->count();
    
            $data['jml_perempuan'] = DB::table('spm_data_hasil_survey')
            ->where('jenis_kelamin', 'WANITA')
            ->where('id_nama_survey', $id)
            ->groupBy('email')
            ->get()
            ->count();
        }else{
            $data['jml_laki_laki'] = DB::table('spm_data_hasil_survey')
            ->where('jenis_kelamin', 'LAKI-LAKI')
            ->where('id_nama_survey', $id)
            ->groupBy('email')
            ->get()
            ->count();
    
            $data['jml_perempuan'] = DB::table('spm_data_hasil_survey')
            ->where('jenis_kelamin', 'PEREMPUAN')
            ->where('id_nama_survey', $id)
            ->groupBy('email')
            ->get()
            ->count();
        }
        
        // persentase angkatan
        $data['angakatan'] = DataHasilSurvey::select(
            'spm_data_hasil_survey.tahun_masuk as angkatan', DB::raw('count(*) as total')
        )
        ->join('spm_nama_survey', 'spm_nama_survey.id', '=', 'spm_data_hasil_survey.id_nama_survey')
        ->where('jenis_survey_id', 4)
        ->where('id_nama_survey', $id)
        ->groupBy('tahun_masuk')
        ->get();

        // persentase prodi
        $data['prodi'] = DataHasilSurvey::select(
            'spm_data_hasil_survey.prodi as prodi', DB::raw('count(*) as total')
        )
        ->join('spm_nama_survey', 'spm_nama_survey.id', '=', 'spm_data_hasil_survey.id_nama_survey')
        ->where('jenis_survey_id', 4)
        ->where('id_nama_survey', $id)
        ->groupBy('prodi')
        ->get();

        // jawaban survey 1 sampai 4
        $data['hasil_survey_1_4'] = DataHasilSurvey::select(
            "spm_data_hasil_survey.nim",
            "spm_pertanyaan_survey.pertanyaan",
            "spm_pertanyaan_survey.jenis",
            "spm_pertanyaan_survey.id",
            "spm_data_hasil_survey.jawaban",
        )
        ->join("spm_pertanyaan_survey", "spm_pertanyaan_survey.id", "=", "spm_data_hasil_survey.id_pertanyaan_survey")
        ->where('spm_data_hasil_survey.id_nama_survey',  $id)
        ->where('spm_pertanyaan_survey.jenis', 1)
        ->where('spm_pertanyaan_survey.pilihan3', 3)
        ->where('spm_pertanyaan_survey.pilihan4', 4)
        ->groupBy('spm_data_hasil_survey.id_pertanyaan_survey')
        ->get();

        // jawaban ya tidak
        $data['hasil_survey_ya_tidak'] = DataHasilSurvey::select(
            "spm_data_hasil_survey.nim",
            "spm_pertanyaan_survey.pertanyaan",
            "spm_pertanyaan_survey.jenis",
            "spm_pertanyaan_survey.id",
            "spm_data_hasil_survey.jawaban",
        )
        ->join("spm_pertanyaan_survey", "spm_pertanyaan_survey.id", "=", "spm_data_hasil_survey.id_pertanyaan_survey")
        ->where('spm_data_hasil_survey.id_nama_survey', $id)
        ->whereIn('spm_pertanyaan_survey.jenis', [1, 2])
        ->where('spm_pertanyaan_survey.pilihan3', null)
        ->where('spm_pertanyaan_survey.pilihan4', null)
        ->groupBy('spm_data_hasil_survey.id_pertanyaan_survey')
        ->get();

        // jawaban hasil esai
        $data['hasil_esai'] = DataHasilSurvey::select(
            "spm_data_hasil_survey.jawaban",
            )
            ->join("spm_pertanyaan_survey", "spm_pertanyaan_survey.id", "=", "spm_data_hasil_survey.id_pertanyaan_survey")
            ->where('spm_data_hasil_survey.id_nama_survey', $id)
            ->where('spm_pertanyaan_survey.jenis', 0)
            ->get();

        $data['qr1'] = DataHasilSurvey::select()
        ->join("spm_pertanyaan_survey", "spm_pertanyaan_survey.id", "=", "spm_data_hasil_survey.id_pertanyaan_survey")
        ->where('spm_data_hasil_survey.id_nama_survey', $id)
        ->where('spm_data_hasil_survey.jawaban', 1)
        ->count('spm_data_hasil_survey.jawaban');

        $data['qr2'] = DataHasilSurvey::select()
        ->join("spm_pertanyaan_survey", "spm_pertanyaan_survey.id", "=", "spm_data_hasil_survey.id_pertanyaan_survey")
        ->where('spm_data_hasil_survey.id_nama_survey', $id)
        ->where('spm_data_hasil_survey.jawaban', 2)
        ->count('spm_data_hasil_survey.jawaban');

        $data['qr3'] = DataHasilSurvey::select()
        ->join("spm_pertanyaan_survey", "spm_pertanyaan_survey.id", "=", "spm_data_hasil_survey.id_pertanyaan_survey")
        ->where('spm_data_hasil_survey.id_nama_survey', $id)
        ->where('spm_data_hasil_survey.jawaban', 3)
        ->count('spm_data_hasil_survey.jawaban');

        $data['qr4'] = DataHasilSurvey::select()
        ->join("spm_pertanyaan_survey", "spm_pertanyaan_survey.id", "=", "spm_data_hasil_survey.id_pertanyaan_survey")
        ->where('spm_data_hasil_survey.id_nama_survey', $id)
        ->where('spm_data_hasil_survey.jawaban', 4)
        ->count('spm_data_hasil_survey.jawaban');

        $data['qr5'] = DataHasilSurvey::select()
        ->join("spm_pertanyaan_survey", "spm_pertanyaan_survey.id", "=", "spm_data_hasil_survey.id_pertanyaan_survey")
        ->where('spm_data_hasil_survey.id_nama_survey', $id)
        ->where('spm_data_hasil_survey.jawaban', 5)
        ->count('spm_data_hasil_survey.jawaban');

        return response()->json([
            'laki_laki' => $data['jml_laki_laki'],
            'perempuan' => $data['jml_perempuan'],
            'angkatan' => $data['angakatan'],
            'prodi' => $data['prodi'],
            'data' => $id,
            'dataJenisSurvey' => $jenis_survey->id,
            'hasil_survey_1_4' => $data['hasil_survey_1_4'],
            'hasil_survey_ya_tidak' => $data['hasil_survey_ya_tidak'],
            'hasil_esai' => $data['hasil_esai'],
            'qr1' => $data['qr1'],
            'qr2' => $data['qr2'],
            'qr3' => $data['qr3'],
            'qr4' => $data['qr4'],
            'qr5' => $data['qr5'],
        ], 200);
    }

    public function ajaxJumlahYaTidak($id){
        $data['jmlah_ya'] =  DataHasilSurvey::where('jawaban', 'Ya')->where('id_pertanyaan_survey',  $id)->count();
        $data['jmlah_tidak'] =  DataHasilSurvey::where('jawaban', 'Tidak')->where('id_pertanyaan_survey',  $id)->count();
        return response()->json([
            'jumlah_ya' => $data['jmlah_ya'],
            'jumlah_tidak' => $data['jmlah_tidak'],
        ], 200);
    }

    public function ajaxJumlahSatuEmpat($id){
        $data['jml_pertanyaan1'] = DataHasilSurvey::where('jawaban', 1)->where('id_pertanyaan_survey', $id)->count();
        $data['jml_pertanyaan2'] = DataHasilSurvey::where('jawaban', 2)->where('id_pertanyaan_survey',   $id)->count();
        $data['jml_pertanyaan3'] = DataHasilSurvey::where('jawaban', 3)->where('id_pertanyaan_survey',   $id)->count();
        $data['jml_pertanyaan4'] = DataHasilSurvey::where('jawaban', 4)->where('id_pertanyaan_survey',   $id)->count();
        $data['jml_pertanyaan5'] = DataHasilSurvey::where('jawaban', 5)->where('id_pertanyaan_survey',   $id)->count();

        return response()->json([
            'jml_pertanyaan1' => $data['jml_pertanyaan1'],
            'jml_pertanyaan2' => $data['jml_pertanyaan2'],
            'jml_pertanyaan3' => $data['jml_pertanyaan3'],
            'jml_pertanyaan4' => $data['jml_pertanyaan4'],
            'jml_pertanyaan5' => $data['jml_pertanyaan5'],
        ], 200);
    }

    public function ajaxGetPersentaseAngkatan(Request $request){

        $idNamaSurvey = $request->input('idNamaSurvey');
        $dataTahun = $request->input('dataTahun');
        
        $data['count_angakatan'] = DataHasilSurvey::select()
        ->join('spm_nama_survey', 'spm_nama_survey.id', '=', 'spm_data_hasil_survey.id_nama_survey')
        ->where('spm_nama_survey.jenis_survey_id', 4)
        ->where('spm_data_hasil_survey.id_nama_survey', $idNamaSurvey)
        ->where('spm_data_hasil_survey.tahun_masuk', $dataTahun)
        ->groupBy('spm_data_hasil_survey.nim')
        ->get()
        ->count();

        return response()->json([
            'jumlah' => $data['count_angakatan'],
        ], 200);
    }
    
    public function ajaxGetPersentaseProdi(Request $request){

        $idNamaSurvey = $request->input('idNamaSurvey');
        $dataProdi = $request->input('dataProdi');
        
        $data['count_prodi'] = DataHasilSurvey::select()
        ->join('spm_nama_survey', 'spm_nama_survey.id', '=', 'spm_data_hasil_survey.id_nama_survey')
        ->where('jenis_survey_id', 4)
        ->where('id_nama_survey', $idNamaSurvey)
        ->where('spm_data_hasil_survey.prodi', $dataProdi)
        ->groupBy('spm_data_hasil_survey.nim')
        ->get()
        ->count();

        return response()->json([
            'jumlah' => $data['count_prodi'],
            'idNamaSurvey' => $idNamaSurvey,
            'dataProdi' => $dataProdi,
        ], 200);
    }
}
