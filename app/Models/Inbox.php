<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inbox extends Model
{

    public $table = 'spm_inbox';

    protected $guarded = [];

    use HasFactory;
}
