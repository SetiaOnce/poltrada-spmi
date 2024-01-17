<?php

namespace App\Http\Controllers\Backend\Rules\Prodi;

use App\Http\Controllers\Controller;
use App\Models\DaftarRekomendasi;
use App\Models\DaftarTemuan;
use App\Models\DokumenPendukung;
use App\Models\GroupPegawai;
use App\Models\Inbox;
use App\Models\LaporanAkhir;
use App\Models\PengajuanAudit;
use App\Models\PeriodeEvaluasi;
use App\Models\SsoAkses;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PengajuanAuditController extends Controller
{
    protected $base = 'rules.prodi.pengajuan_audit.';
    
    public function index(Request $request)
    {   
        $id = session()->get('pegawaiId');
        if ($request->ajax()) {
            $data = PengajuanAudit::select(
                "spm_pengajuan_audit.id",
                "spm_pengajuan_audit.tgl_input",
                "spm_pengajuan_audit.status_pengajuan",
                "spm_jenis_standar_mutu.jenis_standar_mutu as jenis_standar",
                "spm_daftar_standar_mutu.tahun",
                "spm_data_lembaga_akreditasi.nama_lembaga",
            )
            ->join("spm_jenis_standar_mutu", "spm_jenis_standar_mutu.id", "=", "spm_pengajuan_audit.jenis_standar_mutu_id")
            ->join("spm_daftar_standar_mutu", "spm_daftar_standar_mutu.id", "=", "spm_jenis_standar_mutu.daftar_standar_mutu_id")
            ->join("spm_data_lembaga_akreditasi", "spm_data_lembaga_akreditasi.id", "=", "spm_daftar_standar_mutu.lembaga_akreditasi_id")
            ->where('spm_pengajuan_audit.user_id', $id)
            ->orderBy('spm_pengajuan_audit.id', 'DESC')
            ->get();
            return DataTables::of($data)
                    ->addIndexColumn()
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
                        if($row->status_pengajuan == 0){
                            $btn = '<a href="javascript:void(0)" onclick="_editData('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-info btn-circle me-1" data-bs-original-title="Edit Data" title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip">
                            <span class="mdi mdi-pencil-box-multiple"></span></a>';
    
                            $btn = $btn.'<a href="javascript:void(0);" onclick="_dataPendukung('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-success btn-circle" data-bs-original-title="Tambah Dokumen Pendukung" title="Tambah Dokumen Pendukung" data-bs-placement="top" data-bs-toggle="tooltip"><span class="fas fa-plus"></span></a>';
                        }elseif($row->status_pengajuan == 1){
                            $btn = '<a href="javascript:void(0);" onclick="_dataPendukung('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-success btn-circle" data-bs-original-title="Tambah Dokumen Pendukung" title="Tambah Dokumen Pendukung" data-bs-placement="top" data-bs-toggle="tooltip"><span class="fas fa-plus"></span></a>';
                        }else{
                            $btn = '';
                        }

                        return $btn;
                    })
                    ->addColumn('ajukan', function($row){
                        if($row->status_pengajuan == 0){
                            $btn = '<a href="javascript:void(0)" onclick="_ajukanData('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-success btn-circle" data-bs-original-title="Ajukan Data" title="Ajukan Data" data-bs-placement="top" data-bs-toggle="tooltip">Ajukan</a>';
                        }else{
                            $btn = '<a href="javascript:void(0);" onclick="_detailPengajuan('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-success btn-circle me-1" data-bs-original-title="Lihat Detail Pengajuan" title="Lihat Detail Pengajuan" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-file-document-multiple"></span></a>';
                        }
                        
                        return $btn;
                    })
                    ->rawColumns(['action', 'status', 'ajukan'])
                    ->make(true);
        }

        $data['data_priode_evaluasi'] = PeriodeEvaluasi::select(
            "spm_periode_evaluasi.id",
            "spm_daftar_standar_mutu.tahun",
            "spm_jenis_standar_mutu.jenis_standar_mutu as jenis_standar",
            "spm_data_lembaga_akreditasi.nama_lembaga",
        )
        ->join("spm_jenis_standar_mutu", "spm_jenis_standar_mutu.id", "=", "spm_periode_evaluasi.jenis_standar_mutu_id")
        ->join("spm_daftar_standar_mutu", "spm_daftar_standar_mutu.id", "=", "spm_jenis_standar_mutu.daftar_standar_mutu_id")
        ->join("spm_data_lembaga_akreditasi", "spm_data_lembaga_akreditasi.id", "=", "spm_daftar_standar_mutu.lembaga_akreditasi_id")
        ->get();

        $data['unit_prodi'] = GroupPegawai::select(
            "group_pegawai.id as pegawaiId",
            "group_unit_kerja.*",
        )
        ->join("group_unit_kerja", "group_unit_kerja.id", "=", "group_pegawai.unit_kerja_id")
        ->where('group_pegawai.id', session()->get('pegawaiId'))
        ->first();

        return view($this->base.'index', $data);
    }

    public function ajaxgetStandarMutu($id)
    {
        $data['data_standar_mutu'] = PeriodeEvaluasi::select(
                    "spm_jenis_standar_mutu.id",
                    "spm_jenis_standar_mutu.jenis_standar_mutu",
                    "spm_jenis_standar_mutu.data_dukung",
                )
                ->join("spm_jenis_standar_mutu", "spm_jenis_standar_mutu.id", "=", "spm_periode_evaluasi.jenis_standar_mutu_id")
                ->where('spm_periode_evaluasi.id', $id)
                ->first();

        $data['data_asesor'] = PeriodeEvaluasi::select(
            "spm_data_asesor.asesor_id",
            "group_pegawai.nama as name",
        )
        ->join("spm_data_asesor", "spm_data_asesor.priode_evaluasi_id", "=", "spm_periode_evaluasi.id")
        ->join("group_pegawai", "group_pegawai.id", "=", "spm_data_asesor.asesor_id")
        ->where('spm_periode_evaluasi.id', $id)
        ->get();
        
        return response()->json([
            'data' => $data['data_standar_mutu'],
            'asesor' => $data['data_asesor']
        ], 200);
    }

    public function ajaxAjukanAudit($id)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        PengajuanAudit::where('id', $id)->update([
            'status_pengajuan' => 1,
            'updated_at' => Carbon::now(),
        ]);
        $pengajuan_audit = PengajuanAudit::where('id', $id)->first();
        $data['data_asesor'] = PengajuanAudit::select(
            "spm_pengajuan_audit.id as pengajuan_id",
            "spm_pengajuan_audit.unit_prodi",
            "spm_data_asesor.asesor_id",
        )
        ->join("spm_periode_evaluasi", "spm_pengajuan_audit.priode_evaluasi_id", "=", "spm_periode_evaluasi.id")
        ->join("spm_data_asesor", "spm_periode_evaluasi.id", "=", "spm_data_asesor.priode_evaluasi_id")
        ->join("group_pegawai", "group_pegawai.id", "=", "spm_data_asesor.asesor_id")
        ->where('spm_pengajuan_audit.id', $id)
        ->get();

        $data['data_pengelola']  = SsoAkses::select('group_pegawai.id', 'group_pegawai.nama')
        ->join('group_pegawai', 'group_pegawai.id', '=', 'sso_akses.pegawai_id')
        ->orderBy('group_pegawai.nama', 'ASC')
        ->where('sso_akses.aplikasi_id', 23)
        ->where('sso_akses.level_id', 31)
        ->get();

        foreach($data['data_pengelola'] as $pengelola){
            Inbox::create([
                'unit_prodi_id' => $pengajuan_audit->unit_prodi,
                'pengajuan_id' => $pengajuan_audit->id,
                'user_id' => $pengelola->id,
                'created_at' => Carbon::now(),
            ]);
        }

        foreach($data['data_asesor'] as $pengajuan){
            Inbox::create([
                'unit_prodi_id' => $pengajuan->unit_prodi,
                'pengajuan_id' => $pengajuan->pengajuan_id,
                'user_id' => $pengajuan->asesor_id,
                'created_at' => Carbon::now(),
            ]);
        }
        
        return response()->json([
            'success' => true
        ], 200);
    }

    public function AjaxdetailPengajuan($id)
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

        $data['data_pendukung'] = DokumenPendukung::latest()->where('pengajuan_id', $id)->get();

        return response()->json([
            'unit_prodi' => $unit_prodi,
            'tahun' => $pengajuan_audit->tahun,
            'jenis_standar' => $pengajuan_audit->jenis_standar_mutu,
            'nama_lembaga' => $pengajuan_audit->nama_lembaga,
            'priode_awal' => $pengajuan_audit->priode_evaluasi_diri_awal,
            'priode_akhir' => $pengajuan_audit->priode_evaluasi_diri_akhir,
            'tgl_input' => $pengajuan_audit->tgl_input,
            'asesor' => $data['data_asesor'],
            'temuan' => $data['data_temuan'],
            'rekomendasi' => $data['data_rekomendasi'],
            'laporan_akhir' => $data['laporan_akhir'],
            'data' =>  $data['data_pendukung'],
        ], 200);
    }

    public function AjaxGetDataPendukung(Request $request, $id)
    {
        $pengajuan_audit = PengajuanAudit::select(
            "spm_jenis_standar_mutu.id",
            "spm_jenis_standar_mutu.jenis_standar_mutu",
        )
        ->join("spm_jenis_standar_mutu", "spm_jenis_standar_mutu.id", "=", "spm_pengajuan_audit.jenis_standar_mutu_id")
        ->where('spm_pengajuan_audit.id', $id)
        ->first();

        $data = DokumenPendukung::latest()->where('pengajuan_id', $id)->get();

        return response()->json([
            'title' => $pengajuan_audit,
            'data' => $data
        ], 200);
    }

    public function DokumenPendukung(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $pengajuan_id      = $request->input('pengajuan_id');
        $nama_dokumen      = $request->input('nama_dokumen');
        $file_permohonan      = $request->file('file_permohonan');

        $validasi = validator()->make($request->all(),[
            'file_permohonan' => 'required|mimes:pdf|max:3048',
        ],[
            'file_permohonan.required' => 'File Pendukung tidak boleh kosong',
            'file_permohonan.mimes' => 'File Pendukung berekstensi pdf',
            'file_permohonan.max' => 'Max File Pendukung 3mb',
        ]);

        if($validasi->fails()){
            return response()->json(['errors' => $validasi->errors()]);
        }else{
            $name_gen = hexdec(uniqid()).'pendukung.'.$file_permohonan->getClientOriginalExtension();
            $file_permohonan->move(public_path('pdf/file_pendukung/'), $name_gen);
            $save_url = 'pdf/file_pendukung/'.$name_gen;

            DokumenPendukung::create([
                'pengajuan_id' => $pengajuan_id,
                'nama_dokumen' => $nama_dokumen,
                'file_permohonan' => $save_url,
                'created_at' => Carbon::now()
            ]);
            
            return response()->json([
                'success' => true,
            ], 200);
        }
    }

    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $id      = $request->input('id');
        $method      = $request->input('methodform_data');

        $priode_evaluasi_id      = $request->input('priode_evaluasi_id');
        $jenis_standar_mutu_id      = $request->input('jenis_standar_mutu_id');
        $unit_prodi      = $request->input('unit_prodi');
        $user_id      = $request->input('user_id');
        $tgl_input      = $request->input('tgl_input');
        
        if($method == 'add'){
            $cek_pengajuan = PengajuanAudit::where('priode_evaluasi_id', $priode_evaluasi_id)->where('user_id', $user_id)->first();
            if(!empty($cek_pengajuan->priode_evaluasi_id)){
                return response()->json([
                    'already' => true
                ], 200);
            }
            PengajuanAudit::create([
                'priode_evaluasi_id' => $priode_evaluasi_id,          
                'jenis_standar_mutu_id' => $jenis_standar_mutu_id,          
                'unit_prodi' => $unit_prodi,        
                'user_id' => $user_id,        
                'tgl_input' => $tgl_input,          
                'created_at' => Carbon::now(),          
            ]);
            
            return response()->json([
                'success' => true
            ], 200);

        }else if($method == 'update'){

            PengajuanAudit::find($id)->update([
                'priode_evaluasi_id' => $priode_evaluasi_id,          
                'jenis_standar_mutu_id' => $jenis_standar_mutu_id,          
                'unit_prodi' => $unit_prodi,
                'user_id' => $user_id,   
                'tgl_input' => $tgl_input,          
                'updated_at' => Carbon::now(),          
            ]);

            return response()->json([
                'success' => true
            ], 200);
        }
    }
    public function edit($id)
    {
        $data = PengajuanAudit::select(
            "spm_pengajuan_audit.id",
            "spm_pengajuan_audit.priode_evaluasi_id",
            "spm_pengajuan_audit.tgl_input",
            "spm_jenis_standar_mutu.id as jenis_standar_mutu_id",
            "spm_jenis_standar_mutu.jenis_standar_mutu",
            "spm_jenis_standar_mutu.data_dukung",
            "group_pegawai.id as user_id",
            "group_pegawai.nama as name",
            "group_unit_kerja.unit_kerja",
        )
        ->join("spm_jenis_standar_mutu", "spm_jenis_standar_mutu.id", "=", "spm_pengajuan_audit.jenis_standar_mutu_id")
        ->join("group_pegawai", "group_pegawai.id", "=", "spm_pengajuan_audit.user_id")
        ->join("group_unit_kerja", "group_unit_kerja.id", "=", "group_pegawai.unit_kerja_id")
        ->where('spm_pengajuan_audit.id', $id)
        ->first();

        $asesor = PengajuanAudit::select(
            "group_pegawai.nama as name",
        )
        ->join("spm_periode_evaluasi", "spm_periode_evaluasi.id", "=", "spm_pengajuan_audit.priode_evaluasi_id")
        ->join("spm_data_asesor", "spm_data_asesor.priode_evaluasi_id", "=", "spm_periode_evaluasi.id")
        ->join("group_pegawai", "group_pegawai.id", "=", "spm_data_asesor.asesor_id")
        ->where('spm_pengajuan_audit.id', $id)
        ->get();
        
        return response()->json([
            'data' => $data,
            'asesor' => $asesor
        ]);
    }

    public function destroy($id)
    {
        $data = DokumenPendukung::find($id);
        @unlink(public_path($data->file_permohonan));
        $data->delete();
        return response()->json([
            'success' => true,
        ], 200);
    }
}
