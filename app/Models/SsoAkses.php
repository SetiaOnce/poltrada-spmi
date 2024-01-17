<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SsoAkses extends Model
{
    public $table = 'sso_akses';
    
    public $timestamps = false;
    
    use HasFactory;
}
