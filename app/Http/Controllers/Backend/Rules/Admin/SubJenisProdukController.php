<?php

namespace App\Http\Controllers\Backend\Rules\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataJenisProduk;
use App\Models\SubJenisProduk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubJenisProdukController extends Controller
{
    public function index($id)
    {
        $data['jenis_produk'] = DataJenisProduk::where('id', $id)->first();
        $data['sub_jenis_produk'] = SubJenisProduk::latest()->where('jenis_produk_id', $id)->get();
        
        return response()->json([
            'jenisProduk' =>  $data['jenis_produk'],
            'subJenis' =>  $data['sub_jenis_produk'],
        ], 200);
    }

    public function store(Request $request)
    {
        date_default_timezone_set("Asia/Jakarta");

        $id      = $request->input('id');
        $method      = $request->input('methodform_data');
        
        $jenis_produk_id      = $request->input('jenis_produk_id');
        $sub_jenis_produk      = $request->input('sub_jenis_produk');
        
        if($method == 'add'){
            SubJenisProduk::create([
                'jenis_produk_id' => $jenis_produk_id,
                'sub_jenis_produk' => $sub_jenis_produk,
                'created_at' => Carbon::now()
            ]);
        }else if($method == 'update'){
            SubJenisProduk::find($id)->update([
                'jenis_produk_id' => $jenis_produk_id,
                'sub_jenis_produk' => $sub_jenis_produk,
                'updated_at' => Carbon::now()
            ]);
        }    
        
        return response()->json([
            'success' => true,
            'id' => $jenis_produk_id
        ], 200);
    }

    public function edit($id)
    {
        $data = SubJenisProduk::find($id);
        return response()->json([
            'data' => $data,
        ], 200);
    }

    public function destroy($id)
    {
        $jenisProdukId = SubJenisProduk::where('id', $id)->first()->jenis_produk_id;
        SubJenisProduk::find($id)->delete();
        
        return response()->json([
            'success' => true,
            'id' => $jenisProdukId,
        ], 200);
    }
}
