<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManajemenProduk extends Model
{
    public $table = 'spm_produk';

    protected $guarded = [];
    
    use HasFactory;
}
