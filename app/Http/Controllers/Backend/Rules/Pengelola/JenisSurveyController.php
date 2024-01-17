<?php

namespace App\Http\Controllers\Backend\Rules\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\DataJenisSurvey;
use App\Models\NamaSurvey;
use App\Models\PertanyaanSurvey;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;

class JenisSurveyController extends Controller
{
    protected $base = 'rules.pengelola.manajemen_survey.data_jenis_survey.';
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $filter_tahun = $request->get('filter_tahun');
            if(!empty($filter_tahun)){
                $data = NamaSurvey::select(
                    "spm_nama_survey.id",
                    "spm_nama_survey.nama_survey",
                    "spm_nama_survey.tahun_survey",
                    "spm_nama_survey.logo",
                    "spm_data_jenis_survey.nama_jenis_survey as jenis_survey",
                )
                ->join("spm_data_jenis_survey", "spm_data_jenis_survey.id", "=", "spm_nama_survey.jenis_survey_id")
                ->where("spm_nama_survey.tahun_survey", $filter_tahun)
                ->orderBy('spm_nama_survey.created_at', 'DESC')
                ->get();
            }else{
                $data = NamaSurvey::select(
                    "spm_nama_survey.id",
                    "spm_nama_survey.nama_survey",
                    "spm_nama_survey.tahun_survey",
                    "spm_nama_survey.logo",
                    "spm_data_jenis_survey.nama_jenis_survey as jenis_survey",
                )
                ->join("spm_data_jenis_survey", "spm_data_jenis_survey.id", "=", "spm_nama_survey.jenis_survey_id")
                ->orderBy('spm_nama_survey.created_at', 'DESC')
                ->get();
            }
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('logo', function($row) {
                        return '<img class="img-thumbnail" alt="200x200" width="72" src="'.asset(($row->logo)).'" data-holder-rendered="true">';
                    })  
                    ->addColumn('action', function($row){
                        $btn = '<a href="'.url('/pengelola/manajemen-survey/kelola_pertanyaan_survey/'.$row->id).'" class="waves-effect waves-light btn btn-success btn-circle me-1" data-bs-original-title="Kelola Pertanyaan Survey" title="Kelola Pertanyaan Survey" data-bs-placement="top" data-bs-toggle="tooltip">
                        <span class="mdi mdi-plus"></span></a>';
                        $btn = $btn.'<a href="javascript:void(0)" onclick="_editData('.$row->id.')" class="waves-effect waves-light btn btn-info btn-circle me-1" data-bs-original-title="Edit Data" title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip">
                        <span class="mdi mdi-pencil-box-multiple"></span></a>';
                        $btn = $btn.' <a onclick="_deleteData('.$row->id.')" href="javascript:void(0)" class="waves-effect waves-light btn btn-danger btn-circle me-1" data-bs-original-title="Hapus Data" title="Hapus Data" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-trash-can-outline"></span></a>';
                        $btn = $btn.' <a onclick="_duplikasiData('.$row->id.')" href="javascript:void(0)" class="waves-effect waves-light btn btn-dark btn-circle me-1" data-bs-original-title="Duplikasi Data" title="Duplikasi Data" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-content-copy"></span></a>';

                        return $btn;
                    })
                    ->rawColumns(['action', 'logo'])
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
        $logo      = $request->file('logo');

        if($method == 'add'){
            $validasi = validator()->make($request->all(),[
                'logo' => 'required|mimes:jpg,jpeg,png|max:2048',
            ],[
                'logo.required' => 'Logo tidak boleh kosong',
                'logo.mimes' => 'File berekstensi jpg,jpeg,png',
                'logo.max' => 'Max file 2mb',
            ]);

            if($validasi->fails()){
                return response()->json(['errors' => $validasi->errors()]);
            }else{
                $name_gen = hexdec(uniqid()).'-logo.'.$logo->getClientOriginalExtension();
                Image::make($logo)->resize(226,221)->save('img/link-survey/'.$name_gen);
                $save_url = 'img/link-survey/'.$name_gen;
                
                NamaSurvey::create([
                    'jenis_survey_id' => $jenis_survey_id,
                    'nama_survey' => $nama_survey,
                    'tahun_survey' => $tahun_survey,
                    'logo' => $save_url,
                    'created_at' => Carbon::now()
                ]);
    
                return response()->json([
                    'success' => true,
                ], 200);
            }

        }else if($method == 'update'){
            if($request->file('logo')){
                $validasi = validator()->make($request->all(),[
                    'logo' => 'mimes:jpg,jpeg,png|max:2048',
                ],[
                    'logo.mimes' => 'File berekstensi jpg,jpeg,png',
                    'logo.max' => 'Max file 2mb',
                ]);
    
                if($validasi->fails()){
                    return response()->json(['errors' => $validasi->errors()]);
                }else{
                    $name_gen = hexdec(uniqid()).'-logo.'.$logo->getClientOriginalExtension();
                    Image::make($logo)->resize(226,221)->save('img/link-survey/'.$name_gen);
                    $save_url = 'img/link-survey/'.$name_gen;
                    
                    NamaSurvey::find($id)->update([
                        'logo' => $save_url,
                    ]);
                }
            }
            
            NamaSurvey::find($id)->update([
                'jenis_survey_id' => $jenis_survey_id,
                'nama_survey' => $nama_survey,
                'tahun_survey' => $tahun_survey,
                'updated_at' => Carbon::now()
            ]);

            return response()->json([
                'success' => true,
            ], 200);
        }
    }
    public function DuplikasiSurvey($id){
        date_default_timezone_set("Asia/Jakarta");
        
        $nama_survey = NamaSurvey::where('id', $id)->first();
        $pertanyaan_survey = PertanyaanSurvey::where('nama_survey_id', $id)->get();
        
        $id_nama_survey = NamaSurvey::insertGetId([
            'jenis_survey_id' => $nama_survey->jenis_survey_id,
            'nama_survey' => $nama_survey->nama_survey.'-COPY',
            'tahun_survey' => $nama_survey->tahun_survey,
            'logo' => $nama_survey->logo,
            'created_at' => Carbon::now()
        ]);

        foreach($pertanyaan_survey as $pertanyaan){
            PertanyaanSurvey::create([
                'nama_survey_id' => $id_nama_survey,
                'pertanyaan' => $pertanyaan->pertanyaan,
                'jenis' => $pertanyaan->jenis,
                'pilihan1' => $pertanyaan->pilihan1,
                'pilihan2' => $pertanyaan->pilihan2,
                'pilihan3' => $pertanyaan->pilihan3,
                'pilihan4' => $pertanyaan->pilihan4,
                'keterangan' => $pertanyaan->keterangan,
                'created_at' => Carbon::now()
            ]);
        }
        
        return response()->json([
            'success' => true,
            'data' => $pertanyaan_survey
        ], 200);
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

    public function KelolaPertanyaanSurvey(Request $request, $idp_nama_survey)
    {
        if ($request->ajax()) {
            $data = PertanyaanSurvey::select(
                "spm_pertanyaan_survey.id",
                "spm_pertanyaan_survey.pertanyaan",
                "spm_pertanyaan_survey.jenis",
                "spm_nama_survey.nama_survey",
                "spm_nama_survey.tahun_survey",
                "spm_data_jenis_survey.nama_jenis_survey",
            )
            ->join("spm_nama_survey", "spm_nama_survey.id", "=", "spm_pertanyaan_survey.nama_survey_id")
            ->join('spm_data_jenis_survey', 'spm_data_jenis_survey.id', '=', 'spm_nama_survey.jenis_survey_id')
            ->where('spm_nama_survey.id', $idp_nama_survey)
            ->orderBy('spm_nama_survey.nama_survey', 'ASC')
            ->get();
            return DataTables::of($data)
                    ->addIndexColumn()       
                    ->editColumn('namaSurvey', function($row) {
                        return $row->nama_jenis_survey.' | '.$row->tahun_survey.' | '.$row->nama_survey;
                    }) 
                    ->editColumn('role_jenis', function($row) {
                        if($row->jenis == 0){
                            return '<span class="badge bg-info">ESAI</span>';
                        }else{
                            return '<span class="badge bg-success">PILIHAN</span>';
                        }
                    }) 
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" onclick="_editData('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-info btn-circle" data-bs-original-title="Edit Data" title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip">
                           <span class="mdi mdi-pencil-box-multiple"></span></a>';

                           $btn = $btn.' <a onclick="_deleteData('.$row->id.')" href="javascript:void(0)" class="waves-effect waves-light btn btn-sm btn-danger btn-circle" data-bs-original-title="Hapus Data" title="Hapus Data" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-trash-can-outline"></span></a>';
                           
                            return $btn;
                    })
                    ->rawColumns(['action', 'role_jenis', 'namaSurvey'])
                    ->make(true);
        }
        $data['namaSurvey'] = NamaSurvey::select(
            'spm_nama_survey.id',
            'spm_nama_survey.nama_survey',
            'spm_nama_survey.tahun_survey',
            'spm_data_jenis_survey.nama_jenis_survey',
        )
        ->join('spm_data_jenis_survey', 'spm_data_jenis_survey.id', '=', 'spm_nama_survey.jenis_survey_id')
        ->where('spm_nama_survey.id',$idp_nama_survey)
        ->first();
        // $data['namaSurvey'] = NamaSurvey::whereId($idp_nama_survey)->first(); 
        return view('rules.pengelola.manajemen_survey.pertanyaan_survey.index',$data);
    }
}
