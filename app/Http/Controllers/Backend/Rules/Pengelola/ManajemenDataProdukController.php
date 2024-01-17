<?php

namespace App\Http\Controllers\Backend\Rules\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\DataJenisProduk;
use App\Models\ManajemenProduk;
use App\Models\SubJenisProduk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;
use Barryvdh\DomPDF\PDF;

class ManajemenDataProdukController extends Controller
{
    protected $base = 'rules.pengelola.manajemen_data.produk.';
    
    public function index(Request $request)
    {        
        if ($request->ajax()) {
            $data = ManajemenProduk::select(
                "spm_produk.id",
                "spm_produk.nama_produk",
                "spm_produk.file_pdf",
                "spm_data_jenis_produk.nama_jenis_produk as jenis_produk",
                "spm_sub_jenis_produk.sub_jenis_produk",
            )
            ->join("spm_data_jenis_produk", "spm_data_jenis_produk.id", "=", "spm_produk.jenis_produk_id")
            ->join("spm_sub_jenis_produk", "spm_sub_jenis_produk.id", "=", "spm_produk.sub_jenis_produk_id")
            ->orderBy('spm_produk.created_at', 'DESC')
            ->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('pdf', function($row) {
                        return '<a href="'.asset(($row->file_pdf)).'" data-bs-original-title="Lihat File Pdf" data-bs-placement="top" data-bs-toggle="tooltip" target="_blank">
                        <img src="'.asset(('img/pdf-image.jpg')).'" alt="avatar-4" class=" avatar-md">
                        </a>';
                    })         
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" onclick="_editData('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-info btn-circle me-1" data-bs-original-title="Edit Data" title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip">
                           <span class="mdi mdi-pencil-box-multiple"></span></a>';
   
                           $btn = $btn.' <a onclick="_deleteData('.$row->id.')" href="javascript:void(0)" class="waves-effect waves-light btn btn-sm btn-danger btn-circle" data-bs-original-title="Hapus Data" title="Hapus Data" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-trash-can-outline"></span></a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action', 'pdf'])
                    ->make(true);
        }
        
        $data['jenis_produk'] = DataJenisProduk::latest()->get(['id', 'nama_jenis_produk']);
        
        return view($this->base.'index', $data);
    }

    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $id      = $request->input('id');
        $method      = $request->input('methodform_data');

        $jenis_produk_id      = $request->input('jenis_produk_id');
        $nama_produk      = $request->input('nama_produk');
        $sub_jenis_produk_id      = $request->input('sub_jenis_produk_id');
        $file_pdf      = $request->file('file_pdf');

        if($method == 'add'){
            $validasi = validator()->make($request->all(),[
                'file_pdf' => 'required|mimes:pdf|max:2048',
            ],[
                'file_pdf.required' => 'File Pdf tidak boleh kosong',
                'file_pdf.mimes' => 'File berekstensi pdf',
                'file_pdf.max' => 'Max file pdf 2mb',
            ]);

            if($validasi->fails()){
                return response()->json(['errors' => $validasi->errors()]);
            }else{
                $name_gen = hexdec(uniqid()).'produk.'.$file_pdf->getClientOriginalExtension();
                $file_pdf->move(public_path('pdf/produk/'), $name_gen);
                $save_url = 'pdf/produk/'.$name_gen;

                ManajemenProduk::create([
                    'jenis_produk_id' => $jenis_produk_id,
                    'sub_jenis_produk_id' => $sub_jenis_produk_id,
                    'nama_produk' => $nama_produk,
                    'file_pdf' => $save_url,
                    'created_at' => Carbon::now()
                ]);
                
                return response()->json([
                    'success' => true,
                ], 200);
            }
        }else if($method == 'update'){
            if($request->file('file_pdf')){
                $validasi = validator()->make($request->all(),[
                    'file_pdf' => 'required|mimes:pdf|max:2048',
                ],[
                    'file_pdf.required' => 'File Pdf tidak boleh kosong',
                    'file_pdf.mimes' => 'File berekstensi pdf',
                    'file_pdf.max' => 'Max file pdf 2mb',
                ]);
    
                if($validasi->fails()){
                    return response()->json(['errors' => $validasi->errors()]);
                }else{
                    @unlink(public_path(ManajemenProduk::find($id)->file_pdf));
                    $name_gen = hexdec(uniqid()).'produk.'.$file_pdf->getClientOriginalExtension();
                    $file_pdf->move(public_path('pdf/produk/'), $name_gen);
                    $save_url = 'pdf/produk/'.$name_gen;
    
                    ManajemenProduk::find($id)->update([
                        'file_pdf' => $save_url,
                    ]);
                
                }
            }
            
            ManajemenProduk::find($id)->update([
                'jenis_produk_id' => $jenis_produk_id,
                'sub_jenis_produk_id' => $sub_jenis_produk_id,
                'nama_produk' => $nama_produk,
                'updated_at' => Carbon::now()
            ]);
            
            return response()->json([
                'success' => true,
                'banner' => $method,
            ], 200);
        }
    
    }

    public function GetSubJenisProduk($id){
        $data = SubJenisProduk::orderBy('sub_jenis_produk', 'ASC')->where('jenis_produk_id', $id)->get();
        return response()->json([
            'data' => $data,
        ]);
    }

    public function edit($id)
    {
        $data = ManajemenProduk::find($id);
        return response()->json([
            'data' => $data,
        ]);
    }

    public function destroy($id)
    {
        ManajemenProduk::find($id)->delete();
        @unlink(public_path(ManajemenProduk::find($id)->file_pdf));
        return response()->json([
            'success' => true,
        ], 200);
    }
}
