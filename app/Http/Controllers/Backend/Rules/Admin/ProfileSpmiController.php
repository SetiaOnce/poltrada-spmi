<?php

namespace App\Http\Controllers\Backend\Rules\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfileSPMI;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ProfileSpmiController extends Controller
{
    protected $base = 'rules.admin.profile_spmi.';
    
    public function index()
    {
        $data['profile_spmi'] = ProfileSPMI::find(1);
        
        return view($this->base.'index', $data);
    }

    public function VisiMisiUpdate(Request $request)
    {
        ProfileSPMI::find(1)->update([
            'visi_misi' => $request->input('visi_misi'),
            'updated_at' => Carbon::now(),
        ]);

        return response()->json([
            'success' => true,
        ], 200);
    }

    public function FungsiTugasUpdate(Request $request)
    {
        ProfileSPMI::find(1)->update([
            'fungsi_tugas' => $request->input('fungsi_tugas'),
            'updated_at' => Carbon::now(),
        ]);
        
        return response()->json([
            'success' => true,
        ], 200);
    }
    
    public function StrukturOrganisasi(Request $request)
    {
        $struktur_organisasi = $request->file('gambar_struktur');
        $deskrip_struktur = $request->input('deskripsi');
        
        if($request->file('gambar_struktur')){
            $validasi = validator()->make($request->all(),[
                'gambar_struktur' => 'required|mimes:jpg,jpeg,png|max:2048',
            ],[
                'gambar_struktur.required' => 'Gambar Struktur tidak boleh kosong',
                'gambar_struktur.mimes' => 'File berekstensi jpg,jpeg,png',
                'gambar_struktur.max' => 'Max file 2mb',
            ]);

            if($validasi->fails()){
                return response()->json(['errors' => $validasi->errors()]);
            }else{
                @unlink(public_path(ProfileSPMI::find(1)->struktur_organisasi));
                
                $name_gen = hexdec(uniqid()).'.'.$struktur_organisasi->getClientOriginalExtension();

                Image::make($struktur_organisasi)->resize(975,563)->save('img/struktur/'.$name_gen);
                $save_url = 'img/struktur/'.$name_gen;

                ProfileSPMI::find(1)->update([
                    'struktur_organisasi' => $save_url,
                ]);
                
            }
        }
        ProfileSPMI::find(1)->update([
            'deskrip_struktur' => $deskrip_struktur,
            'updated_at' => Carbon::now()
        ]);
        
        return response()->json([
            'success' => true,
            'struktur' => $deskrip_struktur
        ], 200);
    }
}
