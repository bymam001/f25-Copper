<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItineraryVote extends Model
{
    use HasFactory;

    protected $fillable = [
        'itinerary_id',
        'user_id',
        'vote',
        'comment',
    ];

    // The itinerary this vote belongs to
    public function itinerary()
    {
        return $this->belongsTo(GroupItinerary::class, 'itinerary_id');
    }

    // The user who cast the vote
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
