<?php

namespace App\Http\Controllers\Backend\Rules\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataUnitProdi;
use App\Models\GroupUnitKerja;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DataUnitPordiController extends Controller
{
    protected $base = 'rules.admin.masterisasi.data_unit_prodi.';
    
    public function index(Request $request)
    {
        if(!session()->get('login_akses')) { 
            return redirect('/auth_login'); 
        } 
        if ($request->ajax()) {
            $data = GroupUnitKerja::orderBy('id', 'DESC')->get();
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
        
        return view($this->base.'index');
    }

    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");

        $id      = $request->input('id');
        $method      = $request->input('methodform_data');
        
        $jenjang      = $request->input('jenjang');
        $unit_prodi      = $request->input('unit_prodi');
        
        if($method == 'add'){
            DataUnitProdi::create([
                'jenjang' => $jenjang,
                'nama_unit_prodi' => $unit_prodi,
                'created_at' => Carbon::now()
            ]);
        }else if($method == 'update'){
            DataUnitProdi::find($id)->update([
                'jenjang' => $jenjang,
                'nama_unit_prodi' => $unit_prodi,
                'updated_at' => Carbon::now()
            ]);
        }    
        
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function edit($id)
    {
        $data = DataUnitProdi::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        DataUnitProdi::find($id)->delete();
        
        return response()->json([
            'success' => true,
        ], 200);
    }

}
