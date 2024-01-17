<?php

namespace App\Http\Controllers\Backend\Rules\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\LaporanAkhir;
use App\Models\PengajuanAudit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanAkhirController extends Controller
{
    public function index($id)
    {
        $laporan_akhir = LaporanAkhir::where('pengajuan_id', $id)->first();
        return response()->json([
            'laporan_akhir' => $laporan_akhir,
        ], 200);
    }

    public function store(Request $request){
        date_default_timezone_set("Asia/Jakarta");
        
        $id      = $request->input('id');
        $method      = $request->input('methodform_data');
        $pengajuan_id      = $request->input('pengajuan_id');

        $tanggal_pembahasan      = $request->input('tanggal_pembahasan');
        $resume_pembahasan      = $request->input('resume_pembahasan');
        $file_pembahasan      = $request->file('file_pembahasan');

        if($method == 'add'){
            $validasi = validator()->make($request->all(),[
                'file_pembahasan' => 'required|mimes:pdf|max:2048',
            ],[
                'file_pembahasan.required' => 'File Pembahasan tidak boleh kosong',
                'file_pembahasan.mimes' => 'File Pembahasan harus berekstensi pdf',
                'file_pembahasan.max' => 'Max File Pembahasan pdf 2mb',
            ]);

            if($validasi->fails()){
                return response()->json(['errors' => $validasi->errors()]);
            }else{
                $name_gen = hexdec(uniqid()).'laporan-akhir.'.$file_pembahasan->getClientOriginalExtension();
                $file_pembahasan->move(public_path('pdf/laporan-akhir/'), $name_gen);
                $save_url = 'pdf/laporan-akhir/'.$name_gen;

                LaporanAkhir::create([
                    'pengajuan_id' => $pengajuan_id,
                    'tgl_pembahasan' => $tanggal_pembahasan,
                    'resume_pembahasan' => $resume_pembahasan,
                    'file_pembahasan' => $save_url,
                    'created_at' => Carbon::now()
                ]);

                PengajuanAudit::where('id', $pengajuan_id)->update([
                    'status_pengajuan' => 2,
                    'updated_at' => Carbon::now(),
                ]);
                
                return response()->json([
                    'success' => true,
                ], 200);
            }
        }else if($method == 'update'){
            if($request->file('file_pembahasan')){
                $validasi = validator()->make($request->all(),[
                    'file_pembahasan' => 'mimes:pdf|max:2048',
                ],[
                    'file_pembahasan.mimes' => 'File Pembahasan harus berekstensi pdf',
                    'file_pembahasan.max' => 'Max File Pembahasan pdf 2mb',
                ]);
    
                if($validasi->fails()){
                    return response()->json(['errors' => $validasi->errors()]);
                }else{
                    $name_gen = hexdec(uniqid()).'laporan-akhir.'.$file_pembahasan->getClientOriginalExtension();
                    $file_pembahasan->move(public_path('pdf/laporan-akhir/'), $name_gen);
                    $save_url = 'pdf/laporan-akhir/'.$name_gen;
                    @unlink(public_path(LaporanAkhir::find($id)->file_pembahasan));
                    LaporanAkhir::find($id)->update([
                        'file_pembahasan' => $save_url,
                    ]);
                
                }
            }
            
            LaporanAkhir::find($id)->update([
                'pengajuan_id' => $pengajuan_id,
                'tgl_pembahasan' => $tanggal_pembahasan,
                'resume_pembahasan' => $resume_pembahasan,
                'updated_at' => Carbon::now()
            ]);

            PengajuanAudit::where('id', $pengajuan_id)->update([
                'status_pengajuan' => 2,
                'updated_at' => Carbon::now(),
            ]);
            
            return response()->json([
                'success' => true,
            ], 200);
        }
    }
}
