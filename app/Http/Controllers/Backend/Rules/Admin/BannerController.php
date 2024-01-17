<?php

namespace App\Http\Controllers\Backend\Rules\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Carbon\Carbon;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;

class BannerController extends Controller
{
    protected $base = 'rules.admin.banner.';
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Banner::orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('foto', function($row) {
                        return '<img class="img-thumbnail" alt="200x200" width="500" src="'.asset(($row->file_banner)).'" data-holder-rendered="true">';
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
   
                           $btn = '<a href="javascript:void(0)" onclick="editData('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-info btn-circle" data-bs-original-title="Edit Data" title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip">
                           <span class="mdi mdi-pencil-box-multiple"></span></a>';
   
                           $btn = $btn.' <a onclick="deleteData('.$row->id.')" href="javascript:void(0)" class="waves-effect waves-light btn btn-sm btn-danger btn-circle" data-bs-original-title="Hapus Data" data-bs-placement="top" data-bs-toggle="tooltip" title="Hapus Data"><span class="mdi mdi-trash-can-outline"></span></a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action', 'foto', 'status'])
                    ->make(true);
        }
        return view($this->base.'index');
    }

    public function ubahStatus($id)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $data = Banner::find($id);

        if($data['status'] == 1){
            Banner::find($id)->update([
                'status' => 0,
                'updated_at' => Carbon::now()
            ]);
        }else if($data['status'] == 0){
            Banner::find($id)->update([
                'status' => 1,
                'updated_at' => Carbon::now()
            ]);
        }
        
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $banner      = $request->file('file_banner');
        $id      = $request->input('id');
        $method      = $request->input('methodform_data');

        // Add data
        if($method == 'add'){
            $validasi = validator()->make($request->all(),[
                'file_banner' => 'required|mimes:jpg,jpeg,png|max:2048',
            ],[
                'file_banner.required' => 'Banner tidak boleh kosong',
                'file_banner.mimes' => 'File berekstensi jpg,jpeg,png',
                'file_banner.max' => 'Max file 2mb',
            ]);

            if($validasi->fails()){
                return response()->json(['errors' => $validasi->errors()]);
            }else{
                $name_gen = hexdec(uniqid()).'.'.$banner->getClientOriginalExtension();

                Image::make($banner)->resize(1255,457)->save('img/banner/'.$name_gen);
                $save_url = 'img/banner/'.$name_gen;

                Banner::create([
                    'file_banner' => $save_url,
                    'status' => 1,
                    'created_at' => Carbon::now()
                ]);
                
                return response()->json([
                    'success' => true,
                ], 200);
            }
        // Update data
        }else if($method == 'update'){
            $validasi = validator()->make($request->all(),[
                'file_banner' => 'required|mimes:jpg,jpeg,png|max:2048',
            ],[
                'file_banner.required' => 'Banner tidak boleh kosong',
                'file_banner.mimes' => 'File berekstensi jpg,jpeg,png',
                'file_banner.max' => 'Max file 2mb',
            ]);

            if($validasi->fails()){
                return response()->json(['errors' => $validasi->errors()]);
            }else{
                $name_gen = hexdec(uniqid()).'.'.$banner->getClientOriginalExtension();

                Image::make($banner)->resize(1255,457)->save('img/banner/'.$name_gen);
                $save_url = 'img/banner/'.$name_gen;

                Banner::find($id)->update([
                    'file_banner' => $save_url,
                    'updated_at' => Carbon::now()
                ]);
                
                return response()->json([
                    'success' => true,
                ], 200);
            }
            
            return response()->json([
                'success' => true,
                'banner' => $method,
            ], 200);
        }
    
    }

    public function edit($id)
    {
        $data = Banner::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        Banner::find($id)->delete();
        
        return response()->json([
            'success' => true,
        ], 200);
    }

}
