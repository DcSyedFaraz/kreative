<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageItem extends Model
{
    protected $table = 'package_items';
    protected $fillable = ['package_id', 'features'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
