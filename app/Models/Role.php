<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $tablename = "roles";
    protected $fillable = [
        'name',
        'total_spend',
        'total_discount',
        'bonus_deposit',
        'price',
        'private'
    ];
}
