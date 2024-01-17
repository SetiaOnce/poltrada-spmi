<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkApp extends Model
{
    public $table = 'spm_link_app';
    
    protected $guarded = [];
    
    use HasFactory;
}
