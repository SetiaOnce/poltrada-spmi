<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSurvey extends Model
{
    public $table = 'spm_event_survey';

    protected $guarded = [];
    
    use HasFactory;
}
