<?php

namespace App\Http\Controllers\Backend\Rules\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\LinkSurveyExternal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;

class LinkSurveyExternalController extends Controller
{
    protected $base = 'rules.pengelola.manajemen_survey.link_survey_external.';
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = LinkSurveyExternal::orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('logo', function($row) {
                         return '<img class="img-thumbnail" alt="200x200" width="150" src="'.asset(($row->logo)).'" data-holder-rendered="true">';
                     })           
                    ->editColumn('status', function($row) {
                        if($row->status == 1){
                         return '<input onclick="editStatus('.$row->id.')" type="checkbox" id="switch'.$row->id.'" switch="none" checked mute readonly/>
                         <label for="switch'.$row->id.'" data-on-label="On" data-off-label="Off" data-bs-original-title="Ubah Status" title="Ubah Status" data-bs-placement="top" data-bs-toggle="tooltip"></label>';
                        }else{
                         return '<input onclick="editStatus('.$row->id.')" type="checkbox" id="switch'.$row->id.'" switch="none" mute readonly/>
                         <label for="switch'.$row->id.'" data-on-label="On" data-off-label="Off" data-bs-original-title="Ubah Status" title="Ubah Status" data-bs-placement="top" data-bs-toggle="tooltip"></label>';
                        }
                     })           
                     ->addColumn('action', function($row){
                            $btn = '<a href="javascript:void(0)" onclick="_editData('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-info btn-circle" data-bs-original-title="Edit Data" title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip">
                            <span class="mdi mdi-pencil-box-multiple"></span></a>';
    
                            $btn = $btn.' <a onclick="_deleteData('.$row->id.')" href="javascript:void(0)" class="waves-effect waves-light btn btn-sm btn-danger btn-circle" data-bs-original-title="Hapus Data" data-bs-placement="top" data-bs-toggle="tooltip" title="Hapus Data"><span class="mdi mdi-trash-can-outline"></span></a>';
     
                             return $btn;
                     })
                     ->rawColumns(['action', 'status', 'logo'])
                     ->make(true);
        }
        
        return view($this->base.'index');
    }

    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $id      = $request->input('id');
        $method      = $request->input('methodform_data');

        $nama_link_survey      = $request->input('nama_link_survey');
        $link_url      = $request->input('link_url');
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
                $name_gen = hexdec(uniqid()).'.'.$logo->getClientOriginalExtension();
                Image::make($logo)->resize(226,221)->save('img/link-survey/'.$name_gen);
                $save_url = 'img/link-survey/'.$name_gen;
                
                LinkSurveyExternal::create([
                    'nama_link_survey' => $nama_link_survey,
                    'link_url' => $link_url,
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
                    $name_gen = hexdec(uniqid()).'.'.$logo->getClientOriginalExtension();
                    Image::make($logo)->resize(226,221)->save('img/link-survey/'.$name_gen);
                    $save_url = 'img/link-survey/'.$name_gen;
                    
                    LinkSurveyExternal::find($id)->update([
                        'logo' => $save_url,
                    ]);   
                }
            }
            LinkSurveyExternal::find($id)->update([
                'nama_link_survey' => $nama_link_survey,
                'link_url' => $link_url,
                'updated_at' => Carbon::now()
            ]);

            return response()->json([
                'success' => true,
            ], 200);
        }
    }

    public function ubahStatus($id)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $data = LinkSurveyExternal::find($id);

        if($data['status'] == 1){
            LinkSurveyExternal::find($id)->update([
                'status' => 0,
                'updated_at' => Carbon::now()
            ]);
        }else if($data['status'] == 0){
            LinkSurveyExternal::find($id)->update([
                'status' => 1,
                'updated_at' => Carbon::now()
            ]);
        }
        
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function edit($id)
    {
        $data = LinkSurveyExternal::where('id', $id)->first();
        return response()->json([
            'data' => $data,
        ]);
    }

    public function destroy($id)
    {
        LinkSurveyExternal::find($id)->delete();
        
        return response()->json([
            'success' => true,
        ], 200);
    }
}
