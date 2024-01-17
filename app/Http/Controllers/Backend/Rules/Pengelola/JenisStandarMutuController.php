<?php

namespace App\Http\Controllers\Backend\Rules\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\DaftarStandarMutu;
use App\Models\JenisStandarMutu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JenisStandarMutuController extends Controller
{
    protected $base = 'rules.pengelola.manajemen_mutu.standar_mutu.list.';
    public function index(Request $request, $id)
    {
        // menampilkan jenis standar mutu ke dalam table berdasarkan daftar standar mutu yang di pilih
        if ($request->ajax()) {
            $data = JenisStandarMutu::select(
                "spm_jenis_standar_mutu.id",
                "spm_jenis_standar_mutu.jenis_standar_mutu",
                "spm_jenis_standar_mutu.jenis_indikator",
                "spm_jenis_standar_mutu.bobot_nilai",
                "spm_jenis_standar_mutu.target_nilai",
                "spm_daftar_standar_mutu.nama_standar",
            )
            ->join("spm_daftar_standar_mutu", "spm_daftar_standar_mutu.id", "=", "spm_jenis_standar_mutu.daftar_standar_mutu_id")
            ->where('spm_jenis_standar_mutu.daftar_standar_mutu_id', $id)
            ->get();
            return DataTables::of($data)
                    ->addIndexColumn()       
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" onclick="_editData('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-info btn-circle me-1" data-bs-original-title="Edit Data" title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip">
                           <span class="mdi mdi-pencil-box-multiple"></span></a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        //mengambil value form input berdasarkan daftar standar mutu yang dipilih
        $data['daftar_standar_mutu'] = DaftarStandarMutu::select(
            "spm_daftar_standar_mutu.id",
            "spm_daftar_standar_mutu.nama_standar",
            "spm_daftar_standar_mutu.tahun",
            "spm_data_lembaga_akreditasi.nama_lembaga",
            "group_unit_kerja.unit_kerja",
        )
        ->join("spm_data_lembaga_akreditasi", "spm_data_lembaga_akreditasi.id", "=", "spm_daftar_standar_mutu.lembaga_akreditasi_id")
        ->join("group_unit_kerja", "group_unit_kerja.id", "=", "spm_daftar_standar_mutu.unit_prodi_id")
        ->where('spm_daftar_standar_mutu.id', $id)
        ->first();
        
        return view($this->base.'jenis_standar_mutu', $data);
    }

    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $id      = $request->input('id');
        $method      = $request->input('methodform_data');

        $daftar_standar_mutu_id      = $request->input('daftar_standar_mutu_id');
        $jenis_standar_mutu      = $request->input('jenis_standar_mutu');
        $data_dukung      = $request->input('data_dukung');
        $keterangan      = $request->input('keterangan');
        $jenis_indikator      = $request->input('jenis_indikator');
        $bobot_nilai      = $request->input('bobot_nilai');
        $target_nilai      = $request->input('target_nilai');
        
        if($method == 'add'){
            JenisStandarMutu::create([
                'daftar_standar_mutu_id' => $daftar_standar_mutu_id,
                'jenis_standar_mutu' => $jenis_standar_mutu,
                'data_dukung' => $data_dukung,
                'keterangan' => $keterangan,
                'jenis_indikator' => $jenis_indikator,
                'bobot_nilai' => $bobot_nilai,
                'target_nilai' => $target_nilai,
                'created_at' => Carbon::now()
            ]);
            
            return response()->json([
                'success' => true,
            ], 200);
        }else if($method == 'update'){
            JenisStandarMutu::find($id)->update([
                'daftar_standar_mutu_id' => $daftar_standar_mutu_id,
                'jenis_standar_mutu' => $jenis_standar_mutu,
                'data_dukung' => $data_dukung,
                'keterangan' => $keterangan,
                'jenis_indikator' => $jenis_indikator,
                'bobot_nilai' => $bobot_nilai,
                'target_nilai' => $target_nilai,
                'updated_at' => Carbon::now()
            ]);
            
            return response()->json([
                'success' => true,
            ], 200);
        }
    }

    public function edit($id)
    {
        $data = JenisStandarMutu::where('id', $id)->first();
        return response()->json([
            'data' => $data,
        ]);
    }

    // public function destroy($id)
    // {
    //     JenisStandarMutu::find($id)->delete();
        
    //     return response()->json([
    //         'success' => true,
    //     ], 200);
    // }

}
