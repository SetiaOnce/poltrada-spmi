<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAsesor extends Model
{
    public $table = 'spm_data_asesor';

    protected $guarded = [];
    
    use HasFactory;
}
