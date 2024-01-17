<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisStandarMutu extends Model
{
    public $table = 'spm_jenis_standar_mutu';

    protected $guarded = [];
    
    use HasFactory;
}
