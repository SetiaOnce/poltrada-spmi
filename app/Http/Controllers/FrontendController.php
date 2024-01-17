<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\DataJenisAkreditasi;
use App\Models\DataJenisPeraturan;
use App\Models\DataJenisProduk;
use App\Models\DataJenisSurvey;
use App\Models\EventSurvey;
use App\Models\LinkApp;
use App\Models\LinkSurveyExternal;
use App\Models\ManajemenKegiatan;
use App\Models\ManajemenProduk;
use App\Models\NamaSurvey;
use App\Models\Pengumuman;
use App\Models\ProfileApp;
use App\Models\ProfileSPMI;
use App\Models\StatusAkreditasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Yajra\DataTables\Facades\DataTables;

class FrontendController extends Controller
{
    public function index()
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
        
        $data['data_banner'] = Banner::latest()->where('status', 1)->get();
        $data['data_link_app'] = LinkApp::latest()->get();
        $data['profile_app'] = ProfileApp::where('id', 1)->first();
        $data['data_kegiatan'] = ManajemenKegiatan::latest()->where('status', 1)->limit(5)->get();
        $data['data_event_survey'] = EventSurvey::select(
            "spm_event_survey.id",
            "spm_event_survey.nama_survey_id",
            "spm_event_survey.priode_evaluasi_diri_awal",
            "spm_event_survey.priode_evaluasi_diri_akhir",
            "spm_nama_survey.nama_survey",
        )
        ->join("spm_nama_survey", "spm_nama_survey.id", "=", "spm_event_survey.nama_survey_id")
        ->get();
        
        $data['data_nama_survey'] = NamaSurvey::select(
            'spm_nama_survey.id',
            'spm_nama_survey.nama_survey',
            'spm_nama_survey.tahun_survey',
            'spm_nama_survey.jenis_survey_id',
            'spm_data_jenis_survey.nama_jenis_survey',
        )
        ->join('spm_data_jenis_survey', 'spm_data_jenis_survey.id', '=', 'spm_nama_survey.jenis_survey_id')
        ->orderBy('spm_nama_survey.nama_survey','ASC')
        ->get();
        
        $data['data_link_survey'] = LinkSurveyExternal::latest()->where('status', 1)->get();
        $data['pengumuman'] = Pengumuman::where('id', 1)->where('status', 1)->first();
        $data['dt_statusAkreditasi'] = StatusAkreditasi::select(
            "spm_status_akreditasi.*",
            "akademik_prodi.nama_prodi",
        )
        ->join("akademik_prodi", "akademik_prodi.id", "=", "spm_status_akreditasi.fid_program_studi")
        ->orderBy('spm_status_akreditasi.id', 'DESC')
        ->get();
        return view('frontend.index', $data);
    }

    public function ProfileSpmi()
    {
        $data['data_banner'] = Banner::latest()->where('status', 1)->get();
        $data['data_link_app'] = LinkApp::latest()->get();
        $data['profile_app'] = ProfileApp::where('id', 1)->first();
        $data['profile_spmi'] = ProfileSPMI::find(1)->first();

        return view('frontend.profile.index', $data);
    }

    public function SemuaKegiatan()
    {
        $data['data_banner'] = Banner::latest()->where('status', 1)->get();
        $data['data_link_app'] = LinkApp::latest()->get();
        $data['profile_app'] = ProfileApp::where('id', 1)->first();
        $data['semua_kegiatan'] = ManajemenKegiatan::orderBy('id','ASC')->where('status', 1)->get(['id', 'foto_kegiatan', 'judul_kegiatan']);
        $data['data_kegiatan'] = ManajemenKegiatan::latest()->where('status', 1)->paginate(10);

        return view('frontend.kegiatan.semua_kegiatan', $data);
    }

    public function DetailKegiatan($id)
    {
        $data['data_banner'] = Banner::latest()->where('status', 1)->get();
        $data['data_link_app'] = LinkApp::latest()->get();
        $data['profile_app'] = ProfileApp::where('id', 1)->first();
        $data['detail_kegiatan'] = ManajemenKegiatan::where('id', $id)->first();
        
        ManajemenKegiatan::query()->whereId($data['detail_kegiatan']['id'])->update(['view' => $data['detail_kegiatan']['view']+1]);
        
        $data['semua_kegiatan'] = ManajemenKegiatan::orderBy('id','ASC')->get(['id', 'foto_kegiatan', 'judul_kegiatan']);
        
        return view('frontend.kegiatan.detail_kegiatan', $data);
    }

    public function ProdukSpmi()
    {
        $data['data_banner'] = Banner::latest()->where('status', 1)->get();
        $data['data_link_app'] = LinkApp::latest()->get();
        $data['profile_app'] = ProfileApp::where('id', 1)->first();
        $data['data_jenis_produk'] = DataJenisProduk::latest()->get();
        $data['data_jenis_produk'] = DataJenisProduk::latest()->get();

        return view('frontend.produk.index', $data);
    }

    public function AkreditasiSpmi()
    {
        $data['data_banner'] = Banner::latest()->where('status', 1)->get();
        $data['data_link_app'] = LinkApp::latest()->get();
        $data['profile_app'] = ProfileApp::where('id', 1)->first();
        $data['data_jenis_peraturan'] = DataJenisPeraturan::latest()->get();
        
        $data['data_jenis_akreditasi'] = DataJenisAkreditasi::orderBy('nama_jenis_akreditasi', 'ASC')->get();
        return view('frontend.akreditasi.index', $data);
    }

    public function SurveySpmi()
    {
        $data['data_banner'] = Banner::latest()->where('status', 1)->get();
        $data['data_link_app'] = LinkApp::latest()->get();
        $data['profile_app'] = ProfileApp::where('id', 1)->first();
        $data['data_jenis_survey'] = DataJenisSurvey::latest()->get();

        $data['data_event_survey'] = EventSurvey::select(
            "spm_event_survey.id",
            "spm_event_survey.nama_survey_id",
            "spm_event_survey.priode_evaluasi_diri_awal",
            "spm_event_survey.priode_evaluasi_diri_akhir",
            "spm_nama_survey.nama_survey",
            "spm_nama_survey.logo",
            "spm_data_jenis_survey.nama_jenis_survey",
        )
        ->join("spm_nama_survey", "spm_nama_survey.id", "=", "spm_event_survey.nama_survey_id")
        ->join("spm_data_jenis_survey", "spm_data_jenis_survey.id", "=", "spm_nama_survey.jenis_survey_id")
        ->get();
        
        return view('frontend.survey.index', $data);
    }
    public function DetailSurveySpmi($id)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $data['data_banner'] = Banner::latest()->where('status', 1)->get();
        $data['data_link_app'] = LinkApp::latest()->get();
        $data['profile_app'] = ProfileApp::where('id', 1)->first();
        
        $data['detail_survey'] = NamaSurvey::where('jenis_survey_id', $id)->first();
        $data['data_jenis_survey'] = NamaSurvey::where('jenis_survey_id', $id)->get();
        $data['jenis_survey'] = DataJenisSurvey::where('id', $id)->first();

        $data['data_event_survey'] = EventSurvey::select(
            "spm_event_survey.id",
            "spm_event_survey.nama_survey_id",
            "spm_event_survey.priode_evaluasi_diri_awal",
            "spm_event_survey.priode_evaluasi_diri_akhir",
            "spm_nama_survey.nama_survey",
            "spm_nama_survey.logo",
            "spm_nama_survey.jenis_survey_id",
            "spm_data_jenis_survey.nama_jenis_survey",
        )
        ->join("spm_nama_survey", "spm_nama_survey.id", "=", "spm_event_survey.nama_survey_id")
        ->join("spm_data_jenis_survey", "spm_data_jenis_survey.id", "=", "spm_nama_survey.jenis_survey_id")
        ->where("spm_nama_survey.jenis_survey_id", $id)
        ->get();
        
        // $data['data_pertanyaan_survey'] = PertanyaanSurvey::where('nama_survey_id', $id)->get();
        // dd( $data['data_pertanyaan_survey2']);
        
        return view('frontend.survey.detail_survey', $data);
    }

    public function AjaxGetProduk($id){
        $data = ManajemenProduk::latest()->where('sub_jenis_produk_id', $id)->get();
        return response()->json([
            'data' => $data,
        ], 200);
    }

}
