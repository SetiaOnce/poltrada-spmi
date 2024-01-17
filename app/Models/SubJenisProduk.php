<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubJenisProduk extends Model
{
    public $table = 'spm_sub_jenis_produk';

    protected $guarded = [];

    use HasFactory;
}
