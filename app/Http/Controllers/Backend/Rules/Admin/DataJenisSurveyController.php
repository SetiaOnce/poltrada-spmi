<?php

namespace App\Http\Controllers\Backend\Rules\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataJenisSurvey;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class DataJenisSurveyController extends Controller
{
    protected $base = 'rules.admin.masterisasi.data_jenis_survey.';
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DataJenisSurvey::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('gambar', function($row) {
                    return '<img class="img-thumbnail" alt="200x200" width="72" src="'.asset(($row->gambar)).'" data-holder-rendered="true">';
                })
                ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" onclick="_editData('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-info btn-circle" data-bs-original-title="Edit Data" title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip">
                        <span class="mdi mdi-pencil-box-multiple"></span></a>';

                        return $btn;
                })
                ->rawColumns(['action', 'gambar'])
                ->make(true);
        }
        
        return view($this->base.'index');
    }

    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");

        $id      = $request->input('id');
        $method      = $request->input('methodform_data');
        
        $nama_jenis_survey      = $request->input('nama_jenis_survey');
        $keterangan      = $request->input('keterangan');
        $gambar      = $request->file('gambar');
        
        if($method == 'add'){
            $validasi = validator()->make($request->all(),[
                'gambar' => 'required|mimes:jpg,jpeg,png|max:2048',
            ],[
                'gambar.required' => 'Gambar tidak boleh kosong',
                'gambar.mimes' => 'File berekstensi jpg,jpeg,png',
                'gambar.max' => 'Max file 2mb',
            ]);

            if($validasi->fails()){
                return response()->json(['errors' => $validasi->errors()]);
            }else{
                $name_gen = hexdec(uniqid()).'-gambar.'.$gambar->getClientOriginalExtension();
                Image::make($gambar)->resize(226,221)->save('img/link-survey/'.$name_gen);
                $save_url = 'img/link-survey/'.$name_gen;
                DataJenisSurvey::create([
                    'nama_jenis_survey' => $nama_jenis_survey,
                    'keterangan' => $keterangan,
                    'gambar' => $save_url,
                    'created_at' => Carbon::now()
                ]);

                return response()->json([
                    'success' => true,
                ], 200);
            }
        }else if($method == 'update'){
            if($request->file('gambar')){
                $validasi = validator()->make($request->all(),[
                    'gambar' => 'required|mimes:jpg,jpeg,png|max:2048',
                ],[
                    'gambar.required' => 'Gambar tidak boleh kosong',
                    'gambar.mimes' => 'File berekstensi jpg,jpeg,png',
                    'gambar.max' => 'Max file 2mb',
                ]);
    
                if($validasi->fails()){
                    return response()->json(['errors' => $validasi->errors()]);
                }else{
                    $name_gen = hexdec(uniqid()).'-gambar.'.$gambar->getClientOriginalExtension();
                    Image::make($gambar)->resize(226,221)->save('img/link-survey/'.$name_gen);
                    $save_url = 'img/link-survey/'.$name_gen;
                    DataJenisSurvey::find($id)->update([
                        'gambar' => $save_url,
                    ]);
                }
            }
            
            DataJenisSurvey::find($id)->update([
                'nama_jenis_survey' => $nama_jenis_survey,
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
        $data = DataJenisSurvey::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        DataJenisSurvey::find($id)->delete();
        
        return response()->json([
            'success' => true,
        ], 200);
    }
}
