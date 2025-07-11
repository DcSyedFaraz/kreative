<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';

     protected $fillable = [
        'user_id', 'package_id', 'booking_id', 'stripe_payment_id', 'amount', 'payment_status',  
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

      public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
