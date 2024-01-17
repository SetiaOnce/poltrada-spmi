<?php

namespace App\Http\Controllers\Backend\Rules\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataSdm;
use Carbon\Carbon;
use Hamcrest\Core\AllOf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;

use function PHPUnit\Framework\isNull;

class DataSdmController extends Controller
{
    protected $base = 'rules.admin.masterisasi.data_sdm.';
    
    public function index()
    {   
        return view($this->base.'index');
    }
    
    public function ajaxdatasdm(Request $request)
    {
        if ($request->ajax()) {
            $data = DataSdm::all();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('foto', function($row) {
                        return '<img src="'.$row->dataFoto.'" alt="avatar-4" class="rounded avatar-md">';
                    })
                    ->rawColumns(['foto'])
                    ->make(true);
        }
    }

    public function AjaxDatasdmSinkron()
    {
        date_default_timezone_set("Asia/Jakarta");

        $response = Http::withOptions(['verify'=>false])
        ->post('https://kepegawaian.ptdisttd.ac.id/api/cekPegawai', [
            'username' => 'esurat-api',
            'password' => '123456',
        ]);

        $data_sdm = json_decode($response, true);
        
        foreach($data_sdm['data'] as $row){
            $find_data = DataSdm::where('dataEmail', $row['dataEmail'])->first(['dataEmail']);
            if(!empty($find_data)){
                DataSdm::where('dataEmail', $row['dataEmail'])->update([
                    'dataNik' => $row['dataNik'],
                    'dataNama' => $row['dataNama'],
                    'dataAlamat' => $row['dataAlamat'],
                    'dataEmail' => $row['dataEmail'],
                    'dataJenisKelamin' => $row['dataJenisKelamin'],
                    'dataTanggalLahir' => $row['dataTanggalLahir'],
                    'dataStatusKepegawaian' => $row['dataStatusKepegawaian'],
                    'dataNidnNupNidk' => $row['dataNidnNupNidk'],
                    'dataBidang' => $row['dataBidang'],
                    'dataKepangkatan' => $row['dataKepangkatan'],
                    'dataPin' => $row['dataPin'],
                    'dataTelepon' => $row['dataTelepon'],
                    'dataFoto' => $row['dataFoto'],
                    'updated_at' => Carbon::now()
                ]);
            }else{
                DataSdm::create([
                    'dataNik' => $row['dataNik'],
                    'dataNama' => $row['dataNama'],
                    'dataAlamat' => $row['dataAlamat'],
                    'dataEmail' => $row['dataEmail'],
                    'dataJenisKelamin' => $row['dataJenisKelamin'],
                    'dataTanggalLahir' => $row['dataTanggalLahir'],
                    'dataStatusKepegawaian' => $row['dataStatusKepegawaian'],
                    'dataNidnNupNidk' => $row['dataNidnNupNidk'],
                    'dataBidang' => $row['dataBidang'],
                    'dataKepangkatan' => $row['dataKepangkatan'],
                    'dataPin' => $row['dataPin'],
                    'dataTelepon' => $row['dataTelepon'],
                    'dataFoto' => $row['dataFoto'],
                    'created_at' => Carbon::now()
                ]);
            }
        }
        
        return response()->json([
            'success' => true,
        ], 200);
    }
}
