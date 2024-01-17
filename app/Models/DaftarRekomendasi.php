<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarRekomendasi extends Model
{
    public $table = 'spm_daftar_rekomendasi';

    protected $guarded = [];
    
    use HasFactory;
}
