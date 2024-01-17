<?php

namespace App\Http\Controllers\Backend\Rules\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\DaftarPenilaian;
use App\Models\DataLembagaAkreditasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DaftarPenilaianController extends Controller
{
    protected $base = 'rules.pengelola.manajemen_mutu.daftar_penilaian.';
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DaftarPenilaian::select(
                "daftar_penilaian.id",
                "daftar_penilaian.tahun",
                "daftar_penilaian.nilai_mutu",
                "daftar_penilaian.keterangan",
                "data_lembaga_akreditasi.nama_lembaga as nama_lembaga",
            )
            ->join("data_lembaga_akreditasi", "data_lembaga_akreditasi.id", "=", "daftar_penilaian.lembaga_akreditasi_id")
            ->get();
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
        $data['data_lembaga_akreditasi'] = DataLembagaAkreditasi::orderBy('nama_lembaga', 'ASC')->get();
        
        return view($this->base.'index', $data);
    }

    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $id      = $request->input('id');
        $method      = $request->input('methodform_data');

        $lembaga_akreditasi_id      = $request->input('lembaga_akreditasi_id');
        $tahun      = $request->input('tahun');
        $nilai_mutu      = $request->input('nilai_mutu');
        $keterangan      = $request->input('keterangan');

        if($method == 'add'){
            DaftarPenilaian::create([
                'lembaga_akreditasi_id' => $lembaga_akreditasi_id,
                'tahun' => $tahun,
                'nilai_mutu' => $nilai_mutu,
                'keterangan' => $keterangan,
                'created_at' => Carbon::now()
            ]);
        
            return response()->json([
                'success' => true,
            ], 200);

        }else if($method == 'update'){
            DaftarPenilaian::find($id)->update([
                'lembaga_akreditasi_id' => $lembaga_akreditasi_id,
                'tahun' => $tahun,
                'nilai_mutu' => $nilai_mutu,
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
        $data = DaftarPenilaian::find($id);
        return response()->json([
            'data' => $data,
        ]);
    }

    public function destroy($id)
    {
        DaftarPenilaian::find($id)->delete();
        
        return response()->json([
            'success' => true,
        ], 200);
    }
}
