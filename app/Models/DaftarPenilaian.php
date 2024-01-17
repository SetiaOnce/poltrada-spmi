<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarPenilaian extends Model
{
    public $table = 'daftar_penilaian';

    protected $guarded = [];
    
    use HasFactory;
}