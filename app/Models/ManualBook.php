<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManualBook extends Model
{
    public $table = 'spm_manual_book';

    protected $guarded = [];
    
    use HasFactory;
}
