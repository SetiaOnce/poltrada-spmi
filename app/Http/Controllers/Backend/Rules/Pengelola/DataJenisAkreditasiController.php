<?php

namespace App\Http\Controllers\Backend\Rules\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\DataJenisAkreditasi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class DataJenisAkreditasiController extends Controller
{
    protected $base = 'rules.pengelola.masterisasi.data_jenis_kegiatan.';
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DataJenisAkreditasi::orderBy('id', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" onclick="_editData('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-info btn-circle" data-bs-original-title="Edit Data" title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip">
                        <span class="mdi mdi-pencil-box-multiple"></span></a>';
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
        
        if($method == 'add'){
            DataJenisAkreditasi::create([
                'nama_jenis_akreditasi' => $request->nama_jenis_akreditasi,
                'created_at' => Carbon::now()
            ]);
        }else if($method == 'update'){
            DataJenisAkreditasi::find($id)->update([
                'nama_jenis_akreditasi' => $request->nama_jenis_akreditasi,
                'updated_at' => Carbon::now()
            ]);
        }    
        return response()->json([ 'success' => true, ], 200);
    }
    public function edit($id)
    {
        $data = DataJenisAkreditasi::find($id);
        return response()->json($data);
    }
    public function destroy($id)
    {
        DataJenisAkreditasi::find($id)->delete();
        return response()->json(['success' => true, ], 200);
    }
}
