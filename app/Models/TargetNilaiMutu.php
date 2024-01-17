<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TargetNilaiMutu extends Model
{
    public $table = 'spm_target_nilai_mutu';

    protected $guarded = [];
    
    use HasFactory;
}
