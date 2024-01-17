<?php

namespace App\Http\Controllers\Backend\Rules\Prodi;

use App\Http\Controllers\Controller;
use App\Models\ManajemenKegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ManajemenDataKegiatanController extends Controller
{
    protected $base = 'rules.prodi.manajemen_data.kegiatan.';
    
    public function index(Request $request)
    {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');

        if ($request->ajax()) {
            $data = ManajemenKegiatan::select(
                "spm_kegiatan.id",
                "spm_kegiatan.judul_kegiatan",
                "spm_kegiatan.foto_kegiatan",
                "spm_data_jenis_kegiatan.nama_jenis_kegiatan as jenis_kegiatan",
            )
            ->join("spm_data_jenis_kegiatan", "spm_data_jenis_kegiatan.id", "=", "spm_kegiatan.jenis_kegiatan_id")
            ->orderBy('spm_kegiatan.created_at', 'DESC')
            ->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('foto', function($row) {
                        return '<a class="image-popup-vertical-fit" href="'.asset(($row->foto_kegiatan)).'"  data-bs-original-title="Lihat Foto" data-bs-placement="top" data-bs-toggle="tooltip" target="_blank">
                        <img src="'.asset(($row->foto_kegiatan)).'" alt="avatar-4" class="avatar-md" width="140">
                    </a>';
                    })
                    ->addColumn('action', function($row){
                            $btn = ' <button onclick="_viewData('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-success btn-circle me-1" data-bs-original-title="Lihat Data" title="Lihat Data" data-bs-placement="top" data-bs-toggle="tooltip">
                            <span class="mdi mdi-eye"></span></button>';
    
                            return $btn;
                    })
                    ->rawColumns(['action', 'foto'])
                    ->make(true);
        }

        return view($this->base.'index');
    }

    public function ajaxDetailKegiatan($id)
    {
        $data = ManajemenKegiatan::select(
            "spm_kegiatan.id",
            "spm_kegiatan.judul_kegiatan",
            "spm_kegiatan.foto_kegiatan",
            "spm_kegiatan.deskripsi_kegiatan",
            "spm_kegiatan.view",
            DB::raw('DATE_FORMAT(spm_kegiatan.created_at, "%d-%M-%Y") as waktu_kegiatan'),
            "spm_data_jenis_kegiatan.nama_jenis_kegiatan as jenis_kegiatan",
        )
        ->join("spm_data_jenis_kegiatan", "spm_data_jenis_kegiatan.id", "=", "spm_kegiatan.jenis_kegiatan_id")
        ->where('spm_kegiatan.id', $id)
        ->first();
        return response()->json([
            'data' => $data,
        ]);
    }
}
