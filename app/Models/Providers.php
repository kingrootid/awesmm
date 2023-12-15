<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Providers extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'api_key',
        'api_url_order',
        'api_url_status',
        'api_url_service',
        'api_url_profile',
        'api_url_refill',
        'api_id',
        'markup',
        'type'
    ];
}
