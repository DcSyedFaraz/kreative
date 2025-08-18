<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'service_provider_id'];

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function serviceProvider()
    {
        return $this->belongsTo(User::class, 'service_provider_id');
    }
}
