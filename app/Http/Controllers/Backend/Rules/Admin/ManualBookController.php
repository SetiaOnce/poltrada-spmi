<?php

namespace App\Http\Controllers\Backend\Rules\Admin;

use App\Http\Controllers\Controller;
use App\Models\ManualBook;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ManualBookController extends Controller
{
    protected $base = 'rules.admin.manual_book.';
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ManualBook::orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('pdf', function($row) {
                        return '<a href="'.asset(($row->file_manual)).'" data-bs-original-title="Lihat File Pdf" data-bs-placement="top" data-bs-toggle="tooltip" target="_blank">
                        <img src="'.asset(('img/pdf-image.jpg')).'" alt="avatar-4" class=" avatar-md">
                        </a>';
                    }) 
                    ->editColumn('role', function($row) {
                        if($row->level_id == 1){
                         return 'ADMINISTRATOR';
                        }else if($row->level_id == 2){
                            return 'PENGELOLA';
                        }else if($row->level_id == 3){
                            return 'PRODI';
                        }else if($row->level_id == 4){
                            return 'ASESOR';
                        }
                     })
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" onclick="_editData('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-info btn-circle" data-bs-original-title="Edit Data" title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip">
                           <span class="mdi mdi-pencil-box-multiple"></span></a>';
   
                           $btn = $btn.' <a onclick="_deleteData('.$row->id.')" href="javascript:void(0)" class="waves-effect waves-light btn btn-sm btn-danger btn-circle" data-bs-original-title="Hapus Data" title="Hapus Data" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-trash-can-outline"></span></a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action', 'pdf'])
                    ->make(true);
        }
        
        return view($this->base.'index');
    }

    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $id      = $request->input('id');
        $method      = $request->input('methodform_data');

        $level_id      = $request->input('level_id');
        $file_manual      = $request->file('file_manual');

        if($method == 'add'){
            $cek_manual = ManualBook::where('level_id', $level_id)->first();
            if(!empty($cek_manual->level_id)){
                if($cek_manual->level_id == 1){
                    $level =  'ADMINISTRATOR';
                }else if($cek_manual->level_id == 2){
                    $level =  'PENGELOLA';
                }else if($cek_manual->level_id == 3){
                    $level =  'PRODI';
                }else if($cek_manual->level_id == 4){
                    $level =  'ASESOR';
                }
                
                return response()->json([
                    'level' => $level,
                    'already' => true,
                ], 200);
            }
            $validasi = validator()->make($request->all(),[
                'file_manual' => 'required|mimes:pdf|max:3048',
            ],[
                'file_manual.required' => 'File manual book tidak boleh kosong',
                'file_manual.mimes' => 'File Manual Book harus berekstensi pdf',
                'file_manual.max' => 'Max file manual book pdf 3mb',
            ]);

            if($validasi->fails()){
                return response()->json(['errors' => $validasi->errors()]);
            }else{
                $name_gen = hexdec(uniqid()).'manual-book.'.$file_manual->getClientOriginalExtension();
                $file_manual->move(public_path('pdf/manual-book/'), $name_gen);
                $save_url = 'pdf/manual-book/'.$name_gen;

                ManualBook::create([
                    'level_id' => $level_id,
                    'file_manual' => $save_url,
                    'created_at' => Carbon::now()
                ]);
                
                return response()->json([
                    'success' => true,
                ], 200);
            }
        }else if($method == 'update'){
            if($request->file('file_manual')){
                $validasi = validator()->make($request->all(),[
                    'file_manual' => 'mimes:pdf|max:3048',
                ],[
                    'file_manual.mimes' => 'File Manual Book harus berekstensi pdf',
                    'file_manual.max' => 'Max file manual book pdf 3mb',
                ]);
    
                if($validasi->fails()){
                    return response()->json(['errors' => $validasi->errors()]);
                }else{
                    $name_gen = hexdec(uniqid()).'manual-book.'.$file_manual->getClientOriginalExtension();
                    $file_manual->move(public_path('pdf/manual-book/'), $name_gen);
                    $save_url = 'pdf/manual-book/'.$name_gen;
    
                    ManualBook::find($id)->update([
                        'file_manual' => $save_url,
                    ]);
                
                }
            }
            
            ManualBook::find($id)->update([
                'level_id' => $level_id,
                'updated_at' => Carbon::now()
            ]);
            
            return response()->json([
                'success' => true,
            ], 200);
        }
    }

    public function edit($id)
    {
        $data = ManualBook::find($id);
        return response()->json([
            'data' => $data,
        ]);
    }

    public function destroy($id)
    {
        @unlink(public_path(ManualBook::find($id)->file_manual));
        ManualBook::find($id)->delete();
        return response()->json([
            'success' => true,
        ], 200);
    }
}
