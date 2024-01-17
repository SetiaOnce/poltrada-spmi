<?php

namespace App\Http\Controllers\Backend\Rules\Pengelola;

use App\Exports\ExportHasilSurvey;
use App\Http\Controllers\Controller;
use App\Models\DataHasilSurvey;
use App\Models\NamaSurvey;
use App\Models\PertanyaanSurvey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Console\Input\Input;
use Yajra\DataTables\Facades\DataTables;

class HasilSurveyController extends Controller
{
    protected $base = 'rules.pengelola.manajemen_survey.hasil_survey.';
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = NamaSurvey::select(
                "spm_nama_survey.id",
                "spm_nama_survey.nama_survey",
                "spm_nama_survey.tahun_survey",
                "spm_data_jenis_survey.nama_jenis_survey as jenis_survey",
            )
            ->join("spm_data_jenis_survey", "spm_data_jenis_survey.id", "=", "spm_nama_survey.jenis_survey_id")
            ->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('jumlah_sruvey', function($row){
                        $jml_responden =  DB::table('spm_data_hasil_survey')
                        ->where('id_nama_survey', $row->id)
                        ->groupBy('email')
                        ->get()
                        ->count();
                        return $jml_responden;
                    })
                    ->addColumn('action', function($row){
                        $btn = '<a href="'.route('detail.hasil.survey', $row->id).'" class="waves-effect waves-light btn btn-sm btn-success btn-circle me-1" data-bs-original-title="Lihat Data" title="Lihat Data" data-bs-placement="top" data-bs-toggle="tooltip">
                        <span class="mdi mdi-eye"></span></a>';

                        return $btn;
                    })
                    ->rawColumns(['action', 'jumlah_sruvey'])
                    ->make(true);
        }
        
        return view($this->base.'index');
    }

    public function DetailHasilSurvey(Request $request, $id)
    {
        $data['nama_survey'] = NamaSurvey::whereId($id)->first();     
        if($data['nama_survey']['jenis_survey_id'] == 4){
            if ($request->ajax()) {
                $data = DB::table('spm_data_hasil_survey')
                ->where('id_nama_survey', $id)
                ->groupBy('nim')
                ->get();
                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('unit_prodi', function($row){
                            $unit_prodi =  $row->jenjang.' | '.$row->prodi;
                            return $unit_prodi;
                        })
                        ->addColumn('action', function($row){
                            $btn = '<a href="javascript:void(0);" onclick="_viewData('.$row->nim.')" class="waves-effect waves-light btn btn-sm btn-success btn-circle me-1" data-bs-original-title="Lihat Jawaban" title="Lihat Jawaban" data-bs-placement="top" data-bs-toggle="tooltip">
                            <span class="mdi mdi-eye"></span></a>';
    
                            return $btn;
                        })
                        ->rawColumns(['action', 'unit_prodi'])
                        ->make(true);
            }
        }else{
            if ($request->ajax()) {
                $data = DB::table('spm_data_hasil_survey')
                ->where('id_nama_survey', $id)
                ->groupBy('email')
                ->get();
                return DataTables::of($data)
                        ->addIndexColumn()
                        ->addColumn('unit_prodi', function($row){
                            $unit_prodi =  '-';
                            return $unit_prodi;
                        })
                        ->addColumn('action', function($row){
                            $btn = '<a href="javascript:void(0);" data-email="'.$row->email.'" onclick="_viewPegawai(this)" class="waves-effect waves-light btn btn-sm btn-success btn-circle me-1" title="Lihat Jawaban"><span class="mdi mdi-eye"></span></a>';
    
                            return $btn;
                        })
                        ->rawColumns(['action', 'unit_prodi'])
                        ->make(true);
            } 
        }
        $data['dt_pertanyaanSurvey1_4']= PertanyaanSurvey::whereJenis(1)->whereNamaSurveyId($id)->get();
        $data['dt_pertanyaanSurveyYaTidak']= PertanyaanSurvey::whereJenis(2)->whereNamaSurveyId($id)->get();
        $data['dt_jawaban_esai']= DataHasilSurvey::whereNotIn('jawaban', [1, 2, 3, 4, 5, 'Ya','Tidak'])->whereIdNamaSurvey($id)->get();
        return view($this->base.'detail_hasil_survey', $data);
    }

    public function SubHasilSurvey(Request $request){        
        $email = $request->input('email');
        $data_nim = $request->input('data_nim');
        $id_nama_survey = $request->input('id_nama_survey');

        if($data_nim == null){
            $data = DataHasilSurvey::select(
                "spm_data_hasil_survey.jawaban", 
                "spm_data_hasil_survey.nim",
                "spm_data_hasil_survey.id_nama_survey",
                "spm_pertanyaan_survey.pertanyaan",
            )
            ->join("spm_pertanyaan_survey", "spm_pertanyaan_survey.id", "=", "spm_data_hasil_survey.id_pertanyaan_survey")
            ->where('spm_data_hasil_survey.email', $email)
            ->where('spm_data_hasil_survey.id_nama_survey', $id_nama_survey)
            ->get();
    
            $detail_pegawai = DataHasilSurvey::where('email', $email)->where('id_nama_survey', $id_nama_survey)->first();
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'detail' => $detail_pegawai
            ], 200);
        }else{
            $data = DataHasilSurvey::select(
                "spm_data_hasil_survey.jawaban",
                "spm_data_hasil_survey.nim",
                "spm_data_hasil_survey.id_nama_survey",
                "spm_pertanyaan_survey.pertanyaan",
            )
            ->join("spm_pertanyaan_survey", "spm_pertanyaan_survey.id", "=", "spm_data_hasil_survey.id_pertanyaan_survey")
            ->where('spm_data_hasil_survey.nim', $data_nim)
            ->where('spm_data_hasil_survey.id_nama_survey', $id_nama_survey)
            ->get();
    
            $detail_taruna = DataHasilSurvey::where('nim', $data_nim)->where('id_nama_survey', $id_nama_survey)->first();
            
            return response()->json([
                'success' => true,
                'data' => $data,
                'detail' => $detail_taruna
            ], 200);
        }
        
    }

    public function HasilSurveyExportExcel(Request $request)
    {
        return Excel::download(new ExportHasilSurvey($request), 'data_hasil_survey.xlsx');
    }
    
}
