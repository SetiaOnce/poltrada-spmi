<?php

namespace App\Http\Controllers\Backend\Rules\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataJenisKegiatan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class DataJenisKegiatanController extends Controller
{
    protected $base = 'rules.admin.masterisasi.data_jenis_kegiatan.';
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DataJenisKegiatan::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" onclick="_editData('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-info btn-circle" data-bs-original-title="Edit Data" title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip">
                        <span class="mdi mdi-pencil-box-multiple"></span></a>';

                        // $btn = $btn.' <a onclick="_deleteData('.$row->id.')" href="javascript:void(0)" class="waves-effect waves-light btn btn-sm btn-danger btn-circle" data-bs-original-title="Hapus Data" title="Hapus Data" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-trash-can-outline"></span></a>';
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
        
        $nama_jenis_kegiatan      = $request->input('nama_jenis_kegiatan');
        
        if($method == 'add'){
            DataJenisKegiatan::create([
                'nama_jenis_kegiatan' => $nama_jenis_kegiatan,
                'created_at' => Carbon::now()
            ]);
        }else if($method == 'update'){
            DataJenisKegiatan::find($id)->update([
                'nama_jenis_kegiatan' => $nama_jenis_kegiatan,
                'updated_at' => Carbon::now()
            ]);
        }    
        
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function edit($id)
    {
        $data = DataJenisKegiatan::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        DataJenisKegiatan::find($id)->delete();
        
        return response()->json([
            'success' => true,
        ], 200);
    }
}
