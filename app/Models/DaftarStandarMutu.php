<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarStandarMutu extends Model
{
    public $table = 'spm_daftar_standar_mutu';

    protected $guarded = [];
    
    use HasFactory;
}
