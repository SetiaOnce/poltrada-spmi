<?php

namespace App\Http\Controllers\Backend\Rules\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\AkademikProdi;
use App\Models\StatusAkreditasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StatusAkreditasiController extends Controller
{
    protected $base = 'rules.pengelola.manajemen_data.status_akreditasi.';
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = StatusAkreditasi::select(
                "spm_status_akreditasi.*",
                "akademik_prodi.nama_prodi",
            )
            ->join("akademik_prodi", "akademik_prodi.id", "=", "spm_status_akreditasi.fid_program_studi")
            ->orderBy('spm_status_akreditasi.id', 'DESC')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('Unit_prodi', function($row) {
                    return $row->prodi->nama_prodi;
                }) 
                ->editColumn('tanggal_kedaluarsa', function($row) {
                    return date('d-m-Y', strtotime($row->tanggal_kedaluarsa));
                }) 
                ->editColumn('pdf', function($row) {
                    return '<a href="'.asset('pdf/data-akreditasi/'.$row->file_sertifikat).'" data-bs-original-title="Lihat File Sertifikat" data-bs-placement="top" data-bs-toggle="tooltip" target="_blank">
                        <img src="'.asset(('img/pdf-image.jpg')).'" alt="avatar-4" class=" avatar-md">
                    </a>';
                }) 
                ->addColumn('action', function($row){
                        $btn = '<a href="javascript:void(0)" onclick="_editData('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-info btn-circle mb-1" data-bs-original-title="Edit Data" title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip">
                        <span class="mdi mdi-pencil-box-multiple"></span></a>';
                        $btn = $btn.' <a onclick="_deleteData('.$row->id.')" href="javascript:void(0)" class="waves-effect waves-light btn btn-sm btn-danger btn-circle" data-bs-original-title="Hapus Data" title="Hapus Data" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-trash-can-outline"></span></a>';
                        return $btn;
                })
                ->rawColumns(['action', 'pdf', 'Unit_prodi'])
                ->make(true);
        }

        $data['dt_unitProdi'] = AkademikProdi::orderBy('id', 'DESC')->get();
        
        return view($this->base.'index', $data);
    }
    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Makassar");
        
        $id      = $request->input('id');
        $method      = $request->input('methodform_data');

        if($method == 'add'){
            $validasi = validator()->make($request->all(),[
                'fid_program_studi' => 'required',
                'program' => 'required|max:50',
                'status_peringkat' => 'required|max:50',
                'tahun_sk' => 'required|max:4',
                'tanggal_kedaluarsa' => 'required',
                'file_sertifikat' => 'required|mimes:pdf|max:3048',
            ],[
                'fid_program_studi.required' => 'Program studi tidak boleh kosong',
                'program.required' => 'Program tidak boleh kosong',
                'program.required' => 'Program maksimal 50 karakter',
                'status_peringkat.required' => 'Status peringkat tidak boleh kosong',
                'status_peringkat.required' => 'Status peringkat maksimal 50 karakter',
                'tahun_sk.required' => 'Tahun SK tidak boleh kosong',
                'tahun_sk.required' => 'Tahun SK maksimal 4 digit',
                'tanggal_kedaluarsa.required' => 'Tanggal kedaluarsa tidak boleh kosong',
                'file_sertifikat.required' => 'File sertifikat tidak boleh kosong',
                'file_sertifikat.mimes' => 'File sertifikat berekstensi pdf',
                'file_sertifikat.max' => 'File sertifikat maksimal 3MB',
            ]);

            if($validasi->fails()){
                return response()->json(['errors' => $validasi->errors()]);
            }else{
                // save file sertifikat to derectory
                $FileName = hexdec(uniqid()).'filesertifikat.'.$request->file('file_sertifikat')->getClientOriginalExtension();
                $request->file('file_sertifikat')->move(public_path('pdf/data-akreditasi/'), $FileName);
                // parse date tanggal kedaluarsa
                $tglKedaluarsa=Carbon::createFromFormat('d/m/Y', $request->input('tanggal_kedaluarsa'))->format('Y-m-d'); 
                // save input to table
                StatusAkreditasi::create([
                    'fid_program_studi' => $request->fid_program_studi,
                    'program' => $request->program,
                    'status_peringkat' => $request->status_peringkat,
                    'tahun_sk' => $request->tahun_sk,
                    'tanggal_kedaluarsa' => $tglKedaluarsa,
                    'file_sertifikat' => $FileName,
                    'created_at' => Carbon::now()
                ]);
                return response()->json(['success' => true], 200);
            }
        }else if($method == 'update'){
            $validasi = validator()->make($request->all(),[
                'fid_program_studi' => 'required',
                'program' => 'required|max:50',
                'status_peringkat' => 'required|max:50',
                'tahun_sk' => 'required|max:4',
                'tanggal_kedaluarsa' => 'required',
            ],[
                'fid_program_studi.required' => 'Program studi tidak boleh kosong',
                'program.required' => 'Program tidak boleh kosong',
                'program.required' => 'Program maksimal 50 karakter',
                'status_peringkat.required' => 'Status peringkat tidak boleh kosong',
                'status_peringkat.required' => 'Status peringkat maksimal 50 karakter',
                'tahun_sk.required' => 'Tahun SK tidak boleh kosong',
                'tahun_sk.required' => 'Tahun SK maksimal 4 digit',
                'tanggal_kedaluarsa.required' => 'Tanggal kedaluarsa tidak boleh kosong',
            ]);
            if($validasi->fails()){
                return response()->json(['errors' => $validasi->errors()]);
            }else{
                if($request->file('file_sertifikat')){
                    $validasi = validator()->make($request->all(),[
                        'file_sertifikat' => 'required|mimes:pdf|max:3048',
                    ],[
                        'file_sertifikat.required' => 'File sertifikat tidak boleh kosong',
                        'file_sertifikat.mimes' => 'File sertifikat berekstensi pdf',
                        'file_sertifikat.max' => 'File sertifikat maksimal 3MB',
                    ]);
        
                    if($validasi->fails()){
                        return response()->json(['errors' => $validasi->errors()]);
                    }else{
                       // save file sertifikat to derectory
                       $FileName = hexdec(uniqid()).'filesertifikat.'.$request->file('file_sertifikat')->getClientOriginalExtension();
                       $request->file('file_sertifikat')->move(public_path('pdf/data-akreditasi/'), $FileName);
                        StatusAkreditasi::find($id)->update([
                            'file_sertifikat' => $FileName,
                        ]);
                    }
                }
                // parse date tanggal kedaluarsa
                $tglKedaluarsa=Carbon::createFromFormat('d/m/Y', $request->input('tanggal_kedaluarsa'))->format('Y-m-d'); 
                StatusAkreditasi::find($id)->update([
                    'fid_program_studi' => $request->fid_program_studi,
                    'program' => $request->program,
                    'status_peringkat' => $request->status_peringkat,
                    'tahun_sk' => $request->tahun_sk,
                    'tanggal_kedaluarsa' => $tglKedaluarsa,
                    'updated_at' => Carbon::now()
                ]);
            }
            return response()->json(['success' => true]);
        }
    }

    public function edit($id)
    {
        $data = StatusAkreditasi::find($id);
        return response()->json([
            'row' => $data,
            'tanggal_kedaluarsa' => date('d/m/Y', strtotime($data->tanggal_kedaluarsa)),
            'url_file' => asset('pdf/data-akreditasi/'.$data->file_sertifikat)
        ]);
    }

    public function destroy($id)
    {
        StatusAkreditasi::find($id)->delete();
        return response()->json(['success' => true]);
    }

}
