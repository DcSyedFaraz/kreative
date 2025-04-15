<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    protected $fillable = ['name', 'description'];
    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withPivot('display_on_profile')
            ->withTimestamps();
    }
}
