<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAkreditasi extends Model
{
    public $table = 'spm_data_akreditasi';

    protected $guarded = [];
    
    use HasFactory;
    
    public function jenisakreditasi()
    {
    	return $this->belongsTo('App\Models\DataJenisAkreditasi', 'fid_jenis_akreditasi', 'id'); 
    } 
}
