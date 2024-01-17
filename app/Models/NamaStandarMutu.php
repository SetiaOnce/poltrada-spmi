<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NamaStandarMutu extends Model
{
    public $table = 'nama_standar_mutu';

    protected $guarded = [];
    
    use HasFactory;
}
