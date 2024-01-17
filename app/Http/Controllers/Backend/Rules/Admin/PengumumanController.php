<?php

namespace App\Http\Controllers\Backend\Rules\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;

class PengumumanController extends Controller
{
    protected $base = 'rules.admin.pengumuman.';
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pengumuman::where('id', 1)->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('foto', function($row) {
                        return '<img class="img-thumbnail" alt="200x200" width="500" src="'.asset(($row->foto_pengumuman)).'" data-holder-rendered="true">';
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
                           $btn = '<a href="javascript:void(0)" onclick="_editData('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-info btn-circle" data-bs-original-title="Edit Pengumuman" title="Edit Pengumuman" data-bs-placement="top" data-bs-toggle="tooltip">
                           <span class="mdi mdi-pencil-box-multiple"></span></a>';
    
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
        
        $data = Pengumuman::find($id);

        if($data['status'] == 1){
            Pengumuman::find($id)->update([
                'status' => 0,
                'updated_at' => Carbon::now()
            ]);
        }else if($data['status'] == 0){
            Pengumuman::find($id)->update([
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
        
        $foto_pengumuman      = $request->file('foto_pengumuman');
        $keterangan      = $request->input('keterangan');
        $id      = $request->input('id');
        $method      = $request->input('methodform_data');

        // Add data
        if($method == 'add'){
            $validasi = validator()->make($request->all(),[
                'foto_pengumuman' => 'required|mimes:jpg,jpeg,png|max:2048',
            ],[
                'foto_pengumuman.required' => 'Foto Pengumuman tidak boleh kosong',
                'foto_pengumuman.mimes' => 'Foto Pengumuman berekstensi jpg,jpeg,png',
                'foto_pengumuman.max' => 'Max file Foto Pengumuman 2mb',
            ]);

            if($validasi->fails()){
                return response()->json(['errors' => $validasi->errors()]);
            }else{
                $name_gen = hexdec(uniqid()).'.'.$foto_pengumuman->getClientOriginalExtension();

                Image::make($foto_pengumuman)->resize(1255,457)->save('img/pengumuman/'.$name_gen);
                $save_url = 'img/pengumuman/'.$name_gen;

                Pengumuman::create([
                    'keterangan' => $keterangan,
                    'foto_pengumuman' => $save_url,
                    'status' => 1,
                    'created_at' => Carbon::now()
                ]);
                
                return response()->json([
                    'success' => true,
                ], 200);
            }
        // Update data
        }else if($method == 'update'){
            if($request->file('foto_pengumuman')){
                $validasi = validator()->make($request->all(),[
                    'foto_pengumuman' => 'mimes:jpg,jpeg,png|max:2048',
                ],[
                    'foto_pengumuman.mimes' => 'Foto Pengumuman berekstensi jpg,jpeg,png',
                    'foto_pengumuman.max' => 'Max file Foto Pengumuman 2mb',
                ]);
    
                if($validasi->fails()){
                    return response()->json(['errors' => $validasi->errors()]);
                }else{
                    $name_gen = hexdec(uniqid()).'.'.$foto_pengumuman->getClientOriginalExtension();
    
                    Image::make($foto_pengumuman)->resize(2000,2000)->save('img/pengumuman/'.$name_gen);
                    $save_url = 'img/pengumuman/'.$name_gen;
    
                    Pengumuman::find($id)->update([
                        'foto_pengumuman' => $save_url,
                    ]);
                    
                }
            } 

            Pengumuman::find($id)->update([
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
        $data = Pengumuman::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        Pengumuman::find($id)->delete();
        
        return response()->json([
            'success' => true,
        ], 200);
    }
}
