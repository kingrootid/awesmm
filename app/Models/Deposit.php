<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'method',
        'method_ref',
        'amount',
        'get',
        'note',
        'fee',
        'status',
        'log_payment',
        'qr_url',
        'url_payment'
    ];
}
