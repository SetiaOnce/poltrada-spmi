<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileAkreditasi extends Model
{
    public $table = 'spm_file_akreditasi';
    
    public $timestamps = false;
    
    protected $guarded = ['id'];
    
    use HasFactory;
}
