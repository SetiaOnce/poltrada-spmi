<?php

namespace App\Http\Controllers\Backend\Rules\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\DaftarRekomendasi;
use App\Models\DaftarTemuan;
use App\Models\DataJenisSurvey;
use App\Models\DokumenPendukung;
use App\Models\Inbox;
use App\Models\LaporanAkhir;
use App\Models\PengajuanAudit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PengajuanAuditController extends Controller
{
    protected $base = 'rules.pengelola.pengajuan_audit.';
    
    public function index(Request $request)
    {   
        if ($request->ajax()) {
            $filter_tahun = $request->get('filter_tahun');
            if(!empty($filter_tahun)){
                $data = PengajuanAudit::select(
                    "spm_pengajuan_audit.id",
                    "spm_pengajuan_audit.tgl_input",
                    "spm_pengajuan_audit.status_pengajuan",
                    "spm_jenis_standar_mutu.jenis_standar_mutu as jenis_standar",
                    "group_unit_kerja.unit_kerja",
                    "spm_daftar_standar_mutu.tahun",
                    "spm_data_lembaga_akreditasi.nama_lembaga",
                )
                ->join("spm_jenis_standar_mutu", "spm_jenis_standar_mutu.id", "=", "spm_pengajuan_audit.jenis_standar_mutu_id")
                ->join("spm_daftar_standar_mutu", "spm_daftar_standar_mutu.id", "=", "spm_jenis_standar_mutu.daftar_standar_mutu_id")
                ->join("spm_data_lembaga_akreditasi", "spm_data_lembaga_akreditasi.id", "=", "spm_daftar_standar_mutu.lembaga_akreditasi_id")
                ->join("spm_periode_evaluasi", "spm_periode_evaluasi.id", "=", "spm_pengajuan_audit.priode_evaluasi_id")
                ->join("group_pegawai", "group_pegawai.id", "=", "spm_pengajuan_audit.user_id")
                ->join("group_unit_kerja", "group_unit_kerja.id", "=", "group_pegawai.unit_kerja_id")
                ->where('spm_daftar_standar_mutu.tahun', $filter_tahun)
                ->whereIn('spm_pengajuan_audit.status_pengajuan', [1, 2])
                ->orderBy('spm_pengajuan_audit.id', 'DESC')
                ->get();
            }else{
                $data = PengajuanAudit::select(
                    "spm_pengajuan_audit.id",
                    "spm_pengajuan_audit.tgl_input",
                    "spm_pengajuan_audit.status_pengajuan",
                    "spm_jenis_standar_mutu.jenis_standar_mutu as jenis_standar",
                    "group_unit_kerja.unit_kerja",
                    "spm_daftar_standar_mutu.tahun",
                    "spm_data_lembaga_akreditasi.nama_lembaga",
                )
                ->join("spm_jenis_standar_mutu", "spm_jenis_standar_mutu.id", "=", "spm_pengajuan_audit.jenis_standar_mutu_id")
                ->join("spm_daftar_standar_mutu", "spm_daftar_standar_mutu.id", "=", "spm_jenis_standar_mutu.daftar_standar_mutu_id")
                ->join("spm_data_lembaga_akreditasi", "spm_data_lembaga_akreditasi.id", "=", "spm_daftar_standar_mutu.lembaga_akreditasi_id")
                ->join("spm_periode_evaluasi", "spm_periode_evaluasi.id", "=", "spm_pengajuan_audit.priode_evaluasi_id")
                ->join("group_pegawai", "group_pegawai.id", "=", "spm_pengajuan_audit.user_id")
                ->join("group_unit_kerja", "group_unit_kerja.id", "=", "group_pegawai.unit_kerja_id")
                ->whereIn('spm_pengajuan_audit.status_pengajuan', [1, 2])
                ->orderBy('spm_pengajuan_audit.id', 'DESC')
                ->get();
            }
            return DataTables::of($data)
                    ->addIndexColumn()  
                    ->addColumn('unit_prodi', function($row){
                        return $row->unit_kerja;
                    })
                    ->editColumn('status', function($row) {
                        if($row->status_pengajuan == 0){
                         $status = '<span class="badge bg-warning">BELUM DIAJUKAN</span>';
                        }else if($row->status_pengajuan == 1){
                            $status = '<span class="badge bg-info">DALAM PROSES PENGAJUAN</span>';
                        }elseif($row->status_pengajuan == 2){
                            $status = '<span class="badge bg-success">SUDAH SELESAI</span>';
                        }
                        return $status;
                     })    
                    ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0);" onclick="_detailPengajuan('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-success btn-circle me-1" data-bs-original-title="Lihat Detail Pengajuan" title="Lihat Detail Pengajuan" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-file-document-multiple"></span></a>';

                        $btn = $btn.'<a href="javascript:void(0);" onclick="_laporanAkhir('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-info btn-circle me-1" data-bs-original-title="Laporan Akhir" title="Laporan Akhir" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-eyedropper-plus"></span></a>';

                        return $btn;
                    })
                    ->rawColumns(['action', 'unit_prodi', 'status'])
                    ->make(true);
        }

        $data['data_jenis_survey'] = DataJenisSurvey::orderBy('nama_jenis_survey','ASC')->get(['nama_jenis_survey', 'id']);
        
        return view($this->base.'index', $data);
    }

    public function ajaxGetDataPendukung($id)
    {
        $pengajuan_audit = PengajuanAudit::select(
            "spm_pengajuan_audit.id",
            "spm_pengajuan_audit.tgl_input",
            "group_pegawai.nama as name",
            "group_unit_kerja.unit_kerja",
            "spm_jenis_standar_mutu.jenis_standar_mutu",
            "spm_daftar_standar_mutu.tahun",
            "spm_data_lembaga_akreditasi.nama_lembaga",
            "spm_periode_evaluasi.priode_evaluasi_diri_awal",
            "spm_periode_evaluasi.priode_evaluasi_diri_akhir",
        )
        ->join("group_pegawai", "group_pegawai.id", "=", "spm_pengajuan_audit.user_id")
        ->join("group_unit_kerja", "group_unit_kerja.id", "=", "group_pegawai.unit_kerja_id")
        ->join("spm_jenis_standar_mutu", "spm_jenis_standar_mutu.id", "=", "spm_pengajuan_audit.jenis_standar_mutu_id")
        ->join("spm_periode_evaluasi", "spm_jenis_standar_mutu.id", "=", "spm_periode_evaluasi.jenis_standar_mutu_id")
        ->join("spm_daftar_standar_mutu", "spm_daftar_standar_mutu.id", "=", "spm_jenis_standar_mutu.daftar_standar_mutu_id")
        ->join("spm_data_lembaga_akreditasi", "spm_data_lembaga_akreditasi.id", "=", "spm_daftar_standar_mutu.lembaga_akreditasi_id")
        ->where('spm_pengajuan_audit.id', $id)
        ->first();

        $unit_prodi = $pengajuan_audit->unit_kerja;

        $data['data_pendukung'] = DokumenPendukung::latest()->where('pengajuan_id', $id)->get();

        $data['data_asesor'] = PengajuanAudit::select(
            'group_pegawai.nama as name'
        )
        ->join("spm_periode_evaluasi", "spm_periode_evaluasi.id", "=", "spm_pengajuan_audit.priode_evaluasi_id")
        ->join("spm_data_asesor", "spm_data_asesor.priode_evaluasi_id", "=", "spm_periode_evaluasi.id")
        ->join("group_pegawai", "group_pegawai.id", "=", "spm_data_asesor.asesor_id")
        ->where('spm_pengajuan_audit.id', $id)
        ->get();

        $data['data_temuan'] = DaftarTemuan::select(
            "group_pegawai.nama as name",
            "spm_daftar_temuan.temuan",
        )
        ->join("spm_pengajuan_audit", "spm_pengajuan_audit.id", "=", "spm_daftar_temuan.pengajuan_id")
        ->join("group_pegawai", "group_pegawai.id", "=", "spm_daftar_temuan.asesor_id")
        ->where('spm_pengajuan_audit.id', $id)
        ->orderBy('spm_daftar_temuan.id', 'DESC')
        ->get();

        $data['data_rekomendasi'] = DaftarRekomendasi::select(
            "group_pegawai.nama as name",
            "spm_daftar_rekomendasi.rekomendasi",
            "spm_daftar_rekomendasi.tanggal_akhir",
        )
        ->join("spm_pengajuan_audit", "spm_pengajuan_audit.id", "=", "spm_daftar_rekomendasi.pengajuan_id")
        ->join("group_pegawai", "group_pegawai.id", "=", "spm_daftar_rekomendasi.asesor_id")
        ->where('spm_pengajuan_audit.id', $id)
        ->orderBy('spm_daftar_rekomendasi.id', 'DESC')
        ->get();

        $data['laporan_akhir'] = LaporanAkhir::where('pengajuan_id', $id)->first();

        return response()->json([
            'unit_prodi' => $unit_prodi,
            'tahun' => $pengajuan_audit->tahun,
            'jenis_standar' => $pengajuan_audit->jenis_standar_mutu,
            'nama_lembaga' => $pengajuan_audit->nama_lembaga,
            'priode_awal' => $pengajuan_audit->priode_evaluasi_diri_awal,
            'priode_akhir' => $pengajuan_audit->priode_evaluasi_diri_akhir,
            'tgl_input' => $pengajuan_audit->tgl_input,
            'data' => $data['data_pendukung'],
            'asesor' => $data['data_asesor'],
            'temuan' => $data['data_temuan'],
            'rekomendasi' => $data['data_rekomendasi'],
            'laporan_akhir' => $data['laporan_akhir'],
        ], 200);
    }

    public function ajaxGetDaftarTemuan($id)
    {
        $pengajuan_audit = PengajuanAudit::select(
            "pengajuan_audit.id",
            "pengajuan_audit.tgl_input",
            "users.name",
            "data_unit_prodi.jenjang",
            "data_unit_prodi.nama_unit_prodi",
            "jenis_standar_mutu.jenis_standar_mutu",
            "daftar_standar_mutu.tahun",
            "data_lembaga_akreditasi.nama_lembaga",
        )
        ->join("users", "users.id", "=", "pengajuan_audit.user_id")
        ->join("data_unit_prodi", "data_unit_prodi.id", "=", "users.unit_prodi_id")
        ->join("jenis_standar_mutu", "jenis_standar_mutu.id", "=", "pengajuan_audit.jenis_standar_mutu_id")
        ->join("daftar_standar_mutu", "daftar_standar_mutu.id", "=", "jenis_standar_mutu.daftar_standar_mutu_id")
        ->join("data_lembaga_akreditasi", "data_lembaga_akreditasi.id", "=", "daftar_standar_mutu.lembaga_akreditasi_id")
        ->where('pengajuan_audit.id', $id)
        ->first();

        $unit_prodi = $pengajuan_audit->jenjang.' | '.$pengajuan_audit->nama_unit_prodi;

        $daftar_temuan = DaftarTemuan::where('asesor_id', Auth::user()->id)->where('pengajuan_id', $id)->first();
        
        return response()->json([
            'unit_prodi' => $unit_prodi,
            'tahun' => $pengajuan_audit->tahun,
            'jenis_standar' => $pengajuan_audit->jenis_standar_mutu,
            'nama_lembaga' => $pengajuan_audit->nama_lembaga,
            'tgl_input' => $pengajuan_audit->tgl_input,
            'pengajuan_id' => $pengajuan_audit->id,
            'asesor_id' => Auth::user()->id,
            'daftar_temuan' => $daftar_temuan
        ], 200);

    }
}
