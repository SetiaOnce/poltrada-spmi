<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    public $table = 'spm_pengumuman';

    protected $guarded = [];
    
    use HasFactory;
}
