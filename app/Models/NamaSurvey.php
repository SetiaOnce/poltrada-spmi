<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NamaSurvey extends Model
{
    public $table = 'spm_nama_survey';
    
    protected $guarded = [];
    
    use HasFactory;
}
