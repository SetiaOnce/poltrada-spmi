<?php

namespace App\Http\Controllers\Backend\Rules\Prodi;

use App\Http\Controllers\Controller;
use App\Models\DataLembagaAkreditasi;
use App\Models\JenisStandarMutu;
use App\Models\PeriodeEvaluasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PeriodeEvaluasiController extends Controller
{
    protected $base = 'rules.prodi.periode_evaluasi.';
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $filter_tahun = $request->get('filter_tahun');
            if(!empty($filter_tahun)){
                $data = JenisStandarMutu::select(
                    "spm_periode_evaluasi.id",
                    DB::raw('DATE_FORMAT(spm_periode_evaluasi.priode_evaluasi_diri_awal, "%d-%M-%Y") as periode_awal'),
                    DB::raw('DATE_FORMAT(spm_periode_evaluasi.priode_evaluasi_diri_akhir, "%d-%M-%Y") as periode_akhir'),
                    DB::raw('DATE_FORMAT(spm_periode_evaluasi.priode_visitasi_awal, "%d-%M-%Y") as visitasi_awal'),
                    DB::raw('DATE_FORMAT(spm_periode_evaluasi.priode_visitasi_akhir, "%d-%M-%Y") as visitasi_akhir'),
                    "spm_periode_evaluasi.created_at",
                    "spm_jenis_standar_mutu.jenis_standar_mutu as jenis_standar",
                    "spm_daftar_standar_mutu.tahun",
                    "spm_daftar_standar_mutu.nama_standar",
                    "spm_data_lembaga_akreditasi.nama_lembaga",
                )
                ->join("spm_periode_evaluasi", "spm_jenis_standar_mutu.id", "=", "spm_periode_evaluasi.jenis_standar_mutu_id")
                ->join("spm_daftar_standar_mutu", "spm_daftar_standar_mutu.id", "=", "spm_jenis_standar_mutu.daftar_standar_mutu_id")
                ->join("spm_data_lembaga_akreditasi", "spm_data_lembaga_akreditasi.id", "=", "spm_daftar_standar_mutu.lembaga_akreditasi_id")
                ->where("spm_daftar_standar_mutu.tahun", $filter_tahun)
                ->orderBy('spm_data_lembaga_akreditasi.nama_lembaga', 'ASC')
                ->get();
            }else{
                $data = JenisStandarMutu::select(
                    "spm_periode_evaluasi.id",
                    DB::raw('DATE_FORMAT(spm_periode_evaluasi.priode_evaluasi_diri_awal, "%d-%M-%Y") as periode_awal'),
                    DB::raw('DATE_FORMAT(spm_periode_evaluasi.priode_evaluasi_diri_akhir, "%d-%M-%Y") as periode_akhir'),
                    DB::raw('DATE_FORMAT(spm_periode_evaluasi.priode_visitasi_awal, "%d-%M-%Y") as visitasi_awal'),
                    DB::raw('DATE_FORMAT(spm_periode_evaluasi.priode_visitasi_akhir, "%d-%M-%Y") as visitasi_akhir'),
                    "spm_periode_evaluasi.created_at",
                    "spm_jenis_standar_mutu.jenis_standar_mutu as jenis_standar",
                    "spm_daftar_standar_mutu.tahun",
                    "spm_daftar_standar_mutu.nama_standar",
                    "spm_data_lembaga_akreditasi.nama_lembaga",
                )
                ->join("spm_periode_evaluasi", "spm_jenis_standar_mutu.id", "=", "spm_periode_evaluasi.jenis_standar_mutu_id")
                ->join("spm_daftar_standar_mutu", "spm_daftar_standar_mutu.id", "=", "spm_jenis_standar_mutu.daftar_standar_mutu_id")
                ->join("spm_data_lembaga_akreditasi", "spm_data_lembaga_akreditasi.id", "=", "spm_daftar_standar_mutu.lembaga_akreditasi_id")
                ->orderBy('spm_data_lembaga_akreditasi.nama_lembaga', 'ASC')
                ->get();
            }
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0);" onclick="_lihatAsesor('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-success btn-circle me-1" data-bs-original-title="Lihat Auditor" title="Lihat Auditor" data-bs-placement="top" data-bs-toggle="tooltip">Auditor</a>';

                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        $data['data_jenis_standar_mutu'] = JenisStandarMutu::orderBy('jenis_standar_mutu', 'ASC')->get();
        
        return view($this->base.'index', $data);
    }

    public function ajaxDetailAsesor($id)
    {
        $data =  PeriodeEvaluasi::select(
            "spm_periode_evaluasi.id",
            "spm_data_asesor.priode_evaluasi_id",
            "group_pegawai.nama as name",
        )
        ->join("spm_data_asesor", "spm_periode_evaluasi.id", "=", "spm_data_asesor.priode_evaluasi_id")
        ->join("group_pegawai", "group_pegawai.id", "=", "spm_data_asesor.asesor_id")
        ->where('spm_data_asesor.priode_evaluasi_id', $id)
        ->get();
        
        $title =  PeriodeEvaluasi::select(
            "spm_periode_evaluasi.id",
            "spm_jenis_standar_mutu.jenis_standar_mutu as jenis_standar",
            "spm_daftar_standar_mutu.tahun",
            "spm_data_lembaga_akreditasi.nama_lembaga",
        )
        ->join("spm_jenis_standar_mutu", "spm_jenis_standar_mutu.id", "=", "spm_periode_evaluasi.jenis_standar_mutu_id")
        ->join("spm_daftar_standar_mutu", "spm_daftar_standar_mutu.id", "=", "spm_jenis_standar_mutu.daftar_standar_mutu_id")
        ->join("spm_data_lembaga_akreditasi", "spm_data_lembaga_akreditasi.id", "=", "spm_daftar_standar_mutu.lembaga_akreditasi_id")
        ->where('spm_periode_evaluasi.id', $id)
        ->first();
        
        return response()->json([
            'title' => $title,
            'data' => $data
        ], 200);
    }
}
