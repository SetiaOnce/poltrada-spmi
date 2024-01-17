<?php

namespace App\Http\Controllers\Backend\Rules\Pengelola;

use App\Http\Controllers\Controller;
use App\Models\DataJenisAkreditasi;
use App\Models\ManajemenKegiatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;

class ManajemenDataKegiatanController extends Controller
{
    protected $base = 'rules.pengelola.manajemen_data.kegiatan.';
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ManajemenKegiatan::select(
                "spm_kegiatan.id",
                "spm_kegiatan.judul_kegiatan",
                "spm_kegiatan.deskripsi_kegiatan",
                "spm_kegiatan.foto_kegiatan",
                "spm_kegiatan.status",
                "spm_data_jenis_akreditasi.nama_jenis_akreditasi as jenis_akreditasi",
            )
            ->join("spm_data_jenis_akreditasi", "spm_data_jenis_akreditasi.id", "=", "spm_kegiatan.jenis_akreditasi_id")
            ->orderBy('spm_kegiatan.created_at' , 'DESC')
            ->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('foto', function($row) {
                        return '<a class="image-popup-vertical-fit" href="'.asset(($row->foto_kegiatan)).'"  data-bs-original-title="Lihat Foto" data-bs-placement="top" data-bs-toggle="tooltip" target="_blank">
                        <img src="'.asset(($row->foto_kegiatan)).'" alt="avatar-4" class="avatar-md" width="140">
                    </a>';
                    })
                    ->addColumn('status', function($row){
                        if($row->status == 1){
                            return '<input onclick="editStatus('.$row->id.')" type="checkbox" id="switch'.$row->id.'" switch="none" checked mute readonly/>
                            <label for="switch'.$row->id.'" data-on-label="On" data-off-label="Off" data-bs-original-title="Ubah Status" title="Ubah Status" data-bs-placement="top" data-bs-toggle="tooltip"></label>';
                           }else{
                            return '<input onclick="editStatus('.$row->id.')" type="checkbox" id="switch'.$row->id.'" switch="none" mute readonly/>
                            <label for="switch'.$row->id.'" data-on-label="On" data-off-label="Off" data-bs-original-title="Ubah Status" title="Ubah Status" data-bs-placement="top" data-bs-toggle="tooltip"></label>';
                        }
                    })
                    ->addColumn('action', function($row){
                            $btn = '<a href="javascript:void(0)" onclick="_editData('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-info btn-circle me-1" data-bs-original-title="Edit Data" title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip">
                            <span class="mdi mdi-pencil-box-multiple"></span></a>';
    
                            $btn = $btn.' <a onclick="_deleteData('.$row->id.')" href="javascript:void(0)" class="waves-effect waves-light btn btn-sm btn-danger btn-circle me-1" data-bs-original-title="Hapus Data" title="Hapus Data" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-trash-can-outline"></span></a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action', 'status', 'foto'])
                    ->make(true);
        }
        
        $data['jenis_akreditasi'] = DataJenisAkreditasi::latest()->get(['id', 'nama_jenis_akreditasi']);
        
        return view($this->base.'index', $data);
    }

    public function ubahStatus($id)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $data = ManajemenKegiatan::find($id);

        if($data['status'] == 1){
            ManajemenKegiatan::find($id)->update([
                'status' => 0,
                'updated_at' => Carbon::now()
            ]);
        }else if($data['status'] == 0){
            ManajemenKegiatan::find($id)->update([
                'status' => 1,
                'updated_at' => Carbon::now()
            ]);
        }
        
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $id      = $request->input('id');
        $method      = $request->input('methodform_data');

        $jenis_kegiatan_id      = $request->input('jenis_kegiatan_id');
        $judul_kegiatan      = $request->input('judul_kegiatan');
        $deskripsi_kegiatan      = $request->input('deskripsi_kegiatan');
        $foto_kegiatan      = $request->file('foto_kegiatan');

        if($method == 'add'){
            $validasi = validator()->make($request->all(),[
                'foto_kegiatan' => 'required|mimes:jpg,jpeg,png|max:1048',
            ],[
                'foto_kegiatan.required' => 'Foto Kegiatan tidak boleh kosong',
                'foto_kegiatan.mimes' => 'File berekstensi jpg,jpeg,png',
                'foto_kegiatan.max' => 'Max file Foto Kegiatan 1mb',
            ]);

            if($validasi->fails()){
                return response()->json(['errors' => $validasi->errors()]);
            }else{
                $name_gen = hexdec(uniqid()).'.'.$foto_kegiatan->getClientOriginalExtension();
                Image::make($foto_kegiatan)->resize(1080,1080)->save('img/kegiatan/'.$name_gen);
                $save_url = 'img/kegiatan/'.$name_gen;

                ManajemenKegiatan::create([
                    'jenis_kegiatan_id' => $jenis_kegiatan_id,
                    'judul_kegiatan' => $judul_kegiatan,
                    'deskripsi_kegiatan' => $deskripsi_kegiatan,
                    'foto_kegiatan' => $save_url,
                    'created_at' => Carbon::now()
                ]);
                
                return response()->json([
                    'success' => true,
                ], 200);
            }
        }else if($method == 'update'){
            if($request->file('foto_kegiatan')){
                $validasi = validator()->make($request->all(),[
                    'foto_kegiatan' => 'required|mimes:jpg,jpeg,png|max:1048',
                ],[
                    'foto_kegiatan.required' => 'Foto Kegiatan tidak boleh kosong',
                    'foto_kegiatan.mimes' => 'File berekstensi jpg,jpeg,png',
                    'foto_kegiatan.max' => 'Max file Foto Kegiatan 1mb',
                ]);
    
                if($validasi->fails()){
                    return response()->json(['errors' => $validasi->errors()]);
                }else{
                    @unlink(public_path(ManajemenKegiatan::find($id)->foto_kegiatan));
                    $name_gen = hexdec(uniqid()).'.'.$foto_kegiatan->getClientOriginalExtension();
                    Image::make($foto_kegiatan)->resize(1080,1080)->save('img/kegiatan/'.$name_gen);
                    $save_url = 'img/kegiatan/'.$name_gen;

                    ManajemenKegiatan::find($id)->update([
                        'foto_kegiatan' => $save_url,
                    ]);
                
                }
            }
            
            ManajemenKegiatan::find($id)->update([
                'jenis_kegiatan_id' => $jenis_kegiatan_id,
                'judul_kegiatan' => $judul_kegiatan,
                'deskripsi_kegiatan' => $deskripsi_kegiatan,
                'updated_at' => Carbon::now()
            ]);
            
            return response()->json([
                'success' => true,
            ], 200);
        }
    }

    public function edit($id)
    {
        $data = ManajemenKegiatan::find($id);
        return response()->json([
            'data' => $data,
        ]);
    }

    public function destroy($id)
    {
        ManajemenKegiatan::find($id)->delete();
        @unlink(public_path(ManajemenKegiatan::find($id)->foto_kegiatan));
        return response()->json([
            'success' => true,
        ], 200);
    }

}
