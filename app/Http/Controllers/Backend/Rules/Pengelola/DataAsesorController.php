<?php

namespace App\Http\Controllers\Backend\Rules\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\DataAsesor;
use App\Models\PeriodeEvaluasi;
use App\Models\SsoAkses;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DataAsesorController extends Controller
{
    protected $base = 'rules.pengelola.manajemen_mutu.periode_evaluasi.asesor.';
    protected function tanggalLower($tanggal)
    {
        $arr_bln = ["Januari","Februari","Maret", "April", "Mei", "Juni","Juli","Agustus","September","Oktober", "November","Desember"];
        $cek_time = explode(' ',$tanggal);
        if($cek_time[0]){
            $bln = explode('-',$cek_time[0]);
        }else{
            $bln = explode('-',$tanggal);
        }
         return $bln[2].' '.$arr_bln[$bln[1]-1].' '.$bln[0];
        
    } 
    public function index(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = DataAsesor::select(
                "spm_data_asesor.id",
                "group_pegawai.nama",
                "spm_jenis_standar_mutu.jenis_standar_mutu as jenis_standar",
            )
            ->join("spm_jenis_standar_mutu", "spm_jenis_standar_mutu.id", "=", "spm_data_asesor.jenis_standar_mutu_id")
            ->join("group_pegawai", "group_pegawai.id", "=", "spm_data_asesor.asesor_id")
            ->where('spm_data_asesor.priode_evaluasi_id', $id)
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()       
                ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" onclick="_editData('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-info btn-circle me-1" data-bs-original-title="Edit Data" title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip">
                        <span class="mdi mdi-pencil-box-multiple"></span></a>';

                        $btn = $btn.' <a onclick="_deleteData('.$row->id.')" href="javascript:void(0)" class="waves-effect waves-light btn btn-sm btn-danger btn-circle" data-bs-original-title="Hapus Data" title="Hapus Data" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-trash-can-outline"></span></a>';
                        
                        return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        
        $data['semua_data_asesor'] = SsoAkses::select('group_pegawai.id', 'group_pegawai.nama')
                                    ->join('group_pegawai', 'group_pegawai.id', '=', 'sso_akses.pegawai_id')
                                    ->orderBy('group_pegawai.nama', 'ASC')
                                    ->where('sso_akses.aplikasi_id', 23)
                                    ->where('sso_akses.level_id', 31)
                                    ->get();
        $data['periode_evaluasi'] = PeriodeEvaluasi::select(
            "spm_periode_evaluasi.id",
            "spm_periode_evaluasi.priode_evaluasi_diri_awal as periode_awal",
            "spm_periode_evaluasi.priode_evaluasi_diri_akhir as periode_akhir",
            "spm_jenis_standar_mutu.id as jenis_standar_id",
            "spm_jenis_standar_mutu.jenis_standar_mutu",
            "spm_daftar_standar_mutu.tahun as tahun_evaluasi",
            "spm_data_lembaga_akreditasi.nama_lembaga",
        )
        ->join("spm_jenis_standar_mutu", "spm_jenis_standar_mutu.id", "=", "spm_periode_evaluasi.jenis_standar_mutu_id")
        ->join("spm_daftar_standar_mutu", "spm_daftar_standar_mutu.id", "=", "spm_jenis_standar_mutu.daftar_standar_mutu_id")
        ->join("spm_data_lembaga_akreditasi", "spm_data_lembaga_akreditasi.id", "=", "spm_daftar_standar_mutu.lembaga_akreditasi_id")
        ->where('spm_periode_evaluasi.id', $id)
        ->first();
        $data['periode_awal'] = $this->tanggalLower($data['periode_evaluasi']['periode_awal']);
        $data['periode_akhir'] = $this->tanggalLower($data['periode_evaluasi']['periode_akhir']);
        return view($this->base.'index', $data);
    }

    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $id      = $request->input('id');
        $method      = $request->input('methodform_data');

        $priode_evaluasi_id      = $request->input('priode_evaluasi_id');
        $jenis_standar_mutu_id      = $request->input('jenis_standar_mutu_id');
        $asesor_id      = $request->input('asesor_id');

        $check_asesor = DataAsesor::where('asesor_id', $asesor_id)->where('priode_evaluasi_id', $priode_evaluasi_id)->first();

        if(!empty($check_asesor->asesor_id)){
            return response()->json([
                'already' => true,
            ], 200);
        }
        
        if($method == 'add'){
            DataAsesor::create([
                'priode_evaluasi_id' => $priode_evaluasi_id,
                'jenis_standar_mutu_id' => $jenis_standar_mutu_id,
                'asesor_id' => $asesor_id,
                'created_at' => Carbon::now(),
            ]);
            return response()->json([
                'success' => true,
            ], 200);
        }else if($method == 'update'){
            DataAsesor::find($id)->update([
                'priode_evaluasi_id' => $priode_evaluasi_id,
                'jenis_standar_mutu_id' => $jenis_standar_mutu_id,
                'asesor_id' => $asesor_id,
                'updated_at' => Carbon::now(),
            ]);
            return response()->json([
                'success' => true,
            ], 200);
        }

    }

    public function edit($id)
    {
        $data = DataAsesor::where('id', $id)->first();
        return response()->json([
            'data' => $data,
        ]);
    }

    public function destroy($id)
    {
        DataAsesor::find($id)->delete();
        
        return response()->json([
            'success' => true,
        ], 200);
    }
}
