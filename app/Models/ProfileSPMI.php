<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileSPMI extends Model
{
    public $table = 'spm_profile_spmi';
    
    protected $guarded = [];

    use HasFactory;
}
