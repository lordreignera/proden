<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistributorApplication extends Model
{
    protected $fillable = [
        'full_name',
        'phone',
        'email',
        'business_name',
        'district',
        'address',
        'experience',
        'message',
        'status',
        'contacted_at',
    ];

    protected $casts = [
        'contacted_at' => 'datetime',
    ];
}
