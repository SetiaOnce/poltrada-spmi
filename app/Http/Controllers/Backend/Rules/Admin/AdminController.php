<?php

namespace App\Http\Controllers\Backend\Rules\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataHasilSurvey;
use App\Models\User;
use App\Models\ManajemenKegiatan;
use App\Models\ManajemenPeraturan;
use App\Models\ManajemenProduk;
use App\Models\ManualBook;
use App\Models\NamaSurvey;
use App\Models\PengajuanAudit;
use App\Models\SsoAkses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    protected $base = 'rules.admin.';
    
    public function index()
    {   
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        if(!session()->get('login_akses')) { 
            return redirect('/auth_login'); 
        } 
        $data['jumlah_pengguna'] = SsoAkses::select('group_pegawai.id', 'group_pegawai.nama')
        ->join('group_pegawai', 'group_pegawai.id', '=', 'sso_akses.pegawai_id')
        ->orderBy('group_pegawai.nama', 'ASC')
        ->where('sso_akses.aplikasi_id', 23)
        ->count();
        $data['jumlah_produk'] = ManajemenProduk::all()->count();
        $data['jumlah_peraturan'] = ManajemenPeraturan::all()->count();
        $data['jumlah_kegiatan'] = ManajemenKegiatan::all()->count();
        $data['data_nama_survey'] = NamaSurvey::select(
            'spm_nama_survey.id',
            'spm_nama_survey.nama_survey',
            'spm_nama_survey.tahun_survey',
            'spm_nama_survey.jenis_survey_id',
            'spm_data_jenis_survey.nama_jenis_survey',
        )
        ->join('spm_data_jenis_survey', 'spm_data_jenis_survey.id', '=', 'spm_nama_survey.jenis_survey_id')
        ->orderBy('nama_survey','ASC')
        ->get();

        for ($i=1; $i<=12; $i++) {
            $arr[] = PengajuanAudit::whereYear('tgl_input', date('Y'))
            ->whereMonth('tgl_input', $i)
            ->whereIn('status_pengajuan', [1, 2])
            ->count();
        }
        $data['statistik'] = json_encode($arr);

        return view($this->base.'index', $data);
    }

    public function ajaxtrendAudit(Request $request){
        $dataTahun = $request->input('dataTahun');
        
        if(!empty($dataTahun)){
            for ($i=1; $i<=12; $i++) {
                $arr[] = PengajuanAudit::whereYear('tgl_input', $dataTahun)
                ->whereMonth('tgl_input', $i)
                ->whereIn('status_pengajuan', [1, 2])
                ->count();
            }
            $data['statistik'] = $arr;
            $tahun = $dataTahun;
        }else{
            for ($i=1; $i<=12; $i++) {
                $arr[] = PengajuanAudit::whereYear('tgl_input', date('Y'))
                ->whereMonth('tgl_input', $i)
                ->whereIn('status_pengajuan', [1, 2])
                ->count();
            }
            $data['statistik'] = $arr;
            $tahun = date('Y');
        }

        return response()->json([
            'statistik' => $data['statistik'],
            'tahun' => $tahun,
        ], 200);
    }

    public function ajaxtrendDetailAudit(Request $request){
        $r = $request->input('dataBulan');
        $t = $request->input('dataTahun');
        
        $dataBulan = $r + 1;

        if($dataBulan == 1){$namaBulan = 'JANUARI';}else if($dataBulan == 2){$namaBulan = 'FEBRUARI';}else if($dataBulan == 3){$namaBulan = 'MARET';}else if($dataBulan == 4){$namaBulan = 'APRIL';}else if($dataBulan == 5){$namaBulan = 'MEI';}else if($dataBulan == 6){$namaBulan = 'JUNI';}else if($dataBulan == 7){$namaBulan = 'JULI';}else if($dataBulan == 8){$namaBulan = 'AGUSTUS';}else if($dataBulan == 9){$namaBulan = 'SEPTEMBER';}else if($dataBulan == 10){$namaBulan = 'OKTOBER';}else if($dataBulan == 11){$namaBulan = 'NOVEMBER';}else if($dataBulan == 12){$namaBulan = 'DESEMBER';}

        if(!empty($t)){
            $dataTahun = $t;
        }else{
            $dataTahun = date('Y');
        }
 
        if(!empty($t)){
            $data['detail_audit'] = PengajuanAudit::select(
                "spm_pengajuan_audit.id",
                "spm_pengajuan_audit.status_pengajuan",
                "spm_jenis_standar_mutu.jenis_standar_mutu as jenis_standar",
                "group_unit_kerja.unit_kerja",
                "spm_daftar_standar_mutu.tahun",
                "spm_data_lembaga_akreditasi.nama_lembaga",
            )
            ->join("spm_jenis_standar_mutu", "spm_jenis_standar_mutu.id", "=", "spm_pengajuan_audit.jenis_standar_mutu_id")
            ->join("spm_daftar_standar_mutu", "spm_daftar_standar_mutu.id", "=", "spm_jenis_standar_mutu.daftar_standar_mutu_id")
            ->join("spm_data_lembaga_akreditasi", "spm_data_lembaga_akreditasi.id", "=", "spm_daftar_standar_mutu.lembaga_akreditasi_id")
            ->join("spm_periode_evaluasi", "spm_periode_evaluasi.id", "=", "spm_pengajuan_audit.priode_evaluasi_id")
            ->join("group_pegawai", "group_pegawai.id", "=", "spm_pengajuan_audit.user_id")
            ->join("group_unit_kerja", "group_unit_kerja.id", "=", "group_pegawai.unit_kerja_id")
            ->whereIn('spm_pengajuan_audit.status_pengajuan', [1, 2])
            ->whereMonth('tgl_input', $dataBulan)
            ->whereYear('tgl_input', $t)
            ->orderBy('spm_pengajuan_audit.id', 'DESC')
            ->get();
        }else{
            $data['detail_audit'] = PengajuanAudit::select(
                "spm_pengajuan_audit.id",
                "spm_pengajuan_audit.status_pengajuan",
                "spm_jenis_standar_mutu.jenis_standar_mutu as jenis_standar",
                "group_unit_kerja.unit_kerja",
                "spm_daftar_standar_mutu.tahun",
                "spm_data_lembaga_akreditasi.nama_lembaga",
            )
            ->join("spm_jenis_standar_mutu", "spm_jenis_standar_mutu.id", "=", "spm_pengajuan_audit.jenis_standar_mutu_id")
            ->join("spm_daftar_standar_mutu", "spm_daftar_standar_mutu.id", "=", "spm_jenis_standar_mutu.daftar_standar_mutu_id")
            ->join("spm_data_lembaga_akreditasi", "spm_data_lembaga_akreditasi.id", "=", "spm_daftar_standar_mutu.lembaga_akreditasi_id")
            ->join("spm_periode_evaluasi", "spm_periode_evaluasi.id", "=", "spm_pengajuan_audit.priode_evaluasi_id")
            ->join("group_pegawai", "group_pegawai.id", "=", "spm_pengajuan_audit.user_id")
            ->join("group_unit_kerja", "group_unit_kerja.id", "=", "group_pegawai.unit_kerja_id")
            ->whereIn('spm_pengajuan_audit.status_pengajuan', [1, 2])
            ->whereMonth('tgl_input', $dataBulan)
            ->orderBy('spm_pengajuan_audit.id', 'DESC')
            ->get();
        }
        
        return response()->json([
            'data' => $data['detail_audit'],
            'namaBulan' => $namaBulan,
            'dataTahun' => $dataTahun,
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

        return response()->json([
            'jml_pertanyaan1' => $data['jml_pertanyaan1'],
            'jml_pertanyaan2' => $data['jml_pertanyaan2'],
            'jml_pertanyaan3' => $data['jml_pertanyaan3'],
            'jml_pertanyaan4' => $data['jml_pertanyaan4'],
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

    public function ExportPDF(Request $request){
        $nama_survey = NamaSurvey::where('id', $request->nama_survey_id)->first();
        $jenis_survey = NamaSurvey::select(
            "spm_data_jenis_survey.id",
        )
        ->join("spm_data_jenis_survey", "spm_data_jenis_survey.id", "=", "spm_nama_survey.jenis_survey_id")
        ->where('spm_nama_survey.id', $request->nama_survey_id)
        ->first();

        if($jenis_survey->id == 4){
            $data['jml_laki_laki'] = DB::table('spm_data_hasil_survey')
            ->where('jenis_kelamin', 'LAKI-LAKI')
            ->where('id_nama_survey', $request->nama_survey_id)
            ->groupBy('email')
            ->get()
            ->count();
    
            $data['jml_perempuan'] = DB::table('data_hasil_survey')
            ->where('jenis_kelamin', 'WANITA')
            ->where('id_nama_survey', $request->nama_survey_id)
            ->groupBy('email')
            ->get()
            ->count();
        }else{
            $data['jml_laki_laki'] = DB::table('spm_data_hasil_survey')
            ->where('jenis_kelamin', 'LAKI-LAKI')
            ->where('id_nama_survey', $request->nama_survey_id)
            ->groupBy('email')
            ->get()
            ->count();
    
            $data['jml_perempuan'] = DB::table('spm_data_hasil_survey')
            ->where('jenis_kelamin', 'PEREMPUAN')
            ->where('id_nama_survey', $request->nama_survey_id)
            ->groupBy('email')
            ->get()
            ->count();
        }

        $jml_responden =  DB::table('spm_data_hasil_survey')
        ->where('id_nama_survey',  $request->nama_survey_id)
        ->groupBy('email')
        ->get()
        ->count();
        $hasil_survey_1_4 = DataHasilSurvey::select(
            "spm_data_hasil_survey.nim",
            "spm_pertanyaan_survey.pertanyaan",
            "spm_pertanyaan_survey.jenis",
            "spm_pertanyaan_survey.id",
            "spm_data_hasil_survey.jawaban",
        )
        ->join("spm_pertanyaan_survey", "spm_pertanyaan_survey.id", "=", "spm_data_hasil_survey.id_pertanyaan_survey")
        ->where('spm_data_hasil_survey.id_nama_survey', $request->nama_survey_id)
        ->where('spm_pertanyaan_survey.jenis', 1)
        ->where('spm_pertanyaan_survey.pilihan3', 3)
        ->where('spm_pertanyaan_survey.pilihan4', 4)
        ->groupBy('spm_data_hasil_survey.id_pertanyaan_survey')
        ->get();

        $hasil_survey_ya_tidak = DataHasilSurvey::select(
            "spm_data_hasil_survey.nim",
            "spm_pertanyaan_survey.pertanyaan",
            "spm_pertanyaan_survey.jenis",
            "spm_pertanyaan_survey.id",
            "spm_data_hasil_survey.jawaban",
        )
        ->join("spm_pertanyaan_survey", "spm_pertanyaan_survey.id", "=", "spm_data_hasil_survey.id_pertanyaan_survey")
        ->where('spm_data_hasil_survey.id_nama_survey', $request->nama_survey_id)
        ->where('spm_pertanyaan_survey.jenis', 1)
        ->where('spm_pertanyaan_survey.pilihan3', null)
        ->where('spm_pertanyaan_survey.pilihan4', null)
        ->groupBy('spm_data_hasil_survey.id_pertanyaan_survey')
        ->get();

        $hasil_esai = DataHasilSurvey::select(
            "spm_data_hasil_survey.jawaban",
            )
            ->join("spm_pertanyaan_survey", "spm_pertanyaan_survey.id", "=", "spm_data_hasil_survey.id_pertanyaan_survey")
            ->where('spm_data_hasil_survey.id_nama_survey', $request->nama_survey_id)
            ->where('spm_pertanyaan_survey.jenis', 0)
            ->get();
        
        $data = [
            'nama_survey' => $nama_survey,
            'jml_responden' => $jml_responden,
            'jml_laki_laki' => $data['jml_laki_laki'],
            'jml_perempuan' => $data['jml_perempuan'],
            'hasil_survey_1_4' => $hasil_survey_1_4,
            'hasil_survey_ya_tidak' => $hasil_survey_ya_tidak,
            'hasil_survey_ya_tidak' => $hasil_survey_ya_tidak,
            'hasil_esai' => $hasil_esai,
        ]; 
        
        // $template = 'pdf.persentase';
        $pdf = Pdf::loadView('pdf.persentase', $data)->setPaper('A4', 'portrait');
        return $pdf->download('Laporan Persentase Survey '.hexdec(uniqid()).'.pdf');
    }

    public function Profile()
    {
        $data['data_profile'] = User::where('id', Auth::user()->id)->first();
        return view($this->base.'profile', $data);
    }

    public function DownloadManualBook()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        
        $level = Auth::user()->role;
        $manual_book = ManualBook::where('level_id', $level)->first();
        // dd($manual_book);
        if(!empty($manual_book->level_id)){
            return response()->download(public_path($manual_book->file_manual));
        }else{
            $notif = array(
                'message' => true
            );
            return redirect()->back()->with($notif);
        }
    }
}
