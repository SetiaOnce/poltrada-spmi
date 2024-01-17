<?php

namespace App\Http\Controllers\Backend\Rules\Pengelola;

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
    protected $base = 'rules.pengelola.manajemen_mutu.periode_evaluasi.';
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Custom search filter 
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
                    "spm_data_lembaga_akreditasi.nama_lembaga",
                )
                ->join("spm_periode_evaluasi", "spm_jenis_standar_mutu.id", "=", "spm_periode_evaluasi.jenis_standar_mutu_id")
                ->join("spm_daftar_standar_mutu", "spm_daftar_standar_mutu.id", "=", "spm_jenis_standar_mutu.daftar_standar_mutu_id")
                ->join("spm_data_lembaga_akreditasi", "spm_data_lembaga_akreditasi.id", "=", "spm_daftar_standar_mutu.lembaga_akreditasi_id")
                ->orderBy('spm_periode_evaluasi.created_at', 'DESC')
                ->where('spm_daftar_standar_mutu.tahun', $filter_tahun)
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
                    "spm_data_lembaga_akreditasi.nama_lembaga",
                )
                ->join("spm_periode_evaluasi", "spm_jenis_standar_mutu.id", "=", "spm_periode_evaluasi.jenis_standar_mutu_id")
                ->join("spm_daftar_standar_mutu", "spm_daftar_standar_mutu.id", "=", "spm_jenis_standar_mutu.daftar_standar_mutu_id")
                ->join("spm_data_lembaga_akreditasi", "spm_data_lembaga_akreditasi.id", "=", "spm_daftar_standar_mutu.lembaga_akreditasi_id")
                ->orderBy('spm_periode_evaluasi.created_at', 'DESC')
                ->get();
            }
            
           
            return DataTables::of($data)
                    ->addIndexColumn()       
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" onclick="_editData('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-info btn-circle mb-1" data-bs-original-title="Edit Data" title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip">
                           <span class="mdi mdi-pencil-box-multiple"></span></a>';

                           $btn = $btn.'<a href="'.route('data.asesor.index', $row->id).'" class="waves-effect waves-light btn btn-sm btn-success btn-circle" data-bs-original-title="Manajemen Data Asesor" title="Manajemen Data Asesor" data-bs-placement="top" data-bs-toggle="tooltip"><span class="fas fa-plus"></span></a>';
                           
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
        
        $data['data_jenis_standar_mutu'] = JenisStandarMutu::select(
            'spm_jenis_standar_mutu.id',
            'spm_jenis_standar_mutu.jenis_standar_mutu',
            'spm_data_lembaga_akreditasi.nama_lembaga',
        )
        ->join("spm_daftar_standar_mutu", "spm_daftar_standar_mutu.id", "=", "spm_jenis_standar_mutu.daftar_standar_mutu_id")
        ->join("spm_data_lembaga_akreditasi", "spm_data_lembaga_akreditasi.id", "=", "spm_daftar_standar_mutu.lembaga_akreditasi_id")
        ->orderBy('spm_jenis_standar_mutu.jenis_standar_mutu', 'ASC')
        ->get();
        // $data['data_jenis_standar_mutu'] = JenisStandarMutu::orderBy('jenis_standar_mutu', 'ASC')->get();
        
        return view($this->base.'index', $data);
    }

    public function filterTahun(Request $request, $tahun){
        if ($request->ajax()) {
            $data = JenisStandarMutu::select(
                "periode_evaluasi.id",
                DB::raw('DATE_FORMAT(periode_evaluasi.priode_evaluasi_diri_awal, "%d-%M-%Y") as periode_awal'),
                DB::raw('DATE_FORMAT(periode_evaluasi.priode_evaluasi_diri_akhir, "%d-%M-%Y") as periode_akhir'),
                DB::raw('DATE_FORMAT(periode_evaluasi.priode_visitasi_awal, "%d-%M-%Y") as visitasi_awal'),
                DB::raw('DATE_FORMAT(periode_evaluasi.priode_visitasi_akhir, "%d-%M-%Y") as visitasi_akhir'),
                "periode_evaluasi.created_at",
                "jenis_standar_mutu.jenis_standar_mutu as jenis_standar",
                "daftar_standar_mutu.tahun",
                "data_lembaga_akreditasi.nama_lembaga",
            )
            ->join("periode_evaluasi", "jenis_standar_mutu.id", "=", "periode_evaluasi.jenis_standar_mutu_id")
            ->join("daftar_standar_mutu", "daftar_standar_mutu.id", "=", "jenis_standar_mutu.daftar_standar_mutu_id")
            ->join("data_lembaga_akreditasi", "data_lembaga_akreditasi.id", "=", "daftar_standar_mutu.lembaga_akreditasi_id")
            ->orderBy('periode_evaluasi.created_at', 'DESC')
            ->where('daftar_standar_mutu.tahun', $tahun)
            ->get();
            return DataTables::of($data)
                    ->addIndexColumn()       
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" onclick="_editData('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-info btn-circle mb-1" data-bs-original-title="Edit Data" title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip">
                           <span class="mdi mdi-pencil-box-multiple"></span></a>';

                           $btn = $btn.'<a href="'.route('data.asesor.index', $row->id).'" class="waves-effect waves-light btn btn-sm btn-success btn-circle" data-bs-original-title="Manajemen Data Asesor" title="Manajemen Data Asesor" data-bs-placement="top" data-bs-toggle="tooltip"><span class="fas fa-plus"></span></a>';
                           
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }

    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $id      = $request->input('id');
        $method      = $request->input('methodform_data');

        $jenis_standar_mutu_id      = $request->input('jenis_standar_mutu_id');
        $priode_evaluasi_diri_awal      = $request->input('priode_evaluasi_diri_awal');
        $priode_evaluasi_diri_akhir      = $request->input('priode_evaluasi_diri_akhir');
        $priode_visitasi_awal      = $request->input('priode_visitasi_awal');
        $priode_visitasi_akhir      = $request->input('priode_visitasi_akhir');

        if($method == 'add'){
            PeriodeEvaluasi::create([
                'jenis_standar_mutu_id' => $jenis_standar_mutu_id,
                'priode_evaluasi_diri_awal' => $priode_evaluasi_diri_awal,
                'priode_evaluasi_diri_akhir' => $priode_evaluasi_diri_akhir,
                'priode_visitasi_awal' => $priode_visitasi_awal,
                'priode_visitasi_akhir' => $priode_visitasi_akhir,
                'created_at' => Carbon::now()
            ]);
            
            return response()->json([
                'success' => true,
            ], 200);
        }else if($method == 'update'){
            PeriodeEvaluasi::find($id)->update([
                'jenis_standar_mutu_id' => $jenis_standar_mutu_id,
                'priode_evaluasi_diri_awal' => $priode_evaluasi_diri_awal,
                'priode_evaluasi_diri_akhir' => $priode_evaluasi_diri_akhir,
                'priode_visitasi_awal' => $priode_visitasi_awal,
                'priode_visitasi_akhir' => $priode_visitasi_akhir,
                'updated_at' => Carbon::now()
            ]);
            
            return response()->json([
                'success' => true,
            ], 200);
        }

    }

    public function edit($id)
    {
        $data = PeriodeEvaluasi::find($id);
        return response()->json([
            'data' => $data,
        ]);
    }

    public function destroy($id)
    {
        PeriodeEvaluasi::find($id)->delete();
        
        return response()->json([
            'success' => true,
        ], 200);
    }
}
