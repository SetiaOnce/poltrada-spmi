<?php

namespace App\Http\Controllers\Backend\Rules\Asesor;

use App\Http\Controllers\Controller;
use App\Models\DaftarStandarMutu;
use App\Models\DataLembagaAkreditasi;
use App\Models\DataUnitProdi;
use App\Models\GroupUnitKerja;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TargetNilaiMutuController extends Controller
{
    protected $base = 'rules.asesor.target_nilai_mutu.';
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $filter_tahun = $request->get('filter_tahun');
            if(!empty($filter_tahun)){
                $data = DaftarStandarMutu::select(
                    "spm_daftar_standar_mutu.nama_standar",
                    "spm_daftar_standar_mutu.tahun",
                    "spm_data_lembaga_akreditasi.nama_lembaga",
                    "group_unit_kerja.unit_kerja as prodi",
                    "spm_jenis_standar_mutu.jenis_standar_mutu",
                    "spm_jenis_standar_mutu.bobot_nilai",
                    "spm_jenis_standar_mutu.target_nilai",
                )
                ->join("spm_jenis_standar_mutu", "spm_daftar_standar_mutu.id", "=", "spm_jenis_standar_mutu.daftar_standar_mutu_id")
                ->join("spm_data_lembaga_akreditasi", "spm_data_lembaga_akreditasi.id", "=", "spm_daftar_standar_mutu.lembaga_akreditasi_id")
                ->join("group_unit_kerja", "group_unit_kerja.id", "=", "spm_daftar_standar_mutu.unit_prodi_id")
                ->where("spm_daftar_standar_mutu.tahun", $filter_tahun)
                ->orderBy('spm_data_lembaga_akreditasi.nama_lembaga', 'ASC')
                ->get();
            }else{
                $data = DaftarStandarMutu::select(
                    "spm_daftar_standar_mutu.nama_standar",
                    "spm_daftar_standar_mutu.tahun",
                    "spm_data_lembaga_akreditasi.nama_lembaga",
                    "group_unit_kerja.unit_kerja as prodi",
                    "spm_jenis_standar_mutu.jenis_standar_mutu",
                    "spm_jenis_standar_mutu.bobot_nilai",
                    "spm_jenis_standar_mutu.target_nilai",
                )
                ->join("spm_jenis_standar_mutu", "spm_daftar_standar_mutu.id", "=", "spm_jenis_standar_mutu.daftar_standar_mutu_id")
                ->join("spm_data_lembaga_akreditasi", "spm_data_lembaga_akreditasi.id", "=", "spm_daftar_standar_mutu.lembaga_akreditasi_id")
                ->join("group_unit_kerja", "group_unit_kerja.id", "=", "spm_daftar_standar_mutu.unit_prodi_id")
                ->orderBy('spm_data_lembaga_akreditasi.nama_lembaga', 'ASC')
                ->get();
            }
            return DataTables::of($data)
                        ->addIndexColumn()
                        ->make(true);
        }

        $data['data_lembaga_akreditasi'] = DataLembagaAkreditasi::orderBy('nama_lembaga', 'ASC')->get(['id','nama_lembaga']);
        $data['data_unit_prodi'] = GroupUnitKerja::orderBy('unit_kerja', 'ASC')->get(['id', 'unit_kerja']);
        
        return view($this->base.'index', $data);
    }

}
