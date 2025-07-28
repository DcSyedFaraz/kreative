<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageOption extends Model
{
    protected $fillable = [
        'service_provider_id',
        'name',
        'base_price',
    ];

    public function provider()
    {
        return $this->belongsTo(User::class, 'service_provider_id');
    }
}
