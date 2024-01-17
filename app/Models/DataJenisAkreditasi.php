<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataJenisAkreditasi extends Model
{
    public $table = 'spm_data_jenis_akreditasi';

    protected $guarded = [];
    
    use HasFactory;
}
