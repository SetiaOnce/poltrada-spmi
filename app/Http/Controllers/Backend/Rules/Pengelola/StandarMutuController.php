<?php

namespace App\Http\Controllers\Backend\Rules\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\DaftarStandarMutu;
use App\Models\DataLembagaAkreditasi;
use App\Models\GroupUnitKerja;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StandarMutuController extends Controller
{
    protected $base = 'rules.pengelola.manajemen_mutu.standar_mutu.';
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DaftarStandarMutu::select(
                "spm_daftar_standar_mutu.id",
                "spm_daftar_standar_mutu.tahun",
                "spm_daftar_standar_mutu.nama_standar",
                "spm_data_lembaga_akreditasi.nama_lembaga as lembaga",
                "group_unit_kerja.unit_kerja as prodi",
            )
            ->join("spm_data_lembaga_akreditasi", "spm_data_lembaga_akreditasi.id", "=", "spm_daftar_standar_mutu.lembaga_akreditasi_id")
            ->join("group_unit_kerja", "group_unit_kerja.id", "=", "spm_daftar_standar_mutu.unit_prodi_id")
            ->orderBy('spm_daftar_standar_mutu.created_at', 'DESC')
            ->get();
            return DataTables::of($data)
                    ->addIndexColumn()       
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" onclick="_editData('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-info btn-circle me-1" data-bs-original-title="Edit Data" title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip">
                           <span class="mdi mdi-pencil-box-multiple"></span></a>';
   
                           $btn = $btn.'<a href="'.route('jenis.standar.mutu.index', $row->id).'" class="waves-effect waves-light btn btn-sm btn-success btn-circle me-1" data-bs-original-title="Manajemen Jenis Standar Mutu" title="Manajemen Jenis Standar Mutu" data-bs-placement="top" data-bs-toggle="tooltip"><span class="fas fa-plus"></span></a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        $data['data_lembaga_akreditasi'] = DataLembagaAkreditasi::orderBy('nama_lembaga', 'ASC')->get(['id','nama_lembaga']);
        $data['data_unit_prodi'] = GroupUnitKerja::orderBy('unit_kerja', 'ASC')->get(['id', 'unit_kerja']);
        
        return view($this->base.'index', $data);
    }

    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $id      = $request->input('id');
        $method      = $request->input('methodform_data');

        $tahun      = $request->input('tahun');
        $lembaga_akreditasi_id      = $request->input('lembaga_akreditasi_id');
        $unit_prodi_id      = $request->input('unit_prodi_id');
        $nama_standar      = $request->input('nama_standar');
        $keterangan      = $request->input('keterangan');
        $jenis_indikator      = $request->input('jenis_indikator');
        
        if($method == 'add'){
            DaftarStandarMutu::create([
                'tahun' => $tahun,
                'lembaga_akreditasi_id' => $lembaga_akreditasi_id,
                'unit_prodi_id' => $unit_prodi_id,
                'nama_standar' => $nama_standar,
                'keterangan' => $keterangan,
                'jenis_indikator' => $jenis_indikator,
                'created_at' => Carbon::now()
            ]);
            
            return response()->json([
                'success' => true,
            ], 200);
        }else if($method == 'update'){
            DaftarStandarMutu::find($id)->update([
                'tahun' => $tahun,
                'lembaga_akreditasi_id' => $lembaga_akreditasi_id,
                'unit_prodi_id' => $unit_prodi_id,
                'nama_standar' => $nama_standar,
                'keterangan' => $keterangan,
                'jenis_indikator' => $jenis_indikator,
                'updated_at' => Carbon::now()
            ]);
            
            return response()->json([
                'success' => true,
            ], 200);
        }
    }

    public function edit($id)
    {
        $data = DaftarStandarMutu::where('id', $id)->first();
        return response()->json([
            'data' => $data,
        ]);
    }

    public function destroy($id)
    {
        DaftarStandarMutu::find($id)->delete();
        
        return response()->json([
            'success' => true,
        ], 200);
    }
}
