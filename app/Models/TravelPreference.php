<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TravelPreference extends Model
{
    use HasFactory;

    // Fix typo: 'fillabe' → 'fillable'
    protected $fillable = [
        'user_id',
        'travel_group_id',        // Add group relation
        'travel_style',
        'budget_level',
        'preferred_activities',   // Can store as JSON
        'preferred_countries',    // Can store as JSON
        'notes',
    ];

    // The user who owns this preference
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // The group this preference belongs to
    public function group()
    {
        return $this->belongsTo(TravelGroup::class, 'travel_group_id');
    }

    // Cast activities and countries as array for easy use
    protected $casts = [
        'preferred_activities' => 'array',
        'preferred_countries' => 'array',
    ];
}
