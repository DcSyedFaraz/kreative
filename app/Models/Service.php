<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $guarded = [];
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('display_on_profile')
            ->withTimestamps();
    }
}
