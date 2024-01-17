<?php

namespace App\Http\Controllers\Backend\Rules\Admin;

use App\Http\Controllers\Controller;
use App\Models\LinkApp;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

class LinkAplikasiController extends Controller
{
    protected $base = 'rules.admin.link_app.';
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = LinkApp::orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('foto', function($row) {
                        return '<img class="img-responsive" src="'.asset(($row->logo_app)).'" width="120px">';
                    })
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" onclick="_editData('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-info btn-circle" data-bs-original-title="Edit Data" title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip">
                           <span class="mdi mdi-pencil-box-multiple"></span></a>';
   
                           $btn = $btn.' <a onclick="_deleteData('.$row->id.')" href="javascript:void(0)" class="waves-effect waves-light btn btn-sm btn-danger btn-circle" data-bs-original-title="Hapus Data" title="Hapus Data" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-trash-can-outline"></span></a>';
                            return $btn;
                    })
                    ->rawColumns(['action', 'foto'])
                    ->make(true);
        }
        
        return view($this->base.'index');
    }

    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");

        $id      = $request->input('id');
        $method      = $request->input('methodform_data');
        
        $nama_app      = $request->input('nama_app');
        $logo_app      = $request->file('logo_app');
        $link_url      = $request->input('link_url');

        // Add data
        if($method == 'add'){
            $validasi = validator()->make($request->all(),[
                'logo_app' => 'required|mimes:jpg,jpeg,png|max:1048',
            ],[
                'logo_app.required' => 'Logo App tidak boleh kosong',
                'logo_app.mimes' => 'File berekstensi jpg,jpeg,png',
                'logo_app.max' => 'Max file 1mb',
            ]);

            if($validasi->fails()){
                return response()->json(['errors' => $validasi->errors()]);
            }else{
                $name_gen = hexdec(uniqid()).'.'.$logo_app->getClientOriginalExtension();
                Image::make($logo_app)->resize(358,79)->save('img/provider/'.$name_gen);
                $save_url = 'img/provider/'.$name_gen;

                LinkApp::create([
                    'nama_app' => $nama_app,
                    'logo_app' => $save_url,
                    'link_url' => $link_url,
                    'created_at' => Carbon::now()
                ]);
                
                return response()->json([
                    'success' => true,
                ], 200);
            }
        // Update data
        }else if($method == 'update'){
            if($request->file('logo_app')){
                $validasi = validator()->make($request->all(),[
                    'logo_app' => 'required|mimes:jpg,jpeg,png|max:1048',
                ],[
                    'logo_app.required' => 'Logo App tidak boleh kosong',
                    'logo_app.mimes' => 'File berekstensi jpg,jpeg,png',
                    'logo_app.max' => 'Max file 1mb',
                ]);
    
                if($validasi->fails()){
                    return response()->json(['errors' => $validasi->errors()]);
                }else{
                    @unlink(public_path(LinkApp::find($id)->logo_app));
                    $name_gen = hexdec(uniqid()).'.'.$logo_app->getClientOriginalExtension();
                    Image::make($logo_app)->resize(358,79)->save('img/provider/'.$name_gen);
                    $save_url = 'img/provider/'.$name_gen;
    
                    LinkApp::find($id)->update([
                        'logo_app' => $save_url,
                    ]);
                } 
            }

            LinkApp::find($id)->update([
                'nama_app' => $nama_app,
                'link_url' => $link_url,
                'updated_at' => Carbon::now()
            ]);

            return response()->json([
                'success' => true,
            ], 200);
        }
    }

    public function edit($id)
    {
        $data = LinkApp::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        LinkApp::find($id)->delete();
        
        return response()->json([
            'success' => true,
        ], 200);
    }
}
