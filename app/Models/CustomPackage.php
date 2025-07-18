<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomPackage extends Model
{
    protected $fillable = [
        'service_provider_id',
        'user_id',
        'name',
        'description',
        'features',
        'price',
        'stripe_payment_id',
        'payment_status',
    ];

    protected $casts = [
        'features' => 'array',
    ];

    public function provider()
    {
        return $this->belongsTo(User::class, 'service_provider_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
