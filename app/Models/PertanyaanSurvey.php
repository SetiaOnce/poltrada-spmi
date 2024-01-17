<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertanyaanSurvey extends Model
{
    public $table = 'spm_pertanyaan_survey';
    
    protected $guarded = [];
    
    use HasFactory;
}
