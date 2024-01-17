<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkSurveyExternal extends Model
{
    public $table = 'spm_link_survey_external';
    
    protected $guarded = [];
    
    use HasFactory;
}
