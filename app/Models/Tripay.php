<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tripay extends Model
{
    use HasFactory;

    protected $fillable = [
        'group',
        'code',
        'name',
        'type',
        'fee_flat',
        'fee_percent',
        'status',
        'images'
    ];
}
