<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class   Package extends Model
{
    protected $table = 'packages';
    protected $fillable = ['user_id', 'name', 'description', 'price'];

    public function items()
    {
        return $this->hasMany(PackageItem::class);  
    }

}
