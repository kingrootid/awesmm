<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersSosmed extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'user_id',
        'service_name',
        'service_id',
        'target',
        'quantity',
        'price',
        'profit',
        'comments',
        'link',
        'start_count',
        'remains',
        'date',
        'from',
        'is_canceled',
        'is_refill',
        'provider',
        'status',
        'logs_order',
        'logs_status',
        'refund'
    ];
}
