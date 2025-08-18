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

    /**
     * Find or create a chat room between two users, preventing duplicates
     */
    public static function findOrCreateBetweenUsers($user1, $user2, $clientId = null, $serviceProviderId = null)
    {
        // If client and service provider IDs are explicitly provided, use them
        if ($clientId && $serviceProviderId) {
            return static::firstOrCreate([
                'client_id' => $clientId,
                'service_provider_id' => $serviceProviderId,
            ]);
        }

        // Check for existing room with either combination
        $room = static::where(function ($query) use ($user1, $user2) {
                $query->where(function ($q) use ($user1, $user2) {
                    $q->where('client_id', $user1)
                      ->where('service_provider_id', $user2);
                })->orWhere(function ($q) use ($user1, $user2) {
                    $q->where('client_id', $user2)
                      ->where('service_provider_id', $user1);
                });
            })
            ->first();

        if ($room) {
            return $room;
        }

        // If no room exists, determine which user should be client and which should be service provider
        $user1Model = User::find($user1);
        $user2Model = User::find($user2);

        if ($user1Model && $user2Model) {
            // If user1 is a service provider, make user2 the client
            if ($user1Model->hasRole('service provider') && !$user2Model->hasRole('service provider')) {
                $clientId = $user2;
                $serviceProviderId = $user1;
            }
            // If user2 is a service provider, make user1 the client
            elseif ($user2Model->hasRole('service provider') && !$user1Model->hasRole('service provider')) {
                $clientId = $user1;
                $serviceProviderId = $user2;
            }
            // If both have the same role, default to user1 as client
            else {
                $clientId = $user1;
                $serviceProviderId = $user2;
            }
        } else {
            // Fallback if users not found
            $clientId = $user1;
            $serviceProviderId = $user2;
        }

        return static::create([
            'client_id' => $clientId,
            'service_provider_id' => $serviceProviderId,
        ]);
    }

    public function getUnreadCountAttribute($userId = null)
    {
        if (!$userId) {
            $userId = auth()->id();
        }

        return $this->messages()
            ->where('user_id', '!=', $userId)
            ->whereNull('read_at')
            ->count();
    }

    public function getLastMessageAttribute()
    {
        return $this->messages()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public function markMessagesAsRead($userId = null)
    {
        if (!$userId) {
            $userId = auth()->id();
        }

        return $this->messages()
            ->where('user_id', '!=', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
    }

    public function scopeWithUnreadCount($query, $userId = null)
    {
        if (!$userId) {
            $userId = auth()->id();
        }

        return $query->withCount([
            'messages as unread_count' => function($query) use ($userId) {
                $query->where('user_id', '!=', $userId)
                      ->whereNull('read_at');
            }
        ]);
    }
}
