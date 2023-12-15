<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityServices extends Model
{
    use HasFactory;

    protected $fillable = [
        'services_id',
        'services_provider_id',
        'services_provider_name',
        'name',
        'type',
        'amount',
    ];
}
