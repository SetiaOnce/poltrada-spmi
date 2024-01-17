<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSdm extends Model
{
    public $table = 'data_sdm';

    protected $guarded = [];
    
    use HasFactory;
}
