<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataJenisPeraturan extends Model
{
    public $table = 'spm_data_jenis_peraturan';

    protected $guarded = [];
    
    use HasFactory;
}
