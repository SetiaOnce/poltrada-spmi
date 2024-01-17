<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;

class AdminProfileController extends Controller
{
    public function index(Request $request)
    {
        if(!session()->get('login_akses')) { 
            return redirect('/auth_login'); 
        } 
        $data = [
            'nama' => session()->get('nama'),
            'nik' => session()->get('nik'),
            'email' => session()->get('email'),
            'alamat' => session()->get('alamat'),
            'telp' => session()->get('telp'),
            'unit_kerja' => session()->get('unit_kerja'),
            'foto' => session()->get('foto'),
            'level' => strtoupper(session()->get('level')),
        ];
        if (session()->get('key_level') == 'spm-administrator' ) {
            return view('rules.admin.profile', $data);
        }if (session()->get('key_level') == 'spm-unitprodi' ) {
            return view('rules.prodi.profile', $data);
        }if (session()->get('key_level') == 'spm-asesor' ) {
            return view('rules.asesor.profile', $data);
        }if (session()->get('key_level') == 'spm-staff' ) {
            return view('rules.pengelola.profile', $data);
        }
    }

    public function SinkronisasiData()
    {
        date_default_timezone_set("Asia/Jakarta");

        $email = Auth::user()->email;

        $response = Http::withOptions(['verify'=>false])
        ->post('https://kepegawaian.ptdisttd.ac.id/api/detailPegawai', [
            'username' => 'esurat-api',
            'password' => '123456',
            'email' => $email
        ]);

        $data = json_decode($response, true);
        
        if($data){
            
            User::where('email', $email)->update([
                'name' => $data['data']['dataNama'],
                'email' => $data['data']['dataEmail'],
                'dataAlamat' => $data['data']['dataAlamat'],
                'dataTelepon' => $data['data']['dataTelepon'],
                'dataFoto' => $data['data']['dataFoto'],
                'updated_at' => Carbon::now()
            ]);

            $data_user = User::where('email', $email)->first();
            
            return response()->json([
                'success' => true,
                'data' => $data_user
            ], 200);
        }else{
            return response()->json([
                'error' => true,
            ], 200);
        }        

    }

    public function ProfileResetPassword(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        $password_lama = $request->input('current_password');
        $password_baru = $request->input('password');
        $konfirmasi_password = $request->input('password_confirmation');
        
        $hashPassword = Auth::user()->password;
        
        if(Hash::check($password_lama, $hashPassword)){
            if($password_baru != $konfirmasi_password){
                return response()->json([
                    'notMatch' => true,
                ], 200);
            }else{
                $validasi = validator()->make($request->all(),[
                    'password' => ['required','min:6',Rules\Password::defaults()],
                ],[
                    'password.required' => 'Password tidak boleh kosong',
                    'password.min' => 'Password Minimal 6 Karakter',
                ]);
        
                if($validasi->fails()){
                    return response()->json(['errors' => $validasi->errors()]);
                }else{
                    User::find(Auth::user()->id)->update([
                        'password' => Hash::make($konfirmasi_password),
                        'updated_at' => Carbon::now()
                    ]);
                    
                    return response()->json([
                        'success' => true,
                    ], 200);
                }
            }
        }else{
            return response()->json([
                'wrongPass' => true,
                'data' => $password_lama,
            ], 200);
        }

    }
}
