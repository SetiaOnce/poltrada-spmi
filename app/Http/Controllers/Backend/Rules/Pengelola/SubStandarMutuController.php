<?php

namespace App\Http\Controllers\Backend\Rules\Pengelola;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubStandarMutuController extends Controller
{
    protected $base = 'rules.pengelola.manajemen_mutu.standar_mutu.list.';
    
    public function index()
    {
        return view($this->base.'sub_standar_mutu');
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
