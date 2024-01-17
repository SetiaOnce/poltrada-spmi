<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataLembagaAkreditasi extends Model
{
    public $table = 'spm_data_lembaga_akreditasi';

    protected $guarded = [];
    
    use HasFactory;
}
