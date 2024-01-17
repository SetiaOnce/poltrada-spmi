<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusAkreditasi extends Model
{
    public $table = 'spm_status_akreditasi';

    protected $guarded = [];

    use HasFactory;

    public function prodi()
    {
        return $this->belongsTo('App\Models\AkademikProdi', 'fid_program_studi', 'id');
    }
}
