<?php

namespace App\Http\Controllers\Backend\Rules\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\DataLembagaAkreditasi;
use App\Models\DataUnitProdi;
use App\Models\GroupUnitKerja;
use App\Models\TargetNilaiMutu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TargetNilaiMutuController extends Controller
{
    protected $base = 'rules.pengelola.manajemen_mutu.target_nilai_mutu.';
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = TargetNilaiMutu::select(
                "spm_target_nilai_mutu.id",
                "spm_target_nilai_mutu.tahun",
                "spm_target_nilai_mutu.target_nilai",
                "spm_target_nilai_mutu.keterangan",
                "data_lembaga_akreditasi.nama_lembaga as lembaga",
                "group_unit_kerja.unit_kerja as prodi",
            )
            ->join("data_lembaga_akreditasi", "data_lembaga_akreditasi.id", "=", "spm_target_nilai_mutu.lembaga_akreditasi_id")
            ->join("group_unit_kerja", "group_unit_kerja.id", "=", "spm_target_nilai_mutu.unit_prodi_id")
            ->orderBy('spm_target_nilai_mutu.created_at', 'DESC')
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

        $data['data_lembaga_akreditasi'] = DataLembagaAkreditasi::orderBy('nama_lembaga', 'ASC')->get(['id','nama_lembaga']);
        $data['data_unit_prodi'] = GroupUnitKerja::where('status', 1)->orderBy('unit_kerja', 'ASC')->get(['id', 'unit_kerja']);
        
        return view($this->base.'index', $data);
    }

    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $id      = $request->input('id');
        $method      = $request->input('methodform_data');

        $lembaga_akreditasi_id      = $request->input('lembaga_akreditasi_id');
        $unit_prodi_id      = $request->input('unit_prodi_id');
        $tahun      = $request->input('tahun');
        $target_nilai      = $request->input('target_nilai');
        $keterangan      = $request->input('keterangan');

        if($method == 'add'){
            TargetNilaiMutu::create([
                'lembaga_akreditasi_id' => $lembaga_akreditasi_id,
                'unit_prodi_id' => $unit_prodi_id,
                'tahun' => $tahun,
                'target_nilai' => $target_nilai,
                'keterangan' => $keterangan,
                'created_at' => Carbon::now()
            ]);
            
            return response()->json([
                'success' => true,
            ], 200);
        }else if($method == 'update'){
            TargetNilaiMutu::find($id)->update([
                'lembaga_akreditasi_id' => $lembaga_akreditasi_id,
                'unit_prodi_id' => $unit_prodi_id,
                'tahun' => $tahun,
                'target_nilai' => $target_nilai,
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
        $data = TargetNilaiMutu::where('id', $id)->first();
        return response()->json([
            'data' => $data,
        ]);
    }

    public function destroy($id)
    {
        TargetNilaiMutu::find($id)->delete();
        
        return response()->json([
            'success' => true,
        ], 200);
    }
}
