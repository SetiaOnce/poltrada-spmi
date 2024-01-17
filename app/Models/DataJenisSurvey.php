<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataJenisSurvey extends Model
{
    public $table = 'spm_data_jenis_survey';

    protected $guarded = [];
    
    use HasFactory;
}
