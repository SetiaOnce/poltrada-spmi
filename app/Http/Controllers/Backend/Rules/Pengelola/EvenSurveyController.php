<?php

namespace App\Http\Controllers\Backend\Rules\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\EventSurvey;
use App\Models\NamaSurvey;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class EvenSurveyController extends Controller
{
    protected $base = 'rules.pengelola.manajemen_survey.even_survey.';
    
    public function index(Request $request)
    {   
        date_default_timezone_set("Asia/Jakarta");
        setlocale(LC_ALL, 'IND');

        if ($request->ajax()) {
            $data = EventSurvey::select(
                "spm_event_survey.id",
                'spm_event_survey.priode_evaluasi_diri_awal',
                'spm_event_survey.priode_evaluasi_diri_akhir',
                "spm_nama_survey.nama_survey",
                "spm_nama_survey.tahun_survey",
                "spm_data_jenis_survey.nama_jenis_survey",
            )
            ->join("spm_nama_survey", "spm_nama_survey.id", "=", "spm_event_survey.nama_survey_id")
            ->join('spm_data_jenis_survey', 'spm_data_jenis_survey.id', '=', 'spm_nama_survey.jenis_survey_id')
            ->orderBy('spm_event_survey.created_at', 'DESC')
            ->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('namaSurvey', function($row) {
                        return $row->nama_jenis_survey.' | '.$row->tahun_survey.' | '.$row->nama_survey;
                    }) 
                    ->addColumn('periode_awal', function($row){
                        return ''.\Carbon\Carbon::parse($row->priode_evaluasi_diri_awal)->formatLocalized('%d %B %Y').'';
                    })
                    ->addColumn('periode_akhir', function($row){
                        return ''.\Carbon\Carbon::parse($row->priode_evaluasi_diri_akhir)->formatLocalized('%d %B %Y').'';
                    })
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" onclick="_editData('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-info btn-circle" data-bs-original-title="Edit Data" title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip">
                        <span class="mdi mdi-pencil-box-multiple"></span></a>';

                        $btn = $btn.' <a onclick="_deleteData('.$row->id.')" href="javascript:void(0)" class="waves-effect waves-light btn btn-sm btn-danger btn-circle" data-bs-original-title="Hapus Data" title="Hapus Data" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-trash-can-outline"></span></a>';

                        return $btn;
                    })
                    ->rawColumns(['action', 'namaSurvey', 'periode_awal', 'periode_akhir'])
                    ->make(true);
        }

        $data['data_nama_survey'] = NamaSurvey::select(
            'spm_nama_survey.id',
            'spm_nama_survey.nama_survey',
            'spm_nama_survey.tahun_survey',
            'spm_data_jenis_survey.nama_jenis_survey',
        )
        ->join('spm_data_jenis_survey', 'spm_data_jenis_survey.id', '=', 'spm_nama_survey.jenis_survey_id')
        ->orderBy('nama_survey','ASC')
        ->get();
        return view($this->base.'index', $data);
    }

    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $id      = $request->input('id');
        $method      = $request->input('methodform_data');

        $nama_survey_id      = $request->input('nama_survey_id');
        $periode_evaluasi_diri_awal      = $request->input('priode_evaluasi_diri_awal');
        $periode_evaluasi_diri_akhir      = $request->input('priode_evaluasi_diri_akhir');
        
        if($method == 'add'){
            EventSurvey::create([
                'nama_survey_id' => $nama_survey_id,
                'priode_evaluasi_diri_awal' => $periode_evaluasi_diri_awal,
                'priode_evaluasi_diri_akhir' => $periode_evaluasi_diri_akhir,
                'created_at' => Carbon::now()
            ]);
        
            return response()->json([
                'success' => true,
            ], 200);

        }else if($method == 'update'){
            EventSurvey::find($id)->update([
                'nama_survey_id' => $nama_survey_id,
                'priode_evaluasi_diri_awal' => $periode_evaluasi_diri_awal,
                'priode_evaluasi_diri_akhir' => $periode_evaluasi_diri_akhir,
                'updated_at' => Carbon::now()
            ]);
        
            return response()->json([
                'success' => true,
            ], 200);
        }
    }
    public function edit($id)
    {
        $data = EventSurvey::find($id);
        return response()->json([
            'data' => $data,
        ]);
    }

    public function destroy($id)
    {
        EventSurvey::find($id)->delete();
        
        return response()->json([
            'success' => true,
        ], 200);
    }
}
