<?php

namespace App\Http\Controllers\Backend\Rules\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\JenisStandarMutu;
use App\Models\NamaStandarMutu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NamaStandarMutuController extends Controller
{
    protected $base = 'rules.pengelola.manajemen_mutu.standar_mutu.list.';
    
    public function index(Request $request, $id)
    {
        // dd($id);
        // menampilkan nama standar mutu ke dalam table berdasarkan jenis standar mutu yang di pilih
        if ($request->ajax()) {
            $data = NamaStandarMutu::select(
                "nama_standar_mutu.id",
                "nama_standar_mutu.nama_standar_mutu",
                "nama_standar_mutu.bobot_nilai",
                "jenis_standar_mutu.jenis_standar_mutu as jenis",
                "data_lembaga_akreditasi.nama_lembaga as lembaga",
            )
            ->join("data_lembaga_akreditasi", "data_lembaga_akreditasi.id", "=", "nama_standar_mutu.lembaga_akreditasi_id")
            ->join("jenis_standar_mutu", "jenis_standar_mutu.id", "=", "nama_standar_mutu.jenis_standar_mutu_id")
            ->where('nama_standar_mutu.jenis_standar_mutu_id', $id)
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
        $data['jenis_standar_mutu'] = JenisStandarMutu::select(
            "jenis_standar_mutu.id",
            "jenis_standar_mutu.tahun",
            "jenis_standar_mutu.jenis_standar_mutu",
            "jenis_standar_mutu.lembaga_akreditasi_id",
            "jenis_standar_mutu.unit_prodi_id",
            "data_lembaga_akreditasi.nama_lembaga as lembaga",
            "data_unit_prodi.nama_unit_prodi as prodi",
        )
        ->join("data_lembaga_akreditasi", "data_lembaga_akreditasi.id", "=", "jenis_standar_mutu.lembaga_akreditasi_id")
        ->join("data_unit_prodi", "data_unit_prodi.id", "=", "jenis_standar_mutu.unit_prodi_id")
        ->where('jenis_standar_mutu.id', $id)
        ->first();
        
        return view($this->base.'nama_standar_mutu', $data);
    }

    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $id      = $request->input('id');
        $method      = $request->input('methodform_data');

        $jenis_standar_mutu_id      = $request->input('jenis_standar_mutu_id');
        $tahun      = $request->input('tahun');
        $lembaga_akreditasi_id      = $request->input('lembaga_akreditasi_id');
        $unit_prodi_id      = $request->input('unit_prodi_id');
        $nama_standar_mutu      = $request->input('nama_standar_mutu');
        $data_dukung      = $request->input('data_dukung');
        $keterangan      = $request->input('keterangan');
        $jenis_indikator      = $request->input('jenis_indikator');
        $bobot_nilai      = $request->input('bobot_nilai');

        if($method == 'add'){
            NamaStandarMutu::create([
                'jenis_standar_mutu_id' => $jenis_standar_mutu_id,
                'tahun' => $tahun,
                'lembaga_akreditasi_id' => $lembaga_akreditasi_id,
                'unit_prodi_id' => $unit_prodi_id,
                'nama_standar_mutu' => $nama_standar_mutu,
                'data_dukung' => $data_dukung,
                'keterangan' => $keterangan,
                'jenis_indikator' => $jenis_indikator,
                'bobot_nilai' => $bobot_nilai,
                'created_at' => Carbon::now()
            ]);
            
            return response()->json([
                'success' => true,
            ], 200);
        }else if($method == 'update'){
            NamaStandarMutu::find($id)->update([
                'jenis_standar_mutu_id' => $jenis_standar_mutu_id,
                'tahun' => $tahun,
                'lembaga_akreditasi_id' => $lembaga_akreditasi_id,
                'unit_prodi_id' => $unit_prodi_id,
                'nama_standar_mutu' => $nama_standar_mutu,
                'data_dukung' => $data_dukung,
                'keterangan' => $keterangan,
                'jenis_indikator' => $jenis_indikator,
                'bobot_nilai' => $bobot_nilai,
                'updated_at' => Carbon::now()
            ]);
            
            return response()->json([
                'success' => true,
            ], 200);
        }
    }

    public function edit($id)
    {
        $data = NamaStandarMutu::where('id', $id)->first();
        return response()->json([
            'data' => $data,
        ]);
    }

    public function destroy($id)
    {

    }

}