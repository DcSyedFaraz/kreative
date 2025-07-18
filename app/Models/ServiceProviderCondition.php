<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceProviderCondition extends Model
{
    protected $fillable = ['service_provider_id', 'conditions', 'base_price'];

    public function provider()
    {
        return $this->belongsTo(User::class, 'service_provider_id');
    }
}
