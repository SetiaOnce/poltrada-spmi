<?php

namespace App\Http\Controllers\Backend\Rules\Asesor;

use App\Http\Controllers\Controller;
use App\Models\DaftarRekomendasi;
use App\Models\DaftarTemuan;
use App\Models\DokumenPendukung;
use App\Models\LaporanAkhir;
use App\Models\PengajuanAudit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class EvaluasiPengajuanAuditController extends Controller
{
    protected $base = 'rules.asesor.evaluasi_pengajuan_audit.';
    
    public function index(Request $request)
    {
        $id = session()->get('pegawaiId');        
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
                ->join("spm_data_asesor", "spm_data_asesor.priode_evaluasi_id", "=", "spm_periode_evaluasi.id")
                ->join("group_pegawai", "group_pegawai.id", "=", "spm_pengajuan_audit.user_id")
                ->join("group_unit_kerja", "group_unit_kerja.id", "=", "group_pegawai.unit_kerja_id")
                ->where('spm_data_asesor.asesor_id', $id)
                ->where("spm_daftar_standar_mutu.tahun", $filter_tahun)
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
                ->join("spm_data_asesor", "spm_data_asesor.priode_evaluasi_id", "=", "spm_periode_evaluasi.id")
                ->join("group_pegawai", "group_pegawai.id", "=", "spm_pengajuan_audit.user_id")
                ->join("group_unit_kerja", "group_unit_kerja.id", "=", "group_pegawai.unit_kerja_id")
                ->where('spm_data_asesor.asesor_id', $id)
                ->whereIn('spm_pengajuan_audit.status_pengajuan', [1, 2])
                ->orderBy('spm_pengajuan_audit.id', 'DESC')
                ->get();
            }
            return DataTables::of($data)
                    ->addIndexColumn()  
                    ->addColumn('unit_prodi', function($row){
                        return $row->unit_kerja;
                    })
                    ->addColumn('action', function($row){
                        if($row->status_pengajuan == 2){
                            $btn = '<a href="javascript:void(0);" onclick="_detailPengajuan('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-success btn-circle me-1" data-bs-original-title="Lihat Detail Pengajuan" title="Lihat Detail Pengajuan" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-file-document-multiple"></span></a>';
                        }else{
                            $btn = '<a href="javascript:void(0);" onclick="_detailPengajuan('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-success btn-circle me-1" data-bs-original-title="Lihat Detail Pengajuan" title="Lihat Detail Pengajuan" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-file-document-multiple"></span></a>';

                            $btn = $btn.'<a href="javascript:void(0);" onclick="_daftarTemuan('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-info btn-circle me-1" data-bs-original-title="Daftar Temuan" title="Daftar Temuan" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-circle-edit-outline"></span></a>';
    
                            $btn = $btn.'<a href="javascript:void(0);" onclick="_rekomendasi('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-secondary btn-circle me-1" data-bs-original-title="Rekomendasi" title="Rekomendasi" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-account-edit"></span></a>';
                        }

                        return $btn;
                    })
                    ->rawColumns(['action', 'unit_prodi'])
                    ->make(true);
        }

        return view($this->base.'index');
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
            'tgl_input' => $pengajuan_audit->tgl_input,
            'priode_awal' => $pengajuan_audit->priode_evaluasi_diri_awal,
            'priode_akhir' => $pengajuan_audit->priode_evaluasi_diri_akhir,
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

        $daftar_temuan = DaftarTemuan::where('asesor_id', session()->get('pegawaiId'))->where('pengajuan_id', $id)->first();
        
        return response()->json([
            'unit_prodi' => $unit_prodi,
            'tahun' => $pengajuan_audit->tahun,
            'jenis_standar' => $pengajuan_audit->jenis_standar_mutu,
            'nama_lembaga' => $pengajuan_audit->nama_lembaga,
            'priode_awal' => $pengajuan_audit->priode_evaluasi_diri_awal,
            'priode_akhir' => $pengajuan_audit->priode_evaluasi_diri_akhir,
            'tgl_input' => $pengajuan_audit->tgl_input,
            'pengajuan_id' => $pengajuan_audit->id,
            'asesor_id' => session()->get('pegawaiId'),
            'daftar_temuan' => $daftar_temuan
        ], 200);

    }

    public function ajaxRekomendasi($id)
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
        
        $daftar_rekomendasi = DaftarRekomendasi::where('asesor_id', session()->get('pegawaiId'))->where('pengajuan_id', $id)->first();
        
        return response()->json([
            'unit_prodi' => $unit_prodi,
            'tahun' => $pengajuan_audit->tahun,
            'jenis_standar' => $pengajuan_audit->jenis_standar_mutu,
            'nama_lembaga' => $pengajuan_audit->nama_lembaga,
            'priode_awal' => $pengajuan_audit->priode_evaluasi_diri_awal,
            'priode_akhir' => $pengajuan_audit->priode_evaluasi_diri_akhir,
            'tgl_input' => $pengajuan_audit->tgl_input,
            'pengajuan_id' => $pengajuan_audit->id,
            'asesor_id' => session()->get('pegawaiId'),
            'daftar_rekomendasi' => $daftar_rekomendasi
        ], 200);
    }

    public function temuanStore(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $id      = $request->input('id');
        $method      = $request->input('methodform_data');
        
        $pengajuan_id      = $request->input('pengajuan_id');
        $asesor_id      = $request->input('asesor_id');
        $temuan      = $request->input('temuan');

        if($method == 'add'){
            $validasi = validator()->make($request->all(),[
                'temuan' => 'required|max:255',
            ],[
                'temuan.required' => 'Temuan tidak boleh kosong',
                'temuan.max' => 'Maksimal 255 Karakter',
            ]);

            if($validasi->fails()){
                return response()->json(['errors' => $validasi->errors()]);
            }else{
                DaftarTemuan::create([
                    'pengajuan_id' => $pengajuan_id,
                    'asesor_id' => $asesor_id,
                    'temuan' => $temuan,
                    'created_at' => Carbon::now(),
                ]);
                return response()->json([
                    'success' => true,
                ], 200);
            }
        }else if($method == 'update'){
            $validasi = validator()->make($request->all(),[
                'temuan' => 'required|max:255',
            ],[
                'temuan.required' => 'Temuan tidak boleh kosong',
                'temuan.max' => 'Maksimal 255 Karakter',
            ]);

            if($validasi->fails()){
                return response()->json(['errors' => $validasi->errors()]);
            }else{
                DaftarTemuan::find($id)->update([
                    'pengajuan_id' => $pengajuan_id,
                    'asesor_id' => $asesor_id,
                    'temuan' => $temuan,
                    'updated_at' => Carbon::now(),
                ]);
                
                return response()->json([
                    'success' => true,
                ], 200);
            }
        }

    }

    public function rekomendasiStore(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $id      = $request->input('id');
        $method      = $request->input('methodform_data');
        
        $pengajuan_id      = $request->input('rek_pengajuan_id');
        $asesor_id      = $request->input('rek_asesor_id');
        $rekomendasi      = $request->input('rekomendasi');
        $tanggal_akhir      = $request->input('tanggal_akhir');

        if($method == 'add'){
            $validasi = validator()->make($request->all(),[
                'rekomendasi' => 'required|max:255',
            ],[
                'rekomendasi.required' => 'Rekomendasi tidak boleh kosong',
                'rekomendasi.max' => 'Maksimal 255 Karakter',
            ]);

            if($validasi->fails()){
                return response()->json(['errors' => $validasi->errors()]);
            }else{
                DaftarRekomendasi::create([
                    'pengajuan_id' => $pengajuan_id,
                    'asesor_id' => $asesor_id,
                    'rekomendasi' => $rekomendasi,
                    'tanggal_akhir' => $tanggal_akhir,
                    'created_at' => Carbon::now(),
                ]);
                return response()->json([
                    'success' => true,
                ], 200);
            }
        }else if($method == 'update'){
            $validasi = validator()->make($request->all(),[
                'rekomendasi' => 'required|max:255',
            ],[
                'rekomendasi.required' => 'Rekomendasi tidak boleh kosong',
                'rekomendasi.max' => 'Maksimal 255 Karakter',
            ]);

            if($validasi->fails()){
                return response()->json(['errors' => $validasi->errors()]);
            }else{
                DaftarRekomendasi::find($id)->update([
                    'pengajuan_id' => $pengajuan_id,
                    'asesor_id' => $asesor_id,
                    'rekomendasi' => $rekomendasi,
                    'tanggal_akhir' => $tanggal_akhir,
                    'updated_at' => Carbon::now(),
                ]);
                
                return response()->json([
                    'success' => true,
                ], 200);
            }
        }

    }
    
    public function temuanEdit($id){
        $data = DaftarTemuan::find($id);
        return response()->json([
            'data' => $data,
        ]);
    }

    public function rekomendasiEdit($id){
        $data = DaftarRekomendasi::find($id);
        return response()->json([
            'data' => $data,
        ]);
    }

}
