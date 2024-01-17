<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarTemuan extends Model
{
    public $table = 'spm_daftar_temuan';

    protected $guarded = [];
    
    use HasFactory;
}
