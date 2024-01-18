<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Models\ProfileApp;
use App\Models\SsoAplikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{
  public function index()
  {
    $pegawai_token = '28TgiNDsEOblYThlLweK9KjTVJ6GBlMUVsml04cp5WPt0mHSPoaMbTgUuUXjp9i8';
    setcookie("pegawai_token", $pegawai_token, time() + 10 * 365 * 24 * 60 * 60, "/");
    $body = [
        'pegawai_token' => $_COOKIE["pegawai_token"],
        'pegawai_aplikasi' => SsoAplikasi::where('id', 23)->first()->access,
    ];
    $api_response = Http::withOptions(['verify'=>false])
    ->post('https://pegawai.poltradabali.ac.id/api/login', $body);
    $response=$api_response->getBody()->getContents();
    $get_contents = json_decode($response);
    if($get_contents->status==true) {   
        session([
            'login_akses' => true, 
            'pegawaiId'=> $get_contents->data->pegawaiId,  
            'nama'=> $get_contents->data->nama,  
            'nik'=> $get_contents->data->nik,  
            'npwp'=> $get_contents->data->npwp,  
            'nip'=> $get_contents->data->nip,
            'pin'=> $get_contents->data->pin,  
            'email'=> $get_contents->data->email,  
            'nidn'=> $get_contents->data->nidn,  
            'no_kk'=> $get_contents->data->no_kk,  
            'agama'=> $get_contents->data->agama,  
            'alamat'=> $get_contents->data->alamat,  
            'nikah'=> $get_contents->data->nikah,  
            'golongan_darah'=> $get_contents->data->golongan_darah,  
            'status'=> $get_contents->data->status,  
            'telp'=> $get_contents->data->telp,  
            'jk'=> $get_contents->data->jk,  
            'sk_cpns'=> $get_contents->data->sk_cpns,  
            'tgl_sk_cpns'=> $get_contents->data->tgl_sk_cpns,  
            'sk_pengangkatan'=> $get_contents->data->sk_pengangkatan,  
            'tgl_pengangkatan'=> $get_contents->data->tgl_pengangkatan,  
            'lembaga_pengangkatan'=> $get_contents->data->lembaga_pengangkatan,  
            'unit_kerja'=> $get_contents->data->unit_kerja,  
            'foto'=> $get_contents->data->foto,  
            'aplikasi'=> $get_contents->data->aplikasi,  
            'level'=> $get_contents->data->level,
            'key_level'=> $get_contents->data->key_level,   
        ]);
        if ($get_contents->data->key_level == 'spm-administrator' ) {
            $redirect = 'admin_dashboard';
        }if ($get_contents->data->key_level == 'spm-unitprodi' ) {
            $redirect = 'prodi_dashboard';
        }if ($get_contents->data->key_level == 'spm-asesor' ) {
            $redirect = 'asesor_dashboard';
        }if ($get_contents->data->key_level == 'spm-staff' ) {
            $redirect = 'pengelola_dashboard';
        }
        return redirect($redirect);
    }else{
        return Redirect::away('https://pegawai.poltradabali.ac.id/login');
    }
  }

  public function login(Request $request)
  {
    date_default_timezone_set("Asia/Jakarta");
    $errors					= [];
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required',
		'captcha'=>'required|captcha',
    ],[
        'email.required' => 'Email tidak boleh kosong.',
        'email.email' => 'Email tidak valid.',
        'password.required' => 'Password tidak boleh kosong.',
        'captcha.required' => 'Captcha tidak boleh kosong.',
        'captcha.captcha' => 'Captcha tidak sesuai. Refresh captcha lalu coba lagi.',
    ]);

    if($validator->fails()){
        foreach ($validator->errors()->getMessages() as $item) {
            $errors[] = $item;
        }
        $output = array("status" => FALSE, "pesan_code" => 'format_inputan', "pesan_error" => $errors);
    } else {
		try{  
            $body = [  
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'access_key' => SsoAplikasi::where('id', 23)->first()->access,
            ];
            $api_response = Http::withOptions(['verify'=>false])
            ->post('https://sso.exprodi.co.id/api/login', $body);
            $response=$api_response->getBody()->getContents();
            $get_contents = json_decode($response);
            
            if($get_contents->status==true) {   
                session([
					'login_akses' => true, 
					'pegawaiId'=> $get_contents->data->pegawaiId,  
					'nama'=> $get_contents->data->nama,  
					'nik'=> $get_contents->data->nik,  
					'npwp'=> $get_contents->data->npwp,  
					'nip'=> $get_contents->data->nip,
					'pin'=> $get_contents->data->pin,
					'email'=> $get_contents->data->email,
					'nidn'=> $get_contents->data->nidn,
					'no_kk'=> $get_contents->data->no_kk,
					'agama'=> $get_contents->data->agama,  
					'alamat'=> $get_contents->data->alamat,  
					'nikah'=> $get_contents->data->nikah,  
					'golongan_darah'=> $get_contents->data->golongan_darah,
					'status'=> $get_contents->data->status,
					'telp'=> $get_contents->data->telp,
					'jk'=> $get_contents->data->jk,
					'sk_cpns'=> $get_contents->data->sk_cpns,
					'tgl_sk_cpns'=> $get_contents->data->tgl_sk_cpns,
					'sk_pengangkatan'=> $get_contents->data->sk_pengangkatan,
					'tgl_pengangkatan'=> $get_contents->data->tgl_pengangkatan,
					'lembaga_pengangkatan'=> $get_contents->data->lembaga_pengangkatan,
					'unit_kerja'=> $get_contents->data->unit_kerja,
					'foto'=> $get_contents->data->foto,
					'aplikasi'=> $get_contents->data->aplikasi,
					'level'=> $get_contents->data->level,
					'key_level'=> $get_contents->data->key_level,
				]); 

                if (session()->get('key_level') == 'spm-administrator' ) {
                    $redirect = 'admin_dashboard';
                }if (session()->get('key_level') == 'spm-unitprodi' ) {
                    $redirect = 'prodi_dashboard';
                }if (session()->get('key_level') == 'spm-asesor' ) {
                    $redirect = 'asesor_dashboard';
                }if (session()->get('key_level') == 'spm-staff' ) {
                    $redirect = 'pengelola_dashboard';
                }
                
				$output = array(
                    "status" => TRUE,
                    "redirect" => $redirect,
                );
            } else {
                $output = array("status" => FALSE, "pesan_error"=>$get_contents->pesan_error);
            }			
        }catch(\GuzzleHttp\Exception\ConnectException $e){
            $output = array("status" => FALSE);
        } 

    }
    return response()->json($output);
  }
  public function loadLoginInfo()
  {
    $getRow = ProfileApp::where('id', 1)->first();

    $banner_login = '
        <img class="img-fluid" src="'.$getRow->banner_login.'" alt="'.$getRow->banner_login.'">
    ';
    $desc_footer = $getRow->footer;
    $response = array(
        'banner_login' => $banner_login,
        'desc_footer' => $desc_footer,
    );
    return response()->json($response);
  }
}
