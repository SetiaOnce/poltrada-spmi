<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPendukung extends Model
{
    public $table = 'spm_dokumen_pendukung';

    protected $guarded = [];
    
    use HasFactory;
}
