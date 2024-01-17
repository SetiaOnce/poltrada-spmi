<?php

namespace App\Http\Controllers\Backend\Rules\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfileApp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProfileAppController extends Controller
{
    protected $base = 'rules.admin.profile_app.';
    
    public function index()
    {
        $data['profile_app'] = ProfileApp::find(1); 
        return view($this->base.'index', $data);
    }

    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");
        
        $nama_aplikasi = $request->input('nama_aplikasi');
        $footer = $request->input('footer');
        $logo_header_panjang = $request->file('logo_header_panjang');
        $logo_header_kecil = $request->file('logo_header_kecil');
        $logo_aplikasi = $request->file('logo_aplikasi');
        $banner_login = $request->file('banner_login');
        $banner_detail = $request->file('banner_detail');
        
        if($request->file('logo_header_panjang')){
            $validasi = validator()->make($request->all(),[
                'logo_header_panjang' => 'required|mimes:jpg,jpeg,png|max:2048',
            ],[
                'logo_header_panjang.required' => 'Logo Header Panjang tidak boleh kosong',
                'logo_header_panjang.mimes' => 'File berekstensi jpg,jpeg,png',
                'logo_header_panjang.max' => 'Max file 1mb',
            ]);

            if($validasi->fails()){
                return response()->json(['errors' => $validasi->errors()]);
            }else{
                @unlink(public_path(ProfileApp::find(1)->logo_header_panjang));
                $name_gen = hexdec(uniqid()).'.'.$logo_header_panjang->getClientOriginalExtension();
                Image::make($logo_header_panjang)->resize(641,91)->save('img/profile-app/'.$name_gen);
                $name_logo1 = 'img/profile-app/'.$name_gen;

                ProfileApp::find(1)->update([
                    'logo_header_panjang' => $name_logo1,
                ]);
            }
        }

        if($request->file('logo_header_kecil')){
            $validasi = validator()->make($request->all(),[
                'logo_header_kecil' => 'required|mimes:jpg,jpeg,png|max:2048',
            ],[
                'logo_header_kecil.required' => 'Logo Header Kecil tidak boleh kosong',
                'logo_header_kecil.mimes' => 'File berekstensi jpg,jpeg,png',
                'logo_header_kecil.max' => 'Max file 1mb',
            ]);

            if($validasi->fails()){
                return response()->json(['errors' => $validasi->errors()]);
            }else{
                @unlink(public_path(ProfileApp::find(1)->logo_header_kecil));
                $name_logo_header_kecil = hexdec(uniqid()).'.'.$logo_header_kecil->getClientOriginalExtension();
                Image::make($logo_header_kecil)->resize(119,91)->save('img/profile-app/'.$name_logo_header_kecil);
                $name_logo2 = 'img/profile-app/'.$name_logo_header_kecil;

                ProfileApp::find(1)->update([
                    'logo_header_kecil' => $name_logo2,
                ]);
            }
        }

        if($request->file('logo_aplikasi')){
            $validasi = validator()->make($request->all(),[
                'logo_aplikasi' => 'required|mimes:jpg,jpeg,png|max:2048',
            ],[
                'logo_aplikasi.required' => 'Logo Aplikasi tidak boleh kosong',
                'logo_aplikasi.mimes' => 'File berekstensi jpg,jpeg,png',
                'logo_aplikasi.max' => 'Max file 1mb',
            ]);

            if($validasi->fails()){
                return response()->json(['errors' => $validasi->errors()]);
            }else{
                @unlink(public_path(ProfileApp::find(1)->logo_aplikasi));
                $name_logo_aplikasi = hexdec(uniqid()).'.'.$logo_aplikasi->getClientOriginalExtension();
                Image::make($logo_aplikasi)->resize(226,221)->save('img/profile-app/'.$name_logo_aplikasi);
                $name_logo3 = 'img/profile-app/'.$name_logo_aplikasi;

                ProfileApp::find(1)->update([
                    'logo_aplikasi' => $name_logo3,
                ]);
            }
        }

        if($request->file('banner_login')){
            $validasi = validator()->make($request->all(),[
                'banner_login' => 'required|mimes:jpg,jpeg,png|max:2048',
            ],[
                'banner_login.required' => 'Banner Login tidak boleh kosong',
                'banner_login.mimes' => 'File berekstensi jpg,jpeg,png',
                'banner_login.max' => 'Max file 1mb',
            ]);

            if($validasi->fails()){
                return response()->json(['errors' => $validasi->errors()]);
            }else{
                @unlink(public_path(ProfileApp::find(1)->banner_login));
                $name_banner_login = hexdec(uniqid()).'.'.$banner_login->getClientOriginalExtension();
                Image::make($banner_login)->resize(550,450)->save('img/profile-app/'.$name_banner_login);
                $name_logo5 = 'img/profile-app/'.$name_banner_login;

                ProfileApp::find(1)->update([
                    'banner_login' => $name_logo5,
                ]);
            }
        }
        
        if($request->file('banner_detail')){
            $validasi = validator()->make($request->all(),[
                'banner_detail' => 'required|mimes:jpg,jpeg,png|max:2048',
            ],[
                'banner_detail.required' => 'Banner Detail tidak boleh kosong',
                'banner_detail.mimes' => 'File berekstensi jpg,jpeg,png',
                'banner_detail.max' => 'Max file 1mb',
            ]);

            if($validasi->fails()){
                return response()->json(['errors' => $validasi->errors()]);
            }else{
                @unlink(public_path(ProfileApp::find(1)->banner_detail));
                $name_banner_detail = hexdec(uniqid()).'.'.$banner_detail->getClientOriginalExtension();
                Image::make($banner_detail)->resize(1397,570)->save('img/profile-app/'.$name_banner_detail);
                $name_logo4 = 'img/profile-app/'.$name_banner_detail;

                ProfileApp::find(1)->update([
                    'banner_detail' => $name_logo4,
                ]);
            }
        }
        
        ProfileApp::find(1)->update([
            'nama_aplikasi' => $nama_aplikasi,
            'footer' => $footer,
            'updated_at' => Carbon::now()
        ]);
        
        return response()->json([
            'success' => true,
        ], 200);
    }
}
