<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanAkhir extends Model
{
    public $table = 'spm_laporan_akhir';

    protected $guarded = [];
    
    use HasFactory;
}
