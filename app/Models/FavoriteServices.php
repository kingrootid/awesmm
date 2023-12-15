<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteServices extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'service_id'
    ];
}
