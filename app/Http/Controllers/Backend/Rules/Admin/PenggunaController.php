<?php

namespace App\Http\Controllers\Backend\Rules\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataSdm;
use App\Models\DataUnitProdi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rules;

class PenggunaController extends Controller
{
    protected $base = 'rules.admin.pengguna.';
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::orderBy('role', 'DESC')->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->editColumn('foto', function($row) {
                        return '<a class="image-popup-vertical-fit" href="'.asset(($row->dataFoto)).'" title="'.$row->name.'">
                        <img src="'.asset(($row->dataFoto)).'" alt="avatar-4" class="rounded-circle avatar-md">
                    </a>';
                    })
                    ->editColumn('role', function($row) {
                        if($row->role == 1){
                         return '<span class="badge bg-info">ADMINISTRATOR</span>';
                        }else if($row->role == 2){
                            return '<span class="badge bg-success">PENGELOLA</span>';
                        }else if($row->role == 3){
                            $q = DataUnitProdi::where('id', $row->unit_prodi_id)->first();
                            return '<span class="badge bg-primary">UNIT/PRODI</span><P class="text-grey-500" style="font-size:14px; color: #B2B2B2;">'.$q->jenjang.' <br> '.$q->nama_unit_prodi.'</P>';
                        }else if($row->role == 4){
                            return '<span class="badge bg-dark">AUDITOR</span>';
                        }
                     })               
                    ->addColumn('action', function($row){
                           $btn = '<a href="javascript:void(0)" onclick="_editData('.$row->id.')" class="waves-effect waves-light btn btn-sm btn-info btn-circle" data-bs-original-title="Edit Data" title="Edit Data" data-bs-placement="top" data-bs-toggle="tooltip">
                           <span class="mdi mdi-pencil-box-multiple"></span></a>';
   
                           $btn = $btn.' <a onclick="_deleteData('.$row->id.')" href="javascript:void(0)" class="waves-effect waves-light btn btn-sm btn-danger btn-circle" data-bs-original-title="Hapus Data" title="Hapus Data" data-bs-placement="top" data-bs-toggle="tooltip"><span class="mdi mdi-trash-can-outline"></span></a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action', 'role', 'foto'])
                    ->make(true);
        }

        $data['data_unit_prodi'] = DataUnitProdi::orderBy('jenjang', 'ASC')->get(['id', 'jenjang','nama_unit_prodi']);
        $data['data_nama_sdm'] = DataSdm::orderBy('dataNama', 'ASC')->get(['id', 'dataNama']);
        
        return view($this->base.'index', $data);
    }
    
    public function AjaxGetDataSdm($id)
    {
        $data = DataSdm::where('id', $id)->first();
        
        return response()->json([
            'success' => true,
            'data' => $data,
        ], 200);
    }

    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $id      = $request->input('id');
        $method      = $request->input('methodform_data');

        $level      = $request->input('level');
        $unit_prodi_id      = $request->input('unit_prodi_id');
        $nama_lengkap      =  DataSdm::where('id', $request->input('nama_lengkap'))->first()->dataNama;
        $email      = $request->input('email');
        $no_whatsapp      = $request->input('no_whatsapp');
        $alamat      = $request->input('alamat');
        $foto      = $request->input('foto');
        $password      = $request->input('password');
        $konfirmasi_password      = $request->input('konfirmasi_password');

        // return response()->json([
        //     'success' => true,
        //     'data' => $unit_prodi_id
        // ], 200);
        
        if($method == 'add'){
            if($password != $konfirmasi_password){
                return response()->json([
                    'password' => true,
                ], 200);
            }else{
                $validasi = validator()->make($request->all(),[
                    'nama_lengkap' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
                    'password' => ['required', Rules\Password::defaults()],
                ],[
                    'nama_lengkap.required' => 'Banner tidak boleh kosong',
                    'nama_lengkap.max' => 'Nama Maksimal 255 Karakter',
    
                    'email.unique' => 'Akun tersebut sudah terdaftar pada sistem, Silakan pilih nama pengguna lain...',
                    'password.required' => 'Password tidak boleh kosong',
                ]);
    
                if($validasi->fails()){
                    return response()->json(['errors' => $validasi->errors()]);
                }else{

                    User::create([
                        'name' => $nama_lengkap,
                        'unit_prodi_id' => $unit_prodi_id,
                        'email' => $email,
                        'role' => $level,
                        'password' => Hash::make($konfirmasi_password),
                        'dataAlamat' => $alamat,
                        'dataTelepon' => $no_whatsapp,
                        'dataFoto' => $foto,
                        'created_at' => Carbon::now()
                    ]);
                    
                    return response()->json([
                        'success' => true,
                    ], 200);
                }
            }
        }else if($method == 'update'){
            if($request->input('password')){
                if($password != $konfirmasi_password){
                    return response()->json([
                        'password' => true,
                    ], 200);
                }else{
                    $validasi = validator()->make($request->all(),[
                        'nama_lengkap' => ['required', 'string', 'max:255'],
                        'password' => ['required', Rules\Password::defaults()],
                    ],[
                        'nama_lengkap.required' => 'Banner tidak boleh kosong',
                        'nama_lengkap.max' => 'Nama Maksimal 255 Karakter',
                        'password.required' => 'Password tidak boleh kosong',
                    ]);
        
                    if($validasi->fails()){
                        return response()->json(['errors' => $validasi->errors()]);
                    }else{
                        if($request->input('unit_prodi_id') != 'disable'){
                            User::find($id)->update([
                                'name' => $nama_lengkap,
                                'unit_prodi_id' => $unit_prodi_id,
                                'email' => $email,
                                'role' => $level,
                                'password' => Hash::make($konfirmasi_password),
                                'dataAlamat' => $alamat,
                                'dataTelepon' => $no_whatsapp,
                                'dataFoto' => $foto,
                                'updated_at' => Carbon::now()
                            ]);
                        }else{
                            User::find($id)->update([
                                'name' => $nama_lengkap,
                                'unit_prodi_id' => 0,
                                'email' => $email,
                                'role' => $level,
                                'password' => Hash::make($konfirmasi_password),
                                'dataAlamat' => $alamat,
                                'dataTelepon' => $no_whatsapp,
                                'dataFoto' => $foto,
                                'updated_at' => Carbon::now()
                            ]);
                        }
                        
                        return response()->json([
                            'success' => true,
                        ], 200);
                    }
                }
            } else{
                if($request->input('unit_prodi_id') != 'disable'){
                    User::find($id)->update([
                        'name' => $nama_lengkap,
                        'unit_prodi_id' => $unit_prodi_id,
                        'email' => $email,
                        'role' => $level,
                        'password' => Hash::make($konfirmasi_password),
                        'dataAlamat' => $alamat,
                        'dataTelepon' => $no_whatsapp,
                        'dataFoto' => $foto,
                        'updated_at' => Carbon::now()
                    ]);
                }else{
                    User::find($id)->update([
                        'name' => $nama_lengkap,
                        'unit_prodi_id' => 0,
                        'email' => $email,
                        'role' => $level,
                        'password' => Hash::make($konfirmasi_password),
                        'dataAlamat' => $alamat,
                        'dataTelepon' => $no_whatsapp,
                        'dataFoto' => $foto,
                        'updated_at' => Carbon::now()
                    ]);
                }
                
                return response()->json([
                    'success' => true,
                ], 200);
            }
        }
        
    
    }

    public function edit($id)
    {
        $data = User::select(
            "users.id",
            "users.unit_prodi_id",
            "users.email",
            "users.role",
            "users.dataAlamat",
            "users.dataTelepon",
            "users.dataFoto",
            "data_sdm.id as name",
        )
        ->where('users.id', $id)
        ->join("data_sdm", "data_sdm.dataEmail", "=", "users.email")
        ->first();

        // $data = User::where('id', $id)->first();
        
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return response()->json([
            'success' => true,
        ], 200);
    }

}
