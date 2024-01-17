<?php

namespace App\Http\Controllers\Backend\Rules\Prodi;

use App\Http\Controllers\Controller;
use App\Models\ManajemenProduk;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class ManajemenDataProdukController extends Controller
{
    protected $base = 'rules.prodi.manajemen_data.produk.';
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ManajemenProduk::select(
                "spm_produk.id",
                "spm_produk.nama_produk",
                "spm_produk.file_pdf",
                "spm_data_jenis_produk.nama_jenis_produk as jenis_produk",
            )
            ->join("spm_data_jenis_produk", "spm_data_jenis_produk.id", "=", "spm_produk.jenis_produk_id")
            ->orderBy('spm_produk.created_at', 'DESC')
            ->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('pdf', function($row) {
                        return '<a href="'.asset(($row->file_pdf)).'" data-bs-original-title="Lihat File Pdf" data-bs-placement="top" data-bs-toggle="tooltip" target="_blank">
                        <img src="'.asset(('img/pdf-image.jpg')).'" alt="avatar-4" class=" avatar-md">
                        </a>';
                    })         
                    ->rawColumns(['pdf'])
                    ->make(true);
        }
        
        return view($this->base.'index');
    }

    public function create()
    {

    }

    public function params($id=null)
    {

    }
    public function store()
    {

    }

    public function edit($id)
    {

    }

    public function update($id)
    {

    }

    public function destroy($id)
    {

    }

    public function detail($id)
    {

    }
}
