<?php

namespace App\Http\Controllers\Backend\Rules\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\DataUnitProdi;
use App\Models\GroupUnitKerja;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DataUnitPordiController extends Controller
{
    protected $base = 'rules.pengelola.masterisasi.data_unit_prodi.';
    
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
}
