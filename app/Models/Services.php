<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'description',
        'name',
        'price',
        'profit',
        'min',
        'max',
        'provider',
        'service_id',
        'is_canceled',
        'is_refill',
        'type'
    ];
}
