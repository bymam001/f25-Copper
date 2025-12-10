<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GroupItinerary extends Model
{
    use HasFactory;

    protected $fillable = [
        'travel_group_id',
        'title',
        'description',
        'generated_by_ai',
        'status',
    ];

    // The travel group this itinerary belongs to
    public function group()
    {
        return $this->belongsTo(TravelGroup::class, 'travel_group_id');
    }

    // All items in this itinerary
    public function items()
    {
        return $this->hasMany(ItineraryItem::class, 'itinerary_id');
    }

    // All votes for this itinerary
    public function votes()
    {
        return $this->hasMany(ItineraryVote::class, 'itinerary_id');
    }
}
