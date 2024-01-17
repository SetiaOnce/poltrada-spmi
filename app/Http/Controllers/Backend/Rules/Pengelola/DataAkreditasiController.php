<?php

namespace App\Http\Controllers\Backend\Rules\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\DataAkreditasi;
use App\Models\DataJenisAkreditasi;
use App\Models\FileAkreditasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DataAkreditasiController extends Controller
{
    protected $base = 'rules.pengelola.data_akreditasi.';
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DataAkreditasi::select(
                "spm_data_akreditasi.id",
                "spm_data_akreditasi.tahun",
                "spm_data_akreditasi.dasar_kegiatan",
                "spm_data_akreditasi.timeline_akreditasi",
                "spm_data_jenis_akreditasi.nama_jenis_akreditasi",
            )
            ->join("spm_data_jenis_akreditasi", "spm_data_jenis_akreditasi.id", "=", "spm_data_akreditasi.fid_jenis_akreditasi")
            ->orderBy('spm_data_akreditasi.id', 'DESC')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()       
                ->addColumn('file_timeline', function($row){
                    $btn = '<a href="'.asset('pdf/data-akreditasi/'.$row->timeline_akreditasi).'" target="_blank" class="waves-effect waves-light btn btn-sm btn-info btn-circle" data-bs-original-title="File Timeline Akreditasi" title="File Timeline Akreditasi" data-bs-placement="top" data-bs-toggle="tooltip">Lihat File</a>';
                    return $btn;
                })
                ->addColumn('action', function($row){
                    $btn = '<a href="javascript:void(0)" onclick="_editData('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-dark btn-circle me-1" data-bs-original-title="Edit Data" title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip">
                    <span class="mdi mdi-pencil-box-multiple"></span></a>';
                    $btn = $btn.' <a onclick="_deleteData('.$row->id.')" href="javascript:void(0)" class="waves-effect waves-light btn btn-sm btn-danger btn-circle me-1" data-bs-original-title="Hapus Data" title="Hapus Data" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-trash-can-outline"></span></a>';

                    $btn = $btn.'<a href="javascript:void(0)" onclick="_inputFile('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-info btn-circle me-1" data-bs-original-title="Input File" title="Input File" data-bs-placement="top" data-bs-toggle="tooltip">
                    <span class="mdi mdi-file-pdf-box"></span></a>';
                    return $btn;
                })
                ->rawColumns(['file_timeline', 'file_button', 'action'])
                ->make(true);
        }

        $data['jenis_akreditasi'] = DataJenisAkreditasi::orderBy('nama_jenis_akreditasi', 'ASC')->get(['id', 'nama_jenis_akreditasi']);
        
        return view($this->base.'index', $data);
    }
    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $id      = $request->input('id');
        $method      = $request->input('methodform_data');
        
        if($method == 'add'){
            $validasi = validator()->make($request->all(),[
                'timeline_akreditasi' => 'required|mimes:pdf|max:3048',
            ],[
                'timeline_akreditasi.required' => 'File timeline akreditasitidak boleh kosong',
                'timeline_akreditasi.mimes' => 'File timeline akreditasi berekstensi pdf',
                'timeline_akreditasi.max' => 'File timeline akreditasi max 2mb',
            ]);
            if($validasi->fails()){
                return response()->json(['errors' => $validasi->errors()]);
            }else{
                $checkData = DataAkreditasi::whereTahun($request->tahun)->whereFidJenisAkreditasi($request->fid_jenis_akreditasi)->first();
                if(empty($checkData)){
                    $fileName = hexdec(uniqid()).'.'.$request->file('timeline_akreditasi')->getClientOriginalExtension();
                    $request->file('timeline_akreditasi')->move(public_path('pdf/data-akreditasi/'), $fileName);

                    DataAkreditasi::create([
                        'tahun' => $request->tahun,
                        'fid_jenis_akreditasi' => $request->fid_jenis_akreditasi,
                        'dasar_kegiatan' => $request->dasar_kegiatan,
                        'timeline_akreditasi' => $fileName,
                        'created_at' => Carbon::now()
                    ]);
                    $response = ['success' => true];
                }else{
                    $response = ['is_available' => true];
                }
            }
        }else if($method == 'update'){
            $checkData = DataAkreditasi::whereNot('id', $id)->whereTahun($request->tahun)->whereFidJenisAkreditasi($request->fid_jenis_akreditasi)->first();
            if(empty($checkData)){
                if($request->file('timeline_akreditasi')){
                    $fileName = hexdec(uniqid()).'.'.$request->file('timeline_akreditasi')->getClientOriginalExtension();
                    $request->file('timeline_akreditasi')->move(public_path('pdf/data-akreditasi/'), $fileName);
                    DataAkreditasi::find($id)->update([
                        'timeline_akreditasi' => $fileName,
                    ]);
                }
                DataAkreditasi::find($id)->update([
                    'tahun' => $request->tahun,
                    'fid_jenis_akreditasi' => $request->fid_jenis_akreditasi,
                    'dasar_kegiatan' => $request->dasar_kegiatan,
                    'updated_at' => Carbon::now()
                ]);
                $response = ['success' => true];
            }else{
                $response = ['is_available' => true];
            }
        }
        return response()->json($response);
    }
    public function edit($id)
    {
        $data = DataAkreditasi::whereId($id)->first();
        return response()->json([
            'data' => $data,
            'url_timeline' => asset('pdf/data-akreditasi/'.$data->timeline_akreditasi)
        ]);
    }
    public function destroy($id)
    {
        DataAkreditasi::find($id)->delete();
        FileAkreditasi::whereFidAkreditasi($id)->delete();
        
        return response()->json([
            'success' => true,
        ], 200);
    }
    public function fileInput($id_akreditasi)
    {
        $data = DataAkreditasi::whereId($id_akreditasi)->first();
        $output = '
        <div class="alert alert-success" role="alert">
            <div class="row justify-content-center" >
                <div class="col-md-2">
                    <span class="fw-bolder">Tahun</span>
                </div>
                <div class="col-md-10">
                    <p class="fw-bold"><span class="fw-bolder mr-2">: '.$data->tahun.'</span></p>
                </div>
            </div>
            <div class="row justify-content-center" >
                <div class="col-md-2">
                    <span class="fw-bolder">Jenis Akreditasi</span>
                </div>
                <div class="col-md-10">
                    <p class="fw-bold"><span class="fw-bolder mr-2">: '.$data->jenisakreditasi->nama_jenis_akreditasi.'</span></p>
                </div>
            </div>
            <div class="row justify-content-center" >
                <div class="col-md-2">
                    <span class="fw-bolder">Dasar Kegiatan</span>
                </div>
                <div class="col-md-10">
                    <p class="fw-bold"><span class="fw-bolder mr-2">: '.$data->dasar_kegiatan.'</span></p>
                </div>
            </div>
        </div>
        ';
        $response = array(
            'status' => TRUE,
            'output' => $output,
        );
        return response()->json($response);
    }
    public function datFileAkreditasi(Request $request)
    {
        $query = FileAkreditasi::orderBy('is_lkps', 'DESC')->orderBy('is_led', 'DESC')->whereFidAkreditasi($request->idp_akreditasi);
        if($request->filterJenisFile == 'Data LKSP'){
            $query = $query->whereIsLkps(1);
        }else if($request->filterJenisFile == 'Data LED'){
            $query = $query->whereIsLed(1);
        }else if($request->filterJenisFile == 'Instrumen Akreditasi'){
            $query = $query->whereIsInstrumenAkreditasi(1);
        }
        $data = $query->get();
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('jenis_file', function($row){
                if($row->is_lkps == 1){
                    $status = 'DATA LKPS';
                }else if($row->is_led == 1){
                    $status = 'DATA LED';
                }else if($row->is_instrumen_akreditasi == 1){
                    $status = 'INSTRUMEN AKREDITASI';
                }
                return $status;
            })
            ->addColumn('file_button', function($row){
                $btn = '<a href="'.asset('pdf/data-akreditasi/'.$row->file).'" target="_blank" class="waves-effect waves-light btn btn-sm btn-info btn-circle" data-bs-original-title="File Data" title="File Data" data-bs-placement="top" data-bs-toggle="tooltip">Lihat File</a>';
                return $btn;
            })
            ->addColumn('action', function($row){
                $btn = ' <a onclick="_deleteFileAkreditasi('.$row->id.')" href="javascript:void(0)" class="waves-effect waves-light btn btn-sm btn-danger btn-circle me-1" data-bs-original-title="Hapus Data" title="Hapus Data" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-trash-can-outline"></span></a>';
                return $btn;
            })
            ->rawColumns(['jenis_file', 'file_button', 'action'])
            ->make(true);
    }
    public function fileInputSave(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $validasi = validator()->make($request->all(),[
            'file_akreditasi' => 'required|mimes:pdf|max:3048',
        ],[
            'file_akreditasi.required' => 'File akreditasi tidak boleh kosong',
            'file_akreditasi.mimes' => 'File akreditasi berekstensi pdf',
            'file_akreditasi.max' => 'File akreditasi max 3mb',
        ]);
        if($validasi->fails()){
            return response()->json(['errors' => $validasi->errors()]);
        }else{
            $checkData = DataAkreditasi::whereTahun($request->tahun)->whereFidJenisAkreditasi($request->fid_jenis_akreditasi)->first();
            if(empty($checkData)){
                $fileName = hexdec(uniqid()).'.'.$request->file('file_akreditasi')->getClientOriginalExtension();
                $request->file('file_akreditasi')->move(public_path('pdf/data-akreditasi/'), $fileName);

                if($request->jenis_file == 'Data LKSP'){
                    $jenis_file = 'is_lkps';
                }else if($request->jenis_file == 'Data LED'){
                    $jenis_file = 'is_led';
                }else if($request->jenis_file == 'Instrumen Akreditasi'){
                    $jenis_file = 'is_instrumen_akreditasi';
                }
                
                FileAkreditasi::create([
                    'fid_akreditasi' => $request->idp_akreditasi,
                    $jenis_file => 1,
                    'nama_file' => $request->nama_file,
                    'file' => $fileName,
                ]);
                $response = ['success' => true, 'idp_akreditasi' => $request->idp_akreditasi];
            }else{
                $response = ['is_available' => true];
            }
        }
        return response()->json($response);
    }
    public function fileInputDestroy($id)
    {
        FileAkreditasi::find($id)->delete();
        return response()->json([
            'success' => true,
        ], 200);
    }
}
