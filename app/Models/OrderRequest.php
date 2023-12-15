<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'provider_order_id',
        'provider_request_id',
        'user_id',
        'type',
        'status',
        'provider_id',
        'log_process',
        'log_respond',
    ];
}
