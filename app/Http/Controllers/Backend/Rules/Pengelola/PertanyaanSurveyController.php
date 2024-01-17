<?php

namespace App\Http\Controllers\Backend\Rules\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\NamaSurvey;
use App\Models\PertanyaanSurvey;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PertanyaanSurveyController extends Controller
{
    protected $base = 'rules.pengelola.manajemen_survey.pertanyaan_survey.';
    
    // public function index(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $data = PertanyaanSurvey::select(
    //             "spm_pertanyaan_survey.id",
    //             "spm_pertanyaan_survey.pertanyaan",
    //             "spm_pertanyaan_survey.jenis",
    //             "spm_nama_survey.nama_survey",
    //             "spm_nama_survey.tahun_survey",
    //             "spm_data_jenis_survey.nama_jenis_survey",
    //         )
    //         ->join("spm_nama_survey", "spm_nama_survey.id", "=", "spm_pertanyaan_survey.nama_survey_id")
    //         ->join('spm_data_jenis_survey', 'spm_data_jenis_survey.id', '=', 'spm_nama_survey.jenis_survey_id')
    //         ->orderBy('spm_nama_survey.nama_survey', 'ASC')
    //         ->get();
    //         return DataTables::of($data)
    //                 ->addIndexColumn()       
    //                 ->editColumn('namaSurvey', function($row) {
    //                     return $row->nama_jenis_survey.' | '.$row->tahun_survey.' | '.$row->nama_survey;
    //                 }) 
    //                 ->editColumn('role_jenis', function($row) {
    //                     if($row->jenis == 0){
    //                         return '<span class="badge bg-info">ESAI</span>';
    //                     }else{
    //                         return '<span class="badge bg-success">PILIHAN</span>';
    //                     }
    //                 }) 
    //                 ->addColumn('action', function($row){
    //                        $btn = '<a href="javascript:void(0)" onclick="_editData('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-info btn-circle" data-bs-original-title="Edit Data" title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip">
    //                        <span class="mdi mdi-pencil-box-multiple"></span></a>';

    //                        $btn = $btn.' <a onclick="_deleteData('.$row->id.')" href="javascript:void(0)" class="waves-effect waves-light btn btn-sm btn-danger btn-circle" data-bs-original-title="Hapus Data" title="Hapus Data" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-trash-can-outline"></span></a>';
                           
    //                         return $btn;
    //                 })
    //                 ->rawColumns(['action', 'role_jenis', 'namaSurvey'])
    //                 ->make(true);
    //     }
        
    //     $data['data_nama_survey'] = NamaSurvey::select(
    //         'spm_nama_survey.id',
    //         'spm_nama_survey.nama_survey',
    //         'spm_nama_survey.tahun_survey',
    //         'spm_data_jenis_survey.nama_jenis_survey',
    //     )
    //     ->join('spm_data_jenis_survey', 'spm_data_jenis_survey.id', '=', 'spm_nama_survey.jenis_survey_id')
    //     ->orderBy('nama_survey','ASC')
    //     ->get();
        
    //     return view($this->base.'index', $data);
    // }

    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $id      = $request->input('id');
        $method      = $request->input('methodform_data');

        $nama_survey_id      = $request->input('nama_survey_id');
        $pertanyaan      = $request->input('pertanyaan');
        $jenis      = $request->input('jenis');
        $pilihan1      = $request->input('pilihan1');
        $pilihan2      = $request->input('pilihan2');
        $pilihan3      = $request->input('pilihan3');
        $pilihan4      = $request->input('pilihan4');
        $pilihan5      = $request->input('pilihan5');
        $keterangan      = $request->input('keterangan');
        
        if($method == 'add'){
            PertanyaanSurvey::create([
                'nama_survey_id' => $nama_survey_id,
                'pertanyaan' => $pertanyaan,
                'jenis' => $jenis,
                'pilihan1' => $pilihan1,
                'pilihan2' => $pilihan2,
                'pilihan3' => $pilihan3,
                'pilihan4' => $pilihan4,
                'pilihan5' => $pilihan5,
                'keterangan' => $keterangan,
                'created_at' => Carbon::now()
            ]);
        
            return response()->json([
                'success' => true,
            ], 200);

        }else if($method == 'update'){
            PertanyaanSurvey::find($id)->update([
                'nama_survey_id' => $nama_survey_id,
                'pertanyaan' => $pertanyaan,
                'jenis' => $jenis,
                'pilihan1' => $pilihan1,
                'pilihan2' => $pilihan2,
                'pilihan3' => $pilihan3,
                'pilihan4' => $pilihan4,
                'pilihan5' => $pilihan5,
                'keterangan' => $keterangan,
                'updated_at' => Carbon::now()
            ]);
        
            return response()->json([
                'success' => true,
            ], 200);
        }

    }

    public function edit($id)
    {
        $data = PertanyaanSurvey::find($id);
        return response()->json([
            'data' => $data,
        ]);
    }

    public function destroy($id)
    {
        PertanyaanSurvey::find($id)->delete();
        
        return response()->json([
            'success' => true,
        ], 200);
    }
}
