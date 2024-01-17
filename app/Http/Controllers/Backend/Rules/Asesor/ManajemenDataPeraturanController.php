<?php

namespace App\Http\Controllers\Backend\Rules\Asesor;

use App\Http\Controllers\Controller;
use App\Models\ManajemenPeraturan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ManajemenDataPeraturanController extends Controller
{
    protected $base = 'rules.asesor.manajemen_data.peraturan.';
    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ManajemenPeraturan::select(
                "spm_peraturan.id",
                "spm_peraturan.nama_peraturan",
                "spm_peraturan.file_pdf",
                "spm_data_jenis_peraturan.nama_jenis_peraturan as jenis_peraturan",
            )
            ->join("spm_data_jenis_peraturan", "spm_data_jenis_peraturan.id", "=", "spm_peraturan.jenis_peraturan_id")
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
