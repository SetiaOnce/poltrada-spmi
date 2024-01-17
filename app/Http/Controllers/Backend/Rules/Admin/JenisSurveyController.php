<?php

namespace App\Http\Controllers\Backend\Rules\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\DataJenisSurvey;
use App\Models\NamaSurvey;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JenisSurveyController extends Controller
{
    protected $base = 'rules.pengelola.manajemen_survey.data_jenis_survey.';
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = NamaSurvey::select(
                "nama_survey.id",
                "nama_survey.nama_survey",
                "nama_survey.tahun_survey",
                "data_jenis_survey.nama_jenis_survey as jenis_survey",
            )
            ->join("data_jenis_survey", "data_jenis_survey.id", "=", "nama_survey.jenis_survey_id")
            ->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" onclick="_editData('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-info btn-circle" data-bs-original-title="Edit Data" title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip">
                        <span class="mdi mdi-pencil-box-multiple"></span></a>';

                        $btn = $btn.' <a onclick="_deleteData('.$row->id.')" href="javascript:void(0)" class="waves-effect waves-light btn btn-sm btn-danger btn-circle" data-bs-original-title="Hapus Data" title="Hapus Data" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-trash-can-outline"></span></a>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $data['data_jenis_survey'] = DataJenisSurvey::orderBy('nama_jenis_survey','ASC')->get();
        
        return view($this->base.'index', $data);
    }

    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $id      = $request->input('id');
        $method      = $request->input('methodform_data');

        $jenis_survey_id      = $request->input('jenis_survey_id');
        $nama_survey      = $request->input('nama_survey');
        $tahun_survey      = $request->input('tahun_survey');

        if($method == 'add'){
            NamaSurvey::create([
                'jenis_survey_id' => $jenis_survey_id,
                'nama_survey' => $nama_survey,
                'tahun_survey' => $tahun_survey,
                'created_at' => Carbon::now()
            ]);

            return response()->json([
                'success' => true,
            ], 200);

        }else if($method == 'update'){
            NamaSurvey::find($id)->update([
                'jenis_survey_id' => $jenis_survey_id,
                'tahun_survey' => $tahun_survey,
                'updated_at' => Carbon::now()
            ]);

            return response()->json([
                'success' => true,
            ], 200);
        }
    }

    public function edit($id)
    {
        $data = NamaSurvey::where('id', $id)->first();
        return response()->json([
            'data' => $data,
        ]);
    }

    public function destroy($id)
    {
        NamaSurvey::find($id)->delete();
        
        return response()->json([
            'success' => true,
        ], 200);
    }
}
