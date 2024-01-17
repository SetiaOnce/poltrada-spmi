<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataHasilSurvey extends Model
{
    public $table = 'spm_data_hasil_survey';

    protected $guarded = [];
    
    use HasFactory;
}
