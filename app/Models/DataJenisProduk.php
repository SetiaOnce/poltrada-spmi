<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataJenisProduk extends Model
{
    public $table = 'spm_data_jenis_produk';

    protected $guarded = [];
    
    use HasFactory;
}
