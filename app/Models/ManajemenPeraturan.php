<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManajemenPeraturan extends Model
{
    public $table = 'spm_peraturan';

    protected $guarded = [];

    use HasFactory;
}
