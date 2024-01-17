<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanAudit extends Model
{
    public $table = 'spm_pengajuan_audit';

    protected $guarded = [];
    
    use HasFactory;
}
